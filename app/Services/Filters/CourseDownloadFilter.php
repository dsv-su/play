<?php

namespace App\Services\Filters;

use App\CoursesettingsPermissions;
use App\Video;

class CourseDownloadFilter extends VisibilityFilter implements \App\Interfaces\VisibilityInterface
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
            $this->courseSettings[] = $this->getCourseDownloadsetting($this->course->id);
        }
        //Check that one of all coursesettings are not false
        if(in_array(0, $this->courseSettings)) {
            $this->video->setAttribute('download', false);
            /*
            //Override with the presentation setting
            $presentation = $this->video->fresh();
            if($presentation->download) {
                $this->video->setAttribute('download', true);
            }
            */
        } else {
            $presentation = $this->video->fresh();
            if(!$presentation->download) {
                foreach($this->courses as $this->course) {
                    if($download = $this->getCourseDownloadsetting($this->course->id)) {
                        switch($download) {
                            case(0):
                                $this->video->setAttribute('download', false);
                                break;
                            case(1):
                                $this->video->setAttribute('download', true);
                                break;
                        }
                    }
                }
            }

        }
    }

    private function getCourseDownloadsetting($course_id)
    {
        return CoursesettingsPermissions::where('course_id', $course_id)->pluck('downloadable')->first();
    }
}
