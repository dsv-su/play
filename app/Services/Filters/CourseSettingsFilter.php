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
            if($check = $this->getCourseVisibilitysetting($this->course->id)) {
                $this->courseSettings[] = $check->visibility;
            } else {
                $this->courseSettings[] = true; //Fallback to default if not set
            }

        }
        foreach($this->courses as $this->course) {
            if($setting = $this->getCourseVisibilitysetting($this->course->id)) {
                //Check that all values are the same and there are multiple coursesettings
                if(!(count(array_unique($this->courseSettings)) === 1) && (count($this->courseSettings) > 1)) {
                    $this->video->setAttribute('visibility', false);
                } else {
                    switch($setting->visibility) {
                        case(0):
                            $this->video->setAttribute('visibility', false);
                            break;
                        case(1):
                            $this->video->setAttribute('visibility', true);
                            break;
                    }
                }
            }
        }
    }

    private function getCourseVisibilitysetting($course_id)
    {
        return CoursesettingsPermissions::where('course_id', $course_id)->first();
    }
}
