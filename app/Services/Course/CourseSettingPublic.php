<?php

namespace App\Services\Course;

use App\CoursePermissions;

class CourseSettingPublic
{
    protected $courseId, $course;
    protected $courselist = [];
    protected $coursesetting_list = [];

    public function check($video)
    {
        foreach($video->courses() as $this->course) {
            $this->courselist[] = $this->course->id;
        }
        foreach($this->courselist as $this->courseId) {
            if($check = $this->getCourseSetting($this->courseId)) {
                $this->coursesetting_list[] = $check->permission_id;
            } else {
                $this->coursesetting_list[] = 1; //Fallback to default if not set
            }

        }
        //Check that all values are the same if there exist multiple coursesettings
        if($this->coursesetting_list) {
            if(!(count(array_unique($this->coursesetting_list)) === 1) && (count($this->coursesetting_list) > 1)) {
                return 1; //Fallback to default setting
            } else {
                return $this->coursesetting_list[0];
            }
        }


    }

    private function getCourseSetting($course_id)
    {
        return CoursePermissions::where('course_id', $course_id)->first();
    }
}
