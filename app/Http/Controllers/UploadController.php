<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Jobs\JobUploadProgressNotification;
use App\Models\ManualPresentation;
use App\Models\Permission;
use App\Services\Course\CourseResolver;
use App\Services\Notify\PlayStoreNotify;
use App\Models\VideoPermission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Pion\Laravel\ChunkUpload\Exceptions\UploadFailedException;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Storage;

class UploadController extends Controller
{
    protected $source = [];

    public function init_upload()
    {
        return ManualPresentation::create();
    }

    public function create(CourseResolver $resolver, Request $request)
    {
        $type = 'upload';
        $username = app()->make('play_username');
        $role     = app()->make('play_role');
        $permissions = Permission::all();
        $user_permission = 'delete';

        //Allowed courses
        $result = $resolver->getCoursesForUser($username, $role);
        $courses = $result['courses'];
        //Sort after year
        $courses = $courses->sortByDesc('year')->values();
        $allowedCourseIds = $result['allowedCourseIds'];

        // Prepopulate from the latest draft by this user
        $prepopulate = $request->boolean('prepopulate');
        $presentation = null;

        if ($prepopulate) {
            $presentation = ManualPresentation::query()
                ->where('user', $username)
                ->where('status', 'manual')
                ->orderByDesc('updated_at')
                ->first();
        }

        // If nothing to prepopulate, init
        $presentation = $presentation ?? $this->init_upload();

        return view('upload.index', [
            'type' => $type,
            'presentation' => $presentation,
            'permissions' => $permissions,
            'courses' => $courses,
            'allowedCourseIds' => $allowedCourseIds,
            'user_permission' => $user_permission
        ]);
    }

