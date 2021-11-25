<?php

namespace App\Services\Filters;

use App\CoursesettingsUsers;
use App\IndividualPermission;
use Illuminate\Database\Eloquent\Model;

class Visibility extends Model
{
    public function check($videos)
    {
        //Filter videos visibility
        return $videos->filter(function ($video, $key) {
            //Check course group setting
            if(count($video->courses())>=1) {
                foreach($video->courses() as $course) {
                    if($setting = $course->coursesettings->toArray()) {
                        if($setting[0]['visibility'] == true) {
                            return $video;
                        }
                        else {
                            //Check individual course setting
                            if(count($course_user_admins = CoursesettingsUsers::where('course_id', $course->id)->get()) >= 1) {
                                foreach($course_user_admins as $course_user_admin) {
                                    if($course_user_admin->username == app()->make('play_username')) {
                                        //Check if user correct permissions
                                        if(in_array($course_user_admin->permission, ['read', 'edit', 'delete'])) {
                                            return $video;
                                        }
                                    }
                                }
                            }
                        }
                        //Check presentation individual setting
                        if(count($ipermissions = IndividualPermission::where('video_id', $video->id)->get()) >= 1) {
                            foreach($ipermissions as $ipermission) {
                                if($ipermission->username == app()->make('play_username')) {
                                    //Check if user correct permissions
                                    if(in_array($ipermission->permission, ['read', 'edit', 'delete'])) {
                                        return $video;
                                    }
                                }
                            }

                        }

                    }
                    //There is no explicit course setting
                    else {
                        return $video->visability;
                    }

                }
            }
            //The video is not associated to a course
            else {
                return $video->visability;
            }

            return false;
        });
    }
}
