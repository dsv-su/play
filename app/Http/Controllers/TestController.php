<?php

namespace App\Http\Controllers;

use App\CoursesettingsPermissions;
use App\Video;
use App\VideoCourse;

class TestController extends Controller
{
    public function test()
    {
        $video = Video::find('021709be-4b7e-4c4e-a276-8648cb7a3225');
        //Retrive all courses associated with the presentation
        $courses = VideoCourse::where('video_id', '021709be-4b7e-4c4e-a276-8648cb7a3225')->pluck('course_id');
        foreach ($courses as $course) {
            if($coursesetting = CoursesettingsPermissions::where('course_id', $course)->first()) {
                $video->visibility = $coursesetting->visibility;
                $video->download = $coursesetting->downloadable;
                $video->save();
            }
        }

    }

    public function server()
    {
        dd($_SERVER);
    }

    public function roles()
    {
        //Check role status
        dd('play_auth: '.app()->make('play_auth'), 'play_role: '. app()->make('play_role'), 'play_user: '.app()->make('play_user'),'play_username: '.app()->make('play_username'), 'play_email: '.app()->make('play_email'));

    }

}
