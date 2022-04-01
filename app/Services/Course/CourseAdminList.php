<?php

namespace App\Services\Course;

use App\CoursesettingsUsers;

class CourseAdminList
{
    /*************************************************************************
     * Used for Middleware
     * Check if user exist in coursesettingslist for this video
     * the user must at least exist in one of the associated coursesettings
    /*************************************************************************/
    protected $courselist = [];
    protected $user_permission_list = [];
    protected $course, $courseId;

    public function check($username, $video)
    {
        $username = substr($username, 0, strpos($username, "@"));
        foreach($video->courses() as $this->course) {
            $this->courselist[] = $this->course->id;
            }
        foreach($this->courselist as $this->courseId) {
            $this->user_permission_list = $this->getUsersCourseAdminPermissions($this->courseId, $username);
        }

        if($this->user_permission_list) {
            if(array_intersect($this->user_permission_list, ['read', 'edit', 'delete'])) {
                return true;
            }
            return false;
        }
    }

    private function getUsersCourseAdminPermissions($course_id, $username)
    {
        return CoursesettingsUsers::where('course_id', $course_id)->where('username', $username)->pluck('permission')->toArray();
    }
}
