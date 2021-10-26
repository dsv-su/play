<?php

namespace App\Http\Controllers;

use App\Course;
use App\IndividualPermission;
use App\Permission;
use App\Presenter;
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
        $this->middleware('edit-permission');
    }

    public function show(Video $video)
    {
        $permissions = Permission::all();
        $courses = Course::all();
        $presenters = $video->presenters();
        $tags = Tag::all();
        $individual_permissions = IndividualPermission::where('video_id', $video->id)->get();

        return view('manage.edit', compact('video', 'permissions', 'courses', 'tags', 'presenters', 'individual_permissions'));
    }

    public function edit(Video $video, Request $request)
    {
        if ($request->isMethod('post')) {
            //Video attributes
            $video->title = $request->title;
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
                    if ($username == null) {
                        $presenter = Presenter::firstOrCreate([
                            'username' => $username,
                            'description' => 'external'
                        ]);
                    } else {
                        $presenter = Presenter::firstOrCreate([
                            'username' => $username,
                            'description' => 'sukat'
                        ]);
                    }
                    // People sometimes change names and we don't want duplicate presenters
                    $presenter->name = $name;
                    $presenter->save();

                    $videoPresenter = VideoPresenter::create([
                        'video_id' => $video->id,
                        'presenter_id' => $presenter->id
                    ]);
                }
            }
            //Update group permission for presentation
            if($videoPermission = VideoPermission::where('video_id', $video->id)->first()) {
                //Exist
                $videoPermission->permission_id = $request->video_permission;
                if($request->video_permission == 1) {
                    $videoPermission->type = 'public';
                }
                elseif($request->video_permission == 4) {
                    $videoPermission->type = 'external';
                }
                else {
                    $videoPermission->type = 'private';
                }
                $videoPermission->save();
            }
            else {
                //Doesnt exist
                if($request->video_permission == 1) {
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

            //Update visability
            if ($request->visability) {
                $video->visability = true;
            } else {
                $video->visability = false;
            }

            //Update visability
            if ($request->download) {
                $video->download = true;
            } else {
                $video->download = false;
            }

            $video->save();
        }

        Cache::flush();

        return redirect()->route('manage')->with('success', 'Presentation successfully updated');
    }
}
