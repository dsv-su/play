<?php

namespace App\Http\Controllers;

use App\Http\Requests\BulkEditRequest;
use App\Models\Course;
use App\Models\CoursesettingsUsers;
use App\Models\IndividualPermission;
use App\Models\ManualPresentation;
use App\Models\Permission;
use App\Models\Presenter;
use App\Services\Course\CourseResolver;
use App\Services\Filters\VisibilityFilter;
use App\Services\Ldap\SukatUser;
use App\Services\Notify\PlayStoreNotify;
use App\Services\PacketHandler\EditPackage;
use App\Models\Stream;
use App\Models\Tag;
use App\Models\Video;
use App\Models\VideoCourse;
use App\Models\VideoPermission;
use App\Models\VideoPresenter;
use App\Models\VideoTag;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class EditController extends Controller
{
    protected bool $upload = false;

    public function __construct()
    {
        $this->middleware('redirect-links');
        $this->middleware('edit-permission')->except(['bulkEditShow','bulkEditStore']);
    }

    public function show(CourseResolver $resolver, Video $video, VisibilityFilter $visibility)
    {
        // Eager-load
        $video->load([
            'presenters',
            'courses:id,name,name_en,designation,semester,year',
            'individualPermissions'
            => function ($q) use ($video) {
            $q->where('video_id', $video->id);
        }]);

        $username = app()->make('play_username');
        $role     = app()->make('play_role');

        // Base collections we’ll pass to the view
        $permissions            = Permission::all();
        $presenters             = $video->presenters;
        $individual_permissions = $video->individualPermissions;

        //Allowed courses
        $result = $resolver->getCoursesForUser($username, $role);

        $courses = $result['courses'];
        $allowedCourseIds = $result['allowedCourseIds'];

        // Permission level for this specific video
        $userIsManager = $video->courses
            ->pluck('id')
            ->intersect($daisyCourseIds ?? [])
            ->isNotEmpty();

        if ($role === 'Administrator' || $userIsManager || $video->delete_setting) {
            $user_permission = 'delete';
        } elseif ($video->edit_setting) {
            $user_permission = 'edit';
        } else {
            $user_permission = 'read';
        }
        $type = 'edit';
        // Already-associated courses
        $associatedCourseIds = $video->courses->pluck('id')->all();


        //User lacks edit/delete
        //abort_unless(in_array($user_permission, ['edit', 'delete'], true), 401);

        return view('manage.edit', compact(
            'video',
            'permissions',
            'presenters',
            'individual_permissions',
            'user_permission',
            'courses',
            'allowedCourseIds',
            'type',
            'associatedCourseIds'
        ));
    }

    public function edit(Video $video, Request $request)
    {
        if ($request->isMethod('post')) {

            // 1) Validate upfront
            $data = $request->validate([
                'title'                   => ['required','string','max:255'],
                'title_en'                => ['nullable','string','max:255'],
                'description'             => ['nullable','string'],
                'recording_date'          => ['required','date_format:Y-m-d'],
                'presenters'              => ['array'],
                'playback'                => ['required','integer'], // 1=public, 4=external, else private
                'individualpermission'    => ['array'],
                'selected-courses'        => ['nullable','array'],
                'selected-courses.*'      => ['nullable','integer'],
                'tags'                    => ['nullable','array'],
                'audio'                   => ['array'],
                'streamVisibility'        => ['array'],
                'visibility'              => ['nullable','in:visible,private,unlisted'],
                'download'                => ['nullable'],
                'category'                => ['nullable','integer'],
                'autosub'                 => ['nullable', 'bool'],
                'autosub_language'        => ['nullable', 'string'],
                'add_sub'                 => ['array'],
                'uploadedSubLanguage'     => ['required_with:add_sub','array']
            ]);

            $presentation = ManualPresentation::create();
            DB::transaction(function () use ($request, $video, $presentation, $data) {

                $presentation->pkg_id = $video->id;
                $presentation->type = 'edit';

                // 2) Update basic video fields
                $video->fill([
                    'title'       => $data['title'],
                    'title_en'    => $data['title_en'] ?? null,
                    'description' => $data['description'] ?? null,
                    'creation'    => Carbon::createFromFormat('Y-m-d', $data['recording_date'])->timestamp,
                ]);

                $presentation->fill([
                    'title'       => $data['title'],
                    'title_en'    => $data['title_en'] ?? null,
                    'description' => $data['description'] ?? null,
                    'created'    => Carbon::createFromFormat('Y-m-d', $data['recording_date'])->timestamp,
                ]);


                // Visibility
                if (!empty($data['visibility'])) {
                    switch ($data['visibility']) {
                        case 'visible':
                            $video->visibility = true;
                            $video->unlisted   = false;
                            $presentation->visibility = true;
                            $presentation->unlisted = false;
                            break;
                        case 'private':
                            $video->visibility = false;
                            $video->unlisted   = false;
                            $presentation->visibility = false;
                            $presentation->unlisted = false;
                            break;
                        case 'unlisted':
                            $video->visibility = false;
                            $video->unlisted   = true;
                            $presentation->visibility = false;
                            $presentation->unlisted = true;
                            break;
                    }
                }

                // Download + Category
                $video->download = $request->boolean('download');
                if (isset($data['category'])) {
                    $video->category_id = $data['category'];
                }

                $video->save();

                // 3) Presenters (clear then recreate to honor changed ordering/selection)
                VideoPresenter::where('video_id', $video->id)->delete();

                $presenter_array[] = [];
                
                foreach ($data['presenters'] ?? [] as $p) {
                    if (!$p['name']) {
                        continue;
                    }

                    if ($p['type'] === 'external') {
                        // Match by name + description to avoid duplicates
                        $presenter = Presenter::firstOrCreate(
                            ['name' => $p['name'], 'description' => 'external'],
                            []
                        );
                    } else {
                        // Internal presenters keyed by username
                        $presenter = Presenter::firstOrCreate(
                            ['username' => $p['uid'], 'description' => 'sukat'],
                            ['name' => $p['name']]
                        );
                    }

                    // Keep names fresh (people change names)
                    if ($presenter->name !== $p['name']) {
                        $presenter->name = $p['name'];
                        $presenter->save();
                    }

                    VideoPresenter::create([
                        'video_id'     => $video->id,
                        'presenter_id' => $presenter->id,
                        'role'         => $p['role'] // optional if you want to store role
                    ]);
                    $presenter_array[] = $presenter->username;
                }
                //Presenter array to ManualPresentation instance
                $presentation->presenters = $presenter_array;


                // 4) Group permission for the video
                //    Normalize type from permission id
                $permId = (int) $data['playback'];
                $type   = match ($permId) {
                    1       => 'public',
                    4       => 'external',
                    default => 'private',
                };

                VideoPermission::updateOrCreate(
                    ['video_id' => $video->id],
                    ['permission_id' => $permId, 'type' => $type]
                );

                // 5) Individual permissions
                IndividualPermission::where('video_id', $video->id)->delete();

                if (!empty($data['individualpermission'])) {
                    foreach ($data['individualpermission'] as $perm) {
                        $username   = $perm['uid']        ?? null;      // maps to your 'username' column
                        $name       = trim($perm['name']  ?? '');
                        $permission = $perm['permission'] ?? 'read';    // default if missing

                        if (!$username || $name === '') {
                            continue; // skip incomplete entries
                        }

                        IndividualPermission::updateOrCreate(
                            ['video_id' => $video->id, 'username' => $username],
                            ['name' => $name, 'permission' => $permission]
                        );
                    }
                }


                // 6) Courses
                VideoCourse::where('video_id', $video->id)->delete();
                if (!empty($data['selected-courses'])) {
                    foreach ($data['selected-courses'] as $courseId) {
                        VideoCourse::updateOrCreate(
                            ['video_id' => $video->id, 'course_id' => $courseId],
                            []
                        );
                        //Presentation
                        $course = Course::find($courseId);
                        $courses[] = \Illuminate\Support\Collection::make([
                            'designation' => $course->designation,
                            'semester' => Str::lower($course->semester) . $course->year
                        ]);
                    }
                    $presentation->courses = $courses;
                }

                // 7) Tags
                VideoTag::where('video_id', $video->id)->delete();
                if (!empty($data['tags'])) {
                    foreach ($data['tags'] as $tag) {
                        VideoTag::updateOrCreate(
                            ['video_id' => $video->id, 'tag_id' => $tag['id']],
                            []
                        );
                        $t[] = $tag['name'];
                    }
                    $presentation->tags = $t;
                }

                // 8) Streams (audio/hidden flags)
                $streams = Stream::where('video_id', $video->id)->get();

                $audio   = $data['audio'] ?? null;
                $hidden  = $data['streamVisibility'] ?? null;

                // Determine the single stream that should have audio
                $selectedAudioName = is_array($audio) ? array_key_first($audio) : $audio;

                foreach ($streams as $stream) {
                    // Audio: exactly one is true
                    $newAudio = ($stream->name === $selectedAudioName);

                    // Hidden:
                    //  - If $hidden is null, force all to false
                    //  - Else look up by name, defaulting to false
                    $newHidden = is_null($hidden) ? false : ((bool)($hidden[$stream->name] ?? false));

                    // Only persist if something actually changed
                    if ((bool)$stream->audio !== $newAudio || (bool)$stream->hidden !== $newHidden) {
                        $stream->audio  = $newAudio;
                        $stream->hidden = $newHidden;
                        $stream->save();
                    }
                    //Prepare source for pkg
                    $map = [
                        0 => false,
                        1 => true,
                    ];

                    $sources[$stream->name]['playAudio'] = $map[$stream->audio];
                    $presentation->sources = $sources;

                }
                // 9) Subtitles
                 if (!empty($data['autosub'])) {
                     $presentation->autogenerate_subtitles = true;
                    $presentation->sublanguage = $data['autosub_language'] ?? null;
                }

                 //Manually uploaded subtitles
                if (!empty($data['add_sub'])) {
                    foreach ($data['add_sub'] as $filename => $path) {
                        // Normalize the incoming relative path
                        $path = ltrim(trim($path), '/');
                        $folder    = rtrim($presentation->local, '/').'/subtitle/';
                        $finalPath = '/' . $this->storage() . '/' .$folder.$filename;

                        // 1) Confirm the file exists on the disk
                        if (!Storage::disk('local')->exists($path)) {
                            // Extra diagnostics: check absolute public path and storage path
                            $absPublicShown = public_path('storage/'.$path);
                            $absStorageShown = Storage::disk('public')->path($path);

                            \Log::warning('Subtitle missing on public disk', [
                                'relative_path'     => $path,
                                'public_storage_symlink' => $absPublicShown,
                                'storage_public_real'    => $absStorageShown,
                            ]);

                            // Debug
                            // throw new \RuntimeException("Missing file on public disk: {$path}");
                            continue;
                        }

                        // 2) Stream it across (less memory)
                        $stream = Storage::disk('local')->readStream($path);
                        if ($stream === false) {
                            \Log::error('Unable to open read stream for subtitle', ['path' => $path]);
                            continue;
                        }

                        $ok = Storage::disk('play-store')->put($finalPath, $stream);
                        if (is_resource($stream)) {
                            fclose($stream);
                        }

                        if (!$ok) {
                            \Log::error('Failed writing subtitle to play-store', [
                                'dest' => $finalPath,
                                'src'  => $path,
                            ]);
                        }
                        //Store filename
                        $subtitles_filename[] = $filename;
                    }
                }

                //If uploaded subtitles
                if($data['uploadedSubLanguage'] ?? false) {
                    //Set upload true
                    $this->upload = true;

                    // A mapping from the uploaded language key to the display name
                    $map = [
                        'english' => 'English',
                        'swedish' => 'Svenska',
                    ];

                    $subtitles = []; // Collect all subtitles here
                    $index = 0;
                    foreach ($data['uploadedSubLanguage'] as $subs) {
                        if (isset($map[$subs])) {
                            $subtitles[$map[$subs]] = 'subtitle/' . $subtitles_filename[$index];
                            $index++;
                        }
                    }

                    // Store in the database
                    $presentation->subtitles = $subtitles;
                }

                if($this->upload) {
                    $presentation->upload_dir = '/data0/incoming/'. $presentation->local;
                }

                //Change status presentation
                $presentation->status = 'stored';

                //Save presentation
                $presentation->save();

                //Change status video
                $video->state = 0;
                $video->save();

            });

            // 9) Cache & background work
            Cache::flush();

            // Send notify
            $notify = new PlayStoreNotify($presentation);
            $notify->sendSuccess('edit');

            // Clear download storage
            Artisan::call('download:clear');

            // 10) Redirect
            $links = session('links') ?? [];
            /*if (count($links) <= 3) {
                return redirect()->route('home')
                    ->with('message', __("Processing the update"));
            }*/
            return redirect($links[1])
                ->with('message', __("Processing the update"));
        }

        return view('videos.edit', compact('video'));
    }


    public function bulkEditShow(CourseResolver $resolver, BulkEditRequest $request, VisibilityFilter $visibility): View|RedirectResponse
    {
        $username = app()->make('play_username');
        $role     = app()->make('play_role');

        $result = $resolver->getCoursesForUser($username, $role);

        $courses = $result['courses'];
        $allowedCourseIds = $result['allowedCourseIds'];

        $courses = Course::query()->whereKey($allowedCourseIds)->get();

        $ids = collect($request->input('videos', []))
            ->filter()
            ->unique()
            ->values();

        if ($ids->isEmpty()) {
            return back()->with('warning', 'No videos selected.');
        }

        $videos = $visibility
            ->filter(Video::query()->whereKey($ids)->get())
            ->filter->edit
            ->values();

        if ($videos->isEmpty()) {
            return back()->with('warning', 'No editable videos matched your selection.');
        }

        $type = 'bulk';

        return view('manage.bulk-edit', compact('videos', 'courses', 'type'));
    }

    public function bulkEditSave(Request $request)
    {

        // 1) Validate + normalize inputs
        $data = $request->validate([
            'videos'                 => ['required'],
            'visibility'             => ['string', 'in:visible,private,unlisted'],
            'download'               => ['nullable'],
            'selected-courses'       => ['nullable', 'array'],
            'selected-courses.*'     => ['nullable','integer'],
            'tags'                   => ['nullable'],
            'presenters'             => ['array'],
            'bulkdownload'           => ['nullable'],
            'bulkvisibility'         => ['nullable'],
            'bulkcourse'             => ['nullable'],
            'bulkpresenter'          => ['nullable'],
            'bulktag'                => ['nullable'],
        ]);

        $videoIds = collect(json_decode($data['videos'], true))->pluck('id');

        if ($videoIds->isEmpty()) {
            return response()->json(['message' => 'No videos provided.'], 422);
        }

        $visibility   = $data['visibility'];
        $download     = filter_var($request->input('download'), FILTER_VALIDATE_BOOLEAN);

        //Overwrite switches
        $bulkdownload     = filter_var($request->input('bulkdownload'), FILTER_VALIDATE_BOOLEAN);
        $bulkvisibility     = filter_var($request->input('bulkvisibility'), FILTER_VALIDATE_BOOLEAN);
        $bulkcourse     = filter_var($request->input('bulkcourse'), FILTER_VALIDATE_BOOLEAN);
        $bulkpresenter     = filter_var($request->input('bulkpresenter'), FILTER_VALIDATE_BOOLEAN);
        $bulktag     = filter_var($request->input('bulktag'), FILTER_VALIDATE_BOOLEAN);

        $courseIds = collect($data['selected-courses'] ?? [])
            ->flatten()
            ->filter()
            ->unique()
            ->values();

        $rawTags = Arr::get($data, 'tags', []);
        $tagIds = collect($rawTags)->pluck('id')->values();

        // Normalize presenters: accept array of dicts OR nested arrays of dicts
        $rawPresenters = Arr::get($data, 'presenters', []);
        //dd($rawPresenters);
        $presenterPayloads = collect($rawPresenters)
            ->filter(fn($p) => is_array($p) && (isset($p['uid']) || isset($p['name'])))
            ->map(function ($p) {
                $uid  = $p['uid'] ?? null;
                $name = trim($p['name'] ?? '');

                return [
                    'username'    => $uid,
                    'name'        => $name,
                    'description' => trim($p['role'] ?? ''),
                    'pkg'         => empty($uid) ? $name : $uid,
                ];
            })
            ->unique(fn($p) => $p['username'] ?: $p['name'])
            ->values();

        // Fetch + filter videos the caller is allowed to touch
        $videos = \App\Models\Video::whereIn('id', $videoIds)->get();
        $visibilityFilter = app(VisibilityFilter::class);

        $filteredIds = $visibilityFilter->filter($videos)->pluck('id');
        if ($filteredIds->isEmpty()) {
            return response()->json(['message' => 'No videos matched your permissions.'], 403);
        }

        // Re-load clean instances (no extra attributes/casts from prior filter)
        $videos = \App\Models\Video::whereIn('id', $filteredIds)->get();

        // Precompute visibility flags
        [$isVisible, $isUnlisted] = match ($visibility) {
            'visible'  => [true,  false],
            'private'  => [false, false],
            'unlisted' => [false, true],
        };

        DB::transaction(function () use (
            $videos, $isVisible, $isUnlisted, $download, $bulkdownload, $bulkvisibility,
            $bulkcourse, $bulkpresenter, $bulktag, $courseIds, $tagIds, $presenterPayloads
        ) {

            // Upsert/resolve presenters once (prefer username uniqueness, fallback to name)
            $presenterIds = collect();
            $presenters_pkg = $courses_pkg = $tags_pkg = [];
            if($bulkpresenter) {
                if ($presenterPayloads->isNotEmpty()) {
                    $presenterModel = \App\Models\Presenter::class;

                    // Look up by username where available
                    $byUsername = $presenterPayloads->pluck('username')->filter()->unique();
                    $existingByUsername = $byUsername->isNotEmpty()
                        ? $presenterModel::whereIn('username', $byUsername)->get()->keyBy('username')
                        : collect();

                    $toCreate = [];
                    foreach ($presenterPayloads as $p) {
                        $username = $p['username'];
                        if ($username && $existingByUsername->has($username)) {
                            // Maybe update mutable fields
                            $presenter = $existingByUsername[$username];
                            $presenter->name = $p['name'] ?: ($presenter->name ?? '');
                            $presenter->description = $p['description'] ?: ($presenter->description ?? '');
                            $presenter->save();
                        } else {
                            $toCreate[] = [
                                'username'    => $username,
                                'name'        => $p['name'],
                                'description' => $p['description'],
                            ];
                        }
                        //Package
                        $presenters_pkg[] = $p['pkg'];
                    }
                    if (!empty($toCreate)) {
                        // Use upsert on username (unique) to avoid races
                        $presenterModel::upsert(
                            $toCreate,
                            ['username'],
                            ['name', 'description']
                        );
                    }

                    // Re-read all involved presenters to get IDs
                    $presenterIds = $presenterModel::query()
                        ->when($byUsername->isNotEmpty(), fn($q) => $q->orWhereIn('username', $byUsername))
                        ->orWhereIn('name', $presenterPayloads->pluck('name')->filter()->unique())
                        ->pluck('id');
                } //End presenter
            } //end presenter overwrite

            // Apply updates per video
            foreach ($videos as $video) {
                //Check if overwrite is active
                if($bulkvisibility) {
                    $video->visibility = $isVisible;
                    $video->unlisted   = $isUnlisted;
                }
                //Check if overwrite is active
                if($bulkdownload) {
                    $video->download   = $download;
                }

                //Change status video
                $video->state = 0;

                $video->save();

                // Prefer relationship syncs if relations exist on the Video model.
                // Fallback to pivot models
                if($bulkcourse) {
                    if (method_exists($video, 'courses') && $courseIds->isNotEmpty()) {
                        $video->courses()->sync($courseIds->all());
                    } elseif ($courseIds->isNotEmpty()) {
                        // Pivot fallback
                        \App\Models\VideoCourse::where('video_id', $video->id)->delete();
                        foreach ($courseIds as $cid) {
                            \App\Models\VideoCourse::updateOrCreate([
                                'video_id'  => $video->id,
                                'course_id' => $cid,
                            ]);
                        }
                    } else {$video->courses()->sync([]);} //end coursesync
                } //end overwrite

                if($bulktag) {
                    if (method_exists($video, 'tags')) {
                        $video->tags()->sync($tagIds->all());
                    } else {
                        \App\Models\VideoTag::where('video_id', $video->id)->delete();
                        foreach ($tagIds as $tid) {
                            \App\Models\VideoTag::updateOrCreate([
                                'video_id' => $video->id,
                                'tag_id'   => $tid,
                            ]);
                        }
                    } //end tag
                }

                if($bulkpresenter) {
                    if (method_exists($video, 'presenters')) {
                        $video->presenters()->sync($presenterIds->all());
                    } else {
                        \App\Models\VideoPresenter::where('video_id', $video->id)->delete();
                        foreach ($presenterIds as $pid) {
                            \App\Models\VideoPresenter::updateOrCreate([
                                'video_id'     => $video->id,
                                'presenter_id' => $pid,
                            ]);
                        }
                    } //end presenters
                } //end overwrite
            } //end foreach

            //Build Package
            foreach ($courseIds as $cid) {
                $c = \App\Models\Course::find($cid);
                $courses_pkg[] = \Illuminate\Support\Collection::make([
                    'designation' => $c->designation,
                    'semester' => Str::lower($c->semester) . $c->year
                ]);
            }
            foreach ($tagIds as $tid) {
                $t = \App\Models\Tag::find($tid);
                $tags_pkg[] = $t['name'];
            }

            //Store ManualPresentation
            $now = now();

            $videos->chunk(500)->each(function ($chunk) use ($now, $presenters_pkg, $courses_pkg, $tags_pkg) {
                foreach ($chunk as $v) {
                    $presentation = ManualPresentation::create([
                        'pkg_id'     => $v->id,
                        'status'     => 'stored',
                        'type'       => 'edit',
                        'title'      => $v->title,
                        'title_en'   => $v->title_en,
                        'presenters' => $presenters_pkg,
                        'visibility' => $v->visibility,
                        'unlisted'   => $v->unlisted,
                        'courses'    => $courses_pkg,
                        'tags'       => $tags_pkg,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);

                    // Send notify
                    $notify = new PlayStoreNotify($presentation);
                    $notify->sendSuccess('edit');
                }
            }); //end MP store
        }); // end transaction

        return redirect()->route('my.presentations')->with('message', __("The presentations have been successfully updated."));
    }


    public function destroy(Video $video, Request $request)
    {
        // Optional: policy check
        // $this->authorize('delete', $video);

        // Keep a snapshot for the post-commit notification payload
        $videoSnapshot = $video->replicate();

        try {
            DB::transaction(function () use ($video) {
                $videoId = $video->id;
                //Detach
                $video->courses()->detach();
                $video->tags()->detach();
                $video->presenters()->detach();
                $video->permissions()->detach();
                //Bulk delete
                \App\Models\CourseadminPermission::where('video_id', $videoId)->delete();
                \App\Models\IndividualPermission::where('video_id', $videoId)->delete();
                \App\Models\VideoStat::where('video_id', $videoId)->delete();


                // Streams + resolutions
                $streamIds = \App\Models\Stream::where('video_id', $videoId)->pluck('id');
                if ($streamIds->isNotEmpty()) {
                    \App\Models\StreamResolution::whereIn('stream_id', $streamIds)->delete();
                    \App\Models\Stream::whereIn('id', $streamIds)->delete();
                }

                // Finally the video itself
                $video->delete();
            });

            // Notify only after the transaction has committed successfully

            //$notify = new \App\Services\PlayStoreNotify($videoSnapshot);
            DB::afterCommit(fn() => (new PlayStoreNotify($videoSnapshot))->sendDelete());
            return back()->with('success', true)
                ->with('message', __('The presentation has been deleted'));
            /*if ($notify->sendDelete()) {
                return back()->with('success', true)
                    ->with('message', __('The presentation has been deleted'));
            }

            return back()->with('error', true)
                ->with('message', __('The presentation has not been deleted'));*/

        } catch (Throwable $e) {
            report($e);
            // Transaction is already rolled back by DB::transaction on exception
            return back()->with('error', true)
                ->with('message', __('The presentation has not been deleted').': '.$e->getMessage());
        }
    }



    private function storage()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['nfs']['storage'];
    }
}