    public function step1($id, Request $request)
    {
        if (! $request->isMethod('post')) {
            return back()->withInput();
        }

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
            'visibility'              => ['nullable','in:visible,private,unlisted'],
            'download'                => ['nullable'],
            'category'                => ['nullable','integer'],
            'autosub'                 => ['nullable', 'bool'],
            'autosub_language'        => ['nullable', 'string'],
            'add_sub'                 => ['array'],
            'uploadedSubLanguage'     => ['required_with:add_sub','array']
        ]);

        //Retrive MP
        $manualPresentation = ManualPresentation::find($id);

        $presenters = [];

        // Always include the current play_username
        $presenters[] = app()->make('play_username');

        if ($request->filled('presenters')) {
            $inputPresenters = collect($request->input('presenters', []))
                ->map(function ($p) {
                    // String
                    if (is_string($p)) {
                        return $p;
                    }

                    // An array
                    if (is_array($p)) {
                        $uid = $p['uid'] ?? null;

                        // external
                        if ($uid === 0 || $uid === '0') {
                            return $p['name'] ?? null;
                        }

                        // uid; if missing, fallback to name
                        return $uid ?? $p['username'] ?? $p['name'] ?? null;
                    }

                    return null;
                })
                ->filter() // remove nulls
                ->values()
                ->all();

            $presenters = array_merge($presenters, $inputPresenters);
        }

        // Deduplicate (case-insensitive)
        $presenters = collect($presenters)
            ->unique(fn($p) => strtolower((string)$p))
            ->values()
            ->all();


        // Build courses (bulk-load, guard nulls)
        $courses = [];
        $daisyCourses = [];
        if ($data['selected-courses'] ?? []) {
            $ids = array_map('intval', $request->input('selected-courses', []));
            $daisyCourses = $ids;

            $courseModels = Course::whereIn('id', $ids)->get()->keyBy('id');
            foreach ($ids as $cid) {
                if (! $courseModels->has($cid)) continue;
                $c = $courseModels->get($cid);
                $courses[] = [
                    'designation' => $c->designation,
                    'semester'    => Str::lower($c->semester) . $c->year,
                ];
            }
        }

        // Tags (unique, trimmed)
        $tags = [];

        if ($request->filled('tags')) {
            $tags = collect($request->input('tags'))
                ->map(function ($tag) {
                    // If it's an array, use the 'name' field
                    if (is_array($tag)) {
                        return trim($tag['name'] ?? '');
                    }

                    // If it's a string, use it directly
                    return trim((string) $tag);
                })
                // Remove empty names
                ->filter(fn($name) => !empty($name))
                // Deduplicate (case-insensitive)
                ->unique(fn($name) => strtolower($name))
                ->values()
                ->all();
        }


        // Visibility
        [$visible, $unlisted] = match ($request->visibility) {
            'visible'  => [true,  false],
            'private'  => [false, false],
            'unlisted' => [false, true],
        };

        // Parse date (safe due to validation)
        $createdTs = Carbon::createFromFormat('Y-m-d', $data['recording_date'])->timestamp;

        //Subtitles
        $gsubtitles = [];
        if (!empty($data['autosub'])) {
            $generated = [
                'type' => 'whisper',
                'source' => 'main',
            ];

            if (!empty($data['autosub_language'])) {
                $generated['language'] = $data['autosub_language'];
            }

            $gsubtitles['Generated'] = Collection::make($generated);
        }

        //Manually uploaded subtitles
        if (!empty($data['add_sub'])) {
            foreach ($data['add_sub'] as $filename => $path) {
                // Normalize the incoming relative path
                $path = ltrim(trim($path), '/');
                $folder    = rtrim($manualPresentation->local, '/').'/subtitle/';
                $finalPath = '/' . $this->storage() . '/' .$folder.$filename;

                // 1) Confirm the file exists on the disk
                if (!\Illuminate\Support\Facades\Storage::disk('local')->exists($path)) {
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
        $subtitles = []; // Collect all subtitles here
        if($data['uploadedSubLanguage'] ?? false) {
            //Set upload true
            $this->upload = true;

            // A mapping from the uploaded language key to the display name
            $map = [
                'english' => 'English',
                'swedish' => 'Svenska',
            ];


            $index = 0;
            foreach ($data['uploadedSubLanguage'] as $subs) {
                if (isset($map[$subs])) {
                    $subtitles[$map[$subs]] = 'subtitle/' . $subtitles_filename[$index];
                    $index++;
                }
            }
        }

        DB::transaction(function () use (
            $manualPresentation, $presenters, $tags, $courses, $daisyCourses, $request, $data,
            $visible, $unlisted, $createdTs, $gsubtitles, $subtitles
        ) {
            $manualPresentation->fill([
                'type'                   => 'manual',
                'status'                 => 'pending',
                'upload_dir'             => '/data0/'.$this->storage().'/'.$manualPresentation->local,
                'title'                  => $data['title'],
                'title_en'               => $data['title_en'] ?? null,
                'description'            => $data['description'] ?? null,
                'presenters'             => $presenters,
                'tags'                   => $tags,
                'courses'                => $courses,
                'daisy_courses'          => $daisyCourses,
                'created'                => $createdTs,
                'visibility'             => $visible,
                'unlisted'               => $unlisted,
                'autogenerate_subtitles' => $data['autosub'] ?? 0,
                'generate_subtitles'     => $gsubtitles,
                'subtitles'              => $subtitles ?? null
            ])->save();

            // Upsert video permissions for this presentation
            VideoPermission::updateOrCreate(
                ['notification_id' => $manualPresentation->id],
                [
                    'permission_id' => $data['playback'] ?? 1,
                    'type'          => $data['playback'] == 1 ? 'public' : 'private',
                ]
            );
        });

        //Send pkg
        $notify = new PlayStoreNotify($manualPresentation);
        $notify->sendSuccess('default');

        //Send email to uploader
        $job = (new JobUploadProgressNotification($manualPresentation));

        // Dispatch Job and continue
        dispatch($job);

        return redirect('/') ->with('message', __("Your file has been successfully added to the upload queue."));;

    }

    /**
     * Handles the file upload
     *
     * @param Request $request
     *
     * @throws UploadMissingFileException
     * @throws UploadFailedException
     */

    public function chunkupload(Request $request)
    {
        //Create the file receiver
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

        // Check if the upload is success, throw exception or return response
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        //Receive the file
        $save = $receiver->receive();

        //Check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {

            $this->saveFile($save->getFile(), $request, 'video');
            // Update status in model
            $this->addFilesCount($request);
            $this->addSource($request, $save->getFile()->getClientOriginalName());
            //return unlink($save->getFile()->getPathname());


            //return true;
            return response()->json([
                'status' => true,
                'done'   => 100,
                'path'   => $save->getFile()->getPathname(),
                'name'   => $save->getFile()->getClientOriginalName()
                ]);
        }

        //Current progress
        /** @var AbstractHandler $handler */
        $handler = $save->handler();

        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    /**
     * Saves the file
     *
     * @param UploadedFile $file
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function saveFile(UploadedFile $file, Request $request, $type) {

        $fileName = $this->createFilename($file);

        // Get file mime type
        $mime_original = $file->getMimeType();
        $mime = str_replace('/', '-', $mime_original);
        switch($type) {
            case('video'):
                $folder  = $request->localdir . '/video/';
                break;
            case('thumb'):
                $folder  = $request->thumbdir . '/poster/';
                $presentation = ManualPresentation::where('local', $request->thumbdir)->first();
                $presentation->thumb = 'poster/' . $fileName;
                $presentation->save();
                break;
            case('subtitle'):
                $folder  = $request->subtitledir . '/subtitle/';
                break;
        }

        $finalPath = '/' . $this->storage() . '/' . $folder;

        $fileSize = $file->getSize();
        Storage::disk('play-store')->putFileAs($finalPath, $file, $fileName);

        return response()->json([
            'path' => $finalPath,
            'name' => $fileName,
            'mime_type' => $mime
        ]);
    }

    public function thumbupload(Request $request)
    {
        //Create the file receiver
        $receiver = new FileReceiver("thumb", $request, HandlerFactory::classFromRequest($request));

        // Check if the upload is success, throw exception or return response
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        //Receive the file
        $save = $receiver->receive();

        //Check if the upload has finished
        if ($save->isFinished()) {
            $this->saveFile($save->getFile(), $request, 'thumb');
            return unlink($save->getFile()->getPathname());
        }

        //Current progress
        /** @var AbstractHandler $handler */
        $handler = $save->handler();

        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    /**
     * Create unique filename for uploaded file
     * @param UploadedFile $file
     * @return string
     */
    protected function createFilename(UploadedFile $file) {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace(".".$extension, "", $file->getClientOriginalName()); // Filename without extension

        //We use the original hashed name
        return $filename.".".$extension;
    }

    /**
     * Delete uploaded file WEB ROUTE
     * @param Request request
     * @return \Illuminate\Http\JsonResponse
     */
    public function chunkdelete(Request $request)
    {
        $file = $request->name;
        $thumb_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file);
        $dir = $request->localdir;

        $filePath = $this->storage() . "/{$dir}/video/";
        $posterPath = $this->storage() . "/{$dir}/poster/";
        $finalFilePath = $filePath;
        $finalPosterPath = $posterPath;


        if (Storage::disk('play-store')->delete($finalFilePath.$file) ){

            //Unlink related poster
            Storage::disk('play-store')->delete($finalPosterPath . $thumb_name.'.png');

            $this->deleteFilesCount($request);
            return response()->json([
                'status' => 'ok'
            ], 200);
        }
        else{
            return response()->json([
                'status' => 'File missing',
                'dir' => $finalFilePath.$file
            ], 200);
        }
    }

    public function thumbdelete(Request $request)
    {
        $file = $request->name;
        $dir = $request->thumbdir;

        $posterPath = $this->storage() . "/{$dir}/poster/{$file}";

        if (Storage::disk('play-store')->exists($posterPath)) {
            Storage::disk('play-store')->delete($posterPath);

            // Optionally remove the directory if it’s empty
            if (empty(Storage::disk('play-store')->files($this->storage()."/{$dir}/poster"))) {
                Storage::disk('play-store')->deleteDirectory($this->storage()."/{$dir}/poster");
            }

            $presentation = ManualPresentation::where('local', $dir)->first();
            if ($presentation) {
                $presentation->thumb = '';
                $presentation->save();
            }

            return response()->json(['status' => 'ok'], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Thumbnail not found'
        ], 404);
    }


    public function subtitleupload(Request $request)
    {
        //Create the file receiver
        $receiver = new FileReceiver("subtitle", $request, HandlerFactory::classFromRequest($request));

        // Check if the upload is success, throw exception or return response
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        //Receive the file
        $save = $receiver->receive();

        //Check if the upload has finished
        if ($save->isFinished()) {
            $this->saveFile($save->getFile(), $request, 'subtitle');
            return unlink($save->getFile()->getPathname());
        }

        //Current progress
        /** @var AbstractHandler $handler */
        $handler = $save->handler();

        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    public function subtitledelete(Request $request)
    {
        $file = $request->filename;
        $dir = $request->localdir;

        $posterPath = $this->storage() . "/{$dir}/subtitle/";
        $finalSubtitlePath = $posterPath;

        if (Storage::disk('play-store')->delete($finalSubtitlePath . $file) ){
            //Also delete subtitle directory
            Storage::deleteDirectory($finalSubtitlePath);

            return response()->json([
                'status' => 'ok'
            ], 200);
        }
        else{
            return response()->json([
                'status' => 'File removed'
            ], 200);
        }
    }

    protected function addSource(Request $request, $filename): void
    {
        $presentation = ManualPresentation::where('local', $request->localdir)->first();

        // Decode existing sources, or initialize empty array
        $sources = $presentation->sources ? json_decode($presentation->sources, true) : [];

        // Add new entry depending on number of files
        if ($presentation->files == 1) {
            $sources['main'] = [
                'video' => 'video/' . $filename,
                'playAudio' => true,
            ];
        } else {
            $cameraKey = 'camera' . ((int)$presentation->files - 1);
            $sources[$cameraKey] = [
                'video' => 'video/' . $filename,
                'playAudio' => false,
            ];
        }

        // Save updated sources
        $presentation->sources = $sources;
        $presentation->save();
    }

    protected function addFilesCount(Request $request): void
    {
        $presentation = ManualPresentation::where('local', $request->localdir)->first();
        $presentation->files++;
        $presentation->save();
    }

    protected function deleteFilesCount(Request $request): void
    {
        $presentation = ManualPresentation::where('local', $request->localdir)->first();
        $presentation->files--;
        $presentation->save();
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
