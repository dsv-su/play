<?php

namespace App\Services\Course;

use App\CoursesettingsPermissions;

class CourseSettingVisibility
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
                $this->coursesetting_list[] = $check->visibility;
            }

        }
        //Check that all values are the same if there exist multiple coursesettings
        if($this->coursesetting_list) {
            if(!(count(array_unique($this->coursesetting_list)) === 1) && (count($this->coursesetting_list) > 1)) {
                return false;
            } else {
                return $this->coursesetting_list[0];
            }
        }


    }

    private function getCourseSetting($course_id)
    {
        return CoursesettingsPermissions::where('course_id', $course_id)->first();
    }
}
