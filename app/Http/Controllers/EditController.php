<?php

namespace App\Http\Controllers;

use App\Course;
use App\CoursesettingsUsers;
use App\IndividualPermission;
use App\Permission;
use App\Presenter;
use App\Services\Daisy\DaisyAPI;
use App\Services\Filters\VisibilityFilter;
use App\Stream;
use App\Tag;
use App\Video;
use App\VideoCourse;
use App\VideoPermission;
use App\VideoPresenter;
use App\VideoTag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class EditController extends Controller
{
    public function __construct()
    {
        $this->middleware('edit-permission');
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
                    return $d[2];
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
        $tags = Tag::all();
        $individual_permissions = IndividualPermission::where('video_id', $video->id)->get();

        //Needs refactoring
        $video = $visibility->filter(Video::where('id', $video->id)->get())[0];
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

        return view('manage.edit', compact('video', 'permissions', 'courses', 'tags', 'presenters', 'individual_permissions', 'user_permission'));
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
            if ($request->presenters) {
                foreach ($request->presenters as $presenter) {

                    $username = preg_filter("/[^(]*\(([^)]+)\)[^()]*/", "$1", $presenter);
                    $name = trim(preg_replace("/\([^)]+\)/", "", $presenter));
                    if ($username == null && $name) {
                        $presenter = Presenter::firstOrCreate([
                            'username' => $username,
                            'description' => 'external'
                        ]);
                    } elseif ($username) {
                        $presenter = Presenter::firstOrCreate([
                            'username' => $username,
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
            if (!$request->courseEdit == null) {
                foreach ($request->courseEdit as $courseid) {
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
            // dump($request->hidden);
            foreach ($streams as $key => $stream) {
                $stream->audio = ($request->audio == $key);
                $stream->hidden = (isset($request->hidden)) ? in_array($key, $request->hidden) : 0;
                $stream->save();
            }

            //Update visibility
            if ($request->visibility) {
                $video->visibility = true;
            } else {
                $video->visibility = false;
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

        //return redirect()->route('manage')->with('success', $message);
        return redirect()->back()->with('success', true)->with('message', __("Presentation successfully updated"));
    }
}
