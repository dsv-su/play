<?php

namespace App\Services\Filters;

use App\CoursePermissions;
use App\CoursesettingsUsers;
use App\IndividualPermission;
use Illuminate\Database\Eloquent\Model;

class Visibility extends Model
{
    /***
     * @param $videos
     * @return mixed
     * This class is a wrapper for a collection of videos to create a new collection instance from the array casting attributes at runtime
     * for course_setting_visibility and course_setting_download
     */

    public function check($videos)
    {
        return $this->check_download($this->check_visibility($videos));
    }

    private function check_visibility($videos)
    {
        //Filter videos visibility
        return $videos->filter(function ($video, $key) {
            //Check course group setting
            if(count($video->courses())>=1) {
                foreach($video->courses() as $course) {
                    if($setting = $course->coursesettings->toArray()) {
                        if($setting[0]['visibility'] == true) {
                            //Set flags to visualize private/external permission
                            if($course_permission = CoursePermissions::where('course_id', $course->id)->first()) {
                                if(in_array($course_permission->permission_id, [2,3]) or $course_permission->permission_id > 4) {
                                    $video->setAttribute('private_setting', true);
                                }
                                if($course_permission->permission_id == 4) {
                                    $video->setAttribute('external_setting', true);
                                }
                            }
                            //Set flags to enable edit/delete
                            if(count($course_user_admins = CoursesettingsUsers::where('course_id', $course->id)->get()) >= 1) {
                                foreach($course_user_admins as $course_user_admin) {
                                    if($course_user_admin->username == app()->make('play_username')) {
                                        //Check if user correct permissions
                                        if(in_array($course_user_admin->permission, ['read', 'edit', 'delete'])) {
                                            if(in_array($course_user_admin->permission, ['edit'])) {
                                                $video->setAttribute('edit_setting', true);
                                            }
                                            if(in_array($course_user_admin->permission, ['delete'])) {
                                                $video->setAttribute('edit_setting', true);
                                                $video->setAttribute('delete_setting', true);
                                            }
                                        }
                                    }
                                }
                            }
                            return $video->setAttribute('visibility_setting', true);
                        }
                        else {
                            //Check individual course setting
                            if(count($course_user_admins = CoursesettingsUsers::where('course_id', $course->id)->get()) >= 1) {
                                foreach($course_user_admins as $course_user_admin) {
                                    if($course_user_admin->username == app()->make('play_username')) {
                                        //Check if user correct permissions
                                        if(in_array($course_user_admin->permission, ['read', 'edit', 'delete'])) {
                                            if(in_array($course_user_admin->permission, ['edit'])) {
                                                $video->setAttribute('edit_setting', true);
                                            }
                                            if(in_array($course_user_admin->permission, ['delete'])) {
                                                $video->setAttribute('edit_setting', true);
                                                $video->setAttribute('delete_setting', true);
                                            }
                                            return $video->setAttribute('visibility_setting', false);
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
                                            return $video->setAttribute('visibility_setting', false);
                                        }
                                    }
                                }
                            }
                            if(app()->make('play_role') == 'Administrator') {
                                return $video->setAttribute('visibility_setting', false);
                            }
                            elseif(app()->make('play_role') == 'Courseadmin') {
                                return $video->setAttribute('visibility_setting', false);
                            }
                        }
                    }
                    //There is no explicit course setting
                    else {
                        if($video->visability == false and (app()->make('play_role') == 'Administrator'))  {
                            return $video->setAttribute('visibility_setting', false);
                        }
                        elseif($video->visability == false and (app()->make('play_role') == 'Courseadmin'))  {
                            return $video->setAttribute('visibility_setting', false);
                        }
                        else {
                            $video->setAttribute('visibility_setting', true);
                            return $video->visability;
                        }
                    }
                }
            }
            //The video is not associated to a course
            else {
                if($video->visability == false and (app()->make('play_role') == 'Administrator'))  {
                    return $video->setAttribute('visibility_setting', false);
                } else {
                    $video->setAttribute('visibility_setting', true);
                    return $video->visability;
                }
            }

            return false;
        });
    }

    private function check_download($videos)
    {
        //Filter videos visibility
        return $videos->filter(function ($video, $key) {
            //Check course group setting
            if(count($video->courses())>=1) {
                foreach($video->courses() as $course) {
                    if($setting = $course->coursesettings->toArray()) {
                        if($setting[0]['downloadable'] == true) {
                            return $video->setAttribute('download_setting', true);
                        }
                    }
                }
            }
            return $video;
        });
    }
}
