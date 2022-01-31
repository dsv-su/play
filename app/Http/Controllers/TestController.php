<?php

namespace App\Http\Controllers;

use App\Course;
use App\Services\Daisy\DaisyIntegration;
use App\Services\Notify\PlayStoreNotify;
use App\Video;

class TestController extends Controller
{



    public function test()
    {
    }

    private function updateOldCourses($courses):void
    {
        //For updating english coursenames to courses outside the intervall 2018-2022

        /*
         *  $update_courses = [5548, 5567, 5853, 5877, 5944, 5982, 6020, 6098, 6254, 6321, 6329];
         *  $this->updateOldCourses($update_courses);
         *
         */

        $daisy = new DaisyIntegration();
        foreach ($courses as $course_id) {
            $this->retrieved_course = $daisy->getCourseSegment($course_id);
            //Update or Create Course
            if (substr($this->retrieved_course['semester'], 4) == '1') {
                $this->course = Course::updateOrCreate(
                    ['id' => $this->retrieved_course['id'], 'designation' => $this->retrieved_course['designation'], 'semester' => 'VT', 'year' => substr($this->retrieved_course['semester'], 0, 4)],
                    ['name' => $this->retrieved_course['name'], 'name_en' => $this->retrieved_course['name_en']]
                );
            } else {
                $this->course = Course::updateOrCreate(
                    ['id' => $this->retrieved_course['id'], 'designation' => $this->retrieved_course['designation'], 'semester' => 'HT', 'year' => substr($this->retrieved_course['semester'], 0, 4)],
                    ['name' => $this->retrieved_course['name'], 'name_en' => $this->retrieved_course['name_en']]
                );
            }
        }

    }

    public function roles()
    {
        //Check role status
        dd('play_auth: '.app()->make('play_auth'), 'play_role: '. app()->make('play_role'), 'play_user: '.app()->make('play_user'),'play_username: '.app()->make('play_username'), 'play_email: '.app()->make('play_email'));

    }

    public function del(Video $video)
    {
        //Testdelete (this method should be removed before production)
        //Send Delete notification
        $notify = new PlayStoreNotify($video);
        return $message = $notify->sendDelete();

        return back()->with(['message' => 'Presentationen har raderats']);
    }

    public function php()
    {
        return phpinfo();
    }

    public function server()
    {
        dd($_SERVER);
    }


}
