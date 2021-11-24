<?php

namespace App\Services\Filters;

use App\CoursesettingsUsers;
use Illuminate\Database\Eloquent\Model;

class IndividualCourseVisibility extends model
{
    public function checkVisibility($videos)
    {
        //Filter videos with coursesetting visibility
        return $videos->filter(function ($video, $key) {
            foreach($video->courses() as $course) {
                if(count($course_user_admins = CoursesettingsUsers::where('course_id', $course->id)->get()) >= 1) {
                    foreach($course_user_admins as $course_user_admin) {
                        if($course_user_admin . '@su.se' == $_SERVER['eppn']) {
                            //Check if user correct permissions
                            if(in_array($course_user_admin->permission, ['read', 'edit', 'delete'])) {
                                return $video;
                            }
                        }
                    }
                }
            }
            return false;
        });

    }
}
