<?php

namespace App\Http\Controllers;

use App\Course;
use App\IndividualPermission;
use App\Permission;
use App\Presentation;
use App\Presenter;
use App\Services\Ldap\SukatUser;
use App\Stream;
use App\Video;
use App\VideoCourse;
use App\VideoPermission;
use App\VideoPresenter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EditController extends Controller
{
    public function show(Video $video)
    {
        $permissions = Permission::all();
        $courses = Course::all();
        $presenters = $video->presenters();
        $individual_permissions = IndividualPermission::where('video_id', $video->id)->get();

        return view('manage.edit', compact('video', 'permissions', 'courses', 'presenters', 'individual_permissions'));
    }

    public function edit(Video $video, Request $request)
    {
        //dd($request->all(), $video);
        //Linked Presenter attributes


        if ($request->isMethod('post')) {
            //Video attributes
            $video->title = $request->title;
            $video->creation = strtotime($request->date);
            $video->save();

            //Remove all presenters linked to video
            VideoPresenter::where('video_id', $video->id)->delete();

            //Linked Presenter attributes
            if($request->presenters){
                foreach($request->presenters as $presenter) {

                    $username = preg_filter("/[^(]*\(([^)]+)\)[^()]*/", "$1", $presenter);
                    $name = trim(preg_replace("/\([^)]+\)/","", $presenter));
                    if($username == null) {
                        $presenter = Presenter::firstOrCreate([
                            'username' => $username,
                            'name' => $name,
                            'description' => 'external'
                        ]);
                    }
                    else {
                        $presenter = Presenter::firstOrCreate([
                            'username' => $username,
                            'name' => $name,
                            'description' => 'sukat'
                        ]);
                    }

                    $videoPresenter = VideoPresenter::create([
                        'video_id' => $video->id,
                        'presenter_id' => $presenter->id
                    ]);
                }
            }
            //Update permission for presentation
            if($videoPermission = VideoPermission::where('video_id', $video->id)->first()) {
                //Exist
                if($request->video_permission == 1) {
                    $videoPermission->permission_id = $request->video_permission;
                    $videoPermission->type = 'public';
                    $videoPermission->save();
                }
                else {
                    $videoPermission->permission_id = $request->video_permission;
                    $videoPermission->type = 'private';
                    $videoPermission->save();
                }

            }
            else {
                //Doesnt exist
                if($request->video_permission == 1) {
                    VideoPermission::create([
                        'video_id' => $video->id,
                        'permission_id' => $request->video_permission,
                        'type' => 'public'
                    ]);
                }
                else {
                    VideoPermission::create([
                        'video_id' => $video->id,
                        'permission_id' => $request->video_permission,
                        'type' => 'private'
                    ]);
                }
            }


            //Update course
            if(!$request->courseEdit == null) {
                $videocourse = VideoCourse::updateOrCreate(
                    ['video_id' => $video->id],
                    ['course_id' => $request->courseEdit]
                );
            }

            //Update Audio feed
            $streams = Stream::where('video_id', $video->id)->get();
            foreach($streams as $key => $stream) {
                $stream->audio = 0;
                $stream->save();
                if($request->audio == $key) {
                    $stream->audio = 1;
                    $stream->save();
                }
            }


        }
        Cache::flush();

        return redirect()->route('manage')->with('success','Presentation successfully updated');


    }
}
