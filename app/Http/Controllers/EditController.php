<?php

namespace App\Http\Controllers;

use App\Course;
use App\CoursesettingsUsers;
use App\IndividualPermission;
use App\ManualPresentation;
use App\Permission;
use App\Presenter;
use App\Services\Daisy\DaisyAPI;
use App\Services\Filters\VisibilityFilter;
use App\Services\Ldap\SukatUser;
use App\Services\Notify\PlayStoreNotify;
use App\Services\PacketHandler\EditPackage;
use App\Services\Upload\Metadata;
use App\Stream;
use App\Tag;
use App\Video;
use App\VideoCourse;
use App\VideoPermission;
use App\VideoPresenter;
use App\VideoTag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EditController extends Controller
{
    public function __construct()
    {
        $this->middleware('redirect-links');
        $this->middleware('edit-permission')->except(['bulkEditShow','bulkEditStore']);
    }

    public function show(Video $video, VisibilityFilter $visibility)
    {
        $permissions = Permission::all();
        $courses = Course::all();
        $daisy_courses_ids = [];


        if (app()->make('play_role') != 'Administrator') {
            // Show only courses that you have permission to
            $daisy = new DaisyAPI();
            $daisyPersonID = $daisy->getDaisyPersonId(app()->make('play_username'));
            // Get all courses where user is courseadmin
            if ($daisy_courses = $daisy->getDaisyEmployeeResponsibleCourses($daisyPersonID)) {
                $daisy_courses_ids = array_map(function ($d) {
                    return $d['id'];
                }, $daisy_courses);
            }
            foreach ($courses as $key => $course) {
                $username = app()->make('play_username');
                $haspermission = CoursesettingsUsers::where('course_id', $course->id)->where('username', $username)->whereIn('permission', ['upload', 'delete', 'edit'])->count() || in_array($course->id, $daisy_courses_ids);
                if (!$haspermission) {
                    unset($courses[$key]);
                }
            }
        }

        $presenters = $video->presenters();
        $individual_permissions = IndividualPermission::where('video_id', $video->id)->get();

        // Check if a video is associated with any course where the user is a manager
        $userismanager = $video->courses()->filter(function ($course) use ($daisy_courses_ids) {
                return in_array($course->id, $daisy_courses_ids);
            })->count() > 0;
        if ($userismanager || $video->delete_setting || app()->make('play_role') == 'Administrator') {
            $user_permission = 'delete';
        } elseif ($video->edit_setting) {
            $user_permission = 'edit';
        } else {
            $user_permission = 'read';
        }

        // If user has neither course responsibility nor individual permission, prevent it.
        if (!in_array($user_permission, ['edit', 'delete'])) {
            // abort(401);
        }

        //Init new ManualPresentation instance
        $editHandler = (new UploadController())->init_upload();
        $editHandler->pkg_id = $video->id;
        $editHandler->save();

        return view('manage.edit', compact('video', 'permissions', 'presenters', 'individual_permissions', 'user_permission', 'editHandler'));
    }

    public function edit(Video $video, Request $request)
    {
        if ($request->isMethod('post')) {

            //Video attributes
            $video->title = $request->title;
            $video->title_en = $request->title_en;
            $video->description = $request->description;
            $video->creation = Carbon::createFromFormat('d/m/Y', $request->date)->timestamp;
            $video->save();

            //Remove all presenters linked to video
            VideoPresenter::where('video_id', $video->id)->delete();

            //Linked Presenter attributes
            if ($request->presenteruids && $request->presenternames) {
                foreach ($request->presenteruids as $key => $uid) {
                    $name = $request->presenternames[$key];
                    //   $username = preg_filter("/[^(]*\(([^)]+)\)[^()]*/", "$1", $presenter);
                    //   $name = trim(preg_replace("/\([^)]+\)/", "", $presenter));
                    if (!$uid || strpos($uid, 'external') !== false) {
                        $presenter = Presenter::firstOrCreate([
                            'name' => $name,
                            'description' => 'external'
                        ]);
                    } else {
                        $presenter = Presenter::firstOrCreate([
                            'username' => $uid,
                            'description' => 'sukat'
                        ]);
                    }
                    // People sometimes change names and we don't want duplicate presenters
                    if ($presenter) {
                        $presenter->name = $name;
                        $presenter->save();

                        $videoPresenter = VideoPresenter::create([
                            'video_id' => $video->id,
                            'presenter_id' => $presenter->id
                        ]);
                    }
                }
            }

            //Update group permission for presentation
            if ($videoPermission = VideoPermission::where('video_id', $video->id)->first()) {
                //Exist
                $videoPermission->permission_id = $request->video_permission;
                if ($request->video_permission == 1) {
                    $videoPermission->type = 'public';
                } elseif ($request->video_permission == 4) {
                    $videoPermission->type = 'external';
                } else {
                    $videoPermission->type = 'private';
                }
                $videoPermission->save();
            } else {
                //Doesnt exist
                if ($request->video_permission == 1) {
                    VideoPermission::create([
                        'video_id' => $video->id,
                        'permission_id' => $request->video_permission,
                        'type' => 'public'
                    ]);
                } else {
                    VideoPermission::create([
                        'video_id' => $video->id,
                        'permission_id' => $request->video_permission,
                        'type' => 'private'
                    ]);
                }
            }

            //Update individual permissions

            //Remove all individual permissions linked to video
            IndividualPermission::where('video_id', $video->id)->delete();
            if ($request->individual_permissions) {
                foreach ($request->individual_permissions as $key => $ind) {
                    $username = preg_filter("/[^(]*\(([^)]+)\)[^()]*/", "$1", $ind);
                    $name = trim(preg_replace("/\([^)]+\)/", "", $ind));
                    if ($username) {
                        $iperm = IndividualPermission::updateOrCreate([
                            'video_id' => $video->id,
                            'username' => $username
                        ], [
                            'name' => $name,
                            'permission' => $request->individual_perm_type[$key]
                        ]);
                    }
                }
            }

            //Update course
            VideoCourse::where(['video_id' => $video->id])->delete();
            if (!$request->courseids == null) {
                foreach ($request->courseids as $courseid) {
                    VideoCourse::updateOrCreate(['video_id' => $video->id, 'course_id' => $courseid]);
                }
            }

            // Update tags
            VideoTag::where(['video_id' => $video->id])->delete();
            if (!$request->tags == null) {
                foreach ($request->tags as $tagid) {
                    VideoTag::updateOrcreate(['video_id' => $video->id, 'tag_id' => $tagid]);
                }
            }

            //Update streams
            $streams = Stream::where('video_id', $video->id)->get();

            foreach ($streams as $key => $stream) {
                if($request->audio == null) {
                    //If audio has been disabled
                    $stream->audio = 0;
                } else {
                    $stream->audio = ($request->audio == $key);
                }
                $stream->hidden = (isset($request->hidden)) ? in_array($key, $request->hidden) : 0;
                $stream->save();
            }

            //Update visibility
            if ($request->video_visibility) {
                switch($request->video_visibility) {
                    case('visible'):
                        $video->visibility = true;
                        $video->unlisted = false;
                        break;
                    case('private'):
                        $video->visibility = false;
                        $video->unlisted = false;
                        break;
                    case('unlisted'):
                        $video->visibility = false;
                        $video->unlisted = true;
                        break;
                }
            }

            //Update visibility
            if ($request->download) {
                $video->download = true;
            } else {
                $video->download = false;
            }

            $video->save();
        }

        Cache::flush();

        //Create notify package
        $backend = new EditPackage($video);
        $backend->sendBackend($request);

        if(count(session('links') ?? []) <= 3) {
            return redirect()->route('home')->with('message', __("Presentation successfully updated"));
        } else {
            return redirect(session('links')[2])->with('message', __("Presentation successfully updated"));
        }

    }

    public function bulkEditShow(Request $request)
    {
        $visibility = app(VisibilityFilter::class);
        $videos = $visibility->filter(Video::whereIn('id', $request->bulkids)->get());
        $videos = $videos->filter(function ($i) {
            return $i->edit;
        });
        return view('manage.bulk-edit-presentation', ['videos' => $videos]);
    }

    public function bulkEditStore(Request $request)
    {
        $visibility = $request->video_visibility;
        $download = (bool)$request->downloadable;
        $courseids = $request->courses ?? [];
        $tags = $request->tags ?? [];
        $supresenters = $request->supresenters ?? [];
        $externalpresenters = $request->externalpresenters ?? [];
        $videoids = $request->videos ?? [];
        // Get videos from the ids
        $videos = Video::whereIn('id', $videoids)->get();
        $visibilityFilter = app(VisibilityFilter::class);
        // Filter them
        $fitleredvideos = $visibilityFilter->filter($videos)->pluck('id');
        // Re-load them to get rid of casts and extra attributes
        $videos = Video::whereIn('id', $fitleredvideos)->get();

        $overwritecourses = (bool)$request->overwriteCourse;
        $overwritepresenters = (bool)$request->overwritePresenter;
        $overwritetags = (bool)$request->overwriteTag;

        foreach ($videos as $video) {
            switch($visibility) {
                case('visible'):
                    $video->visibility = true;
                    $video->unlisted = false;
                    break;
                case('private'):
                    $video->visibility = false;
                    $video->unlisted = false;
                    break;
                case('unlisted'):
                    $video->visibility = false;
                    $video->unlisted = true;
                    break;
            }
            $video->download = $download;

            if ($video->delete) {
                // Handle overwrites only if a user has delete-permission
                if ($overwritecourses) {
                    VideoCourse::where(['video_id' => $video->id])->delete();
                }
                if ($overwritepresenters) {
                    VideoPresenter::where(['video_id' => $video->id])->delete();
                }
                if ($overwritetags) {
                    VideoTag::where(['video_id' => $video->id])->delete();
                }
            }

            foreach ($courseids as $courseid) {
                VideoCourse::updateOrCreate(['video_id' => $video->id, 'course_id' => $courseid]);
            }
            foreach ($tags as $tag) {
                $tag = Tag::firstOrCreate(['name' => $tag]);
                VideoTag::updateOrcreate(['video_id' => $video->id, 'tag_id' => $tag->id]);
            }
            foreach ($externalpresenters as $externalpresenter) {
                $presenter = Presenter::firstOrCreate([
                    'name' => $externalpresenter,
                    'description' => 'external'
                ]);
                $presenter->save();
                VideoPresenter::create([
                    'video_id' => $video->id,
                    'presenter_id' => $presenter->id
                ]);
            }
            foreach ($supresenters as $supresenter) {
                $sukatpresenter = SukatUser::findBy('uid', $supresenter);
                $presenter = Presenter::firstOrCreate([
                    'username' => $supresenter,
                    'description' => 'sukat'
                ]);
                $presenter->name = $sukatpresenter->getFirstAttribute('cn');
                $presenter->save();
                VideoPresenter::create([
                    'video_id' => $video->id,
                    'presenter_id' => $presenter->id
                ]);
            }
            $video->save();
        }

        return redirect(session('links')[2])->with('message', __("Presentations are successfully updated"));
    }
}
