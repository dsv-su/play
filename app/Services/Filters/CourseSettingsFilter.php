<?php

namespace App\Services\Filters;

use App\CoursesettingsPermissions;
use App\Video;

class CourseSettingsFilter extends VisibilityFilter implements \App\Interfaces\VisibilityInterface
{
    protected $courses, $course, $video;
    protected $courseSettings = [];

    public function __construct(Video $video)
    {
        $this->video = $video;
        $this->courses = $video->courses();
    }
    public function cast()
    {
        //Collect all coursesettings
        foreach($this->courses as $this->course) {
            $this->courseSettings[] = $this->getCourseVisibilitysetting($this->course->id);
        }
        //Check that one of all coursesettings are not false
        if(in_array(0, $this->courseSettings)) {
            $this->video->setAttribute('visibility', false);
            /*
             * Coursesettings have higher priority
             *
            //Override with the presentation setting
            $presentation = $this->video->fresh();
            if($presentation->visibility) {
                $this->video->setAttribute('visibility', true);
            }
            */
        } else {
            //$presentation = $this->video->fresh();
            //if(!$presentation->visibility) {
                foreach($this->courses as $this->course) {
                    if($download = $this->getCourseVisibilitysetting($this->course->id)) {
                        switch($download) {
                            case(0):
                                $this->video->setAttribute('visibility', false);
                                break;
                            case(1):
                                $this->video->setAttribute('visibility', true);
                                break;
                        }
                    }
                }
            //}

        }
    }

    private function getCourseVisibilitysetting($course_id)
    {
        return CoursesettingsPermissions::where('course_id', $course_id)->pluck('visibility')->first();
    }
}
