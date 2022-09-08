<?php

namespace App\Services\Course;

use App\CoursesettingsPermissions;
use App\Video;
use App\VideoCourse;

class DefaultCourseSettings
{
    protected $video;
    protected $course_visibility = [];
    protected $course_download = [];

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function setCourseDefaultSettings()
    {
        //Retrive all courses associated with the presentation
        $courses = VideoCourse::where('video_id', $this->video->id)->pluck('course_id');
        foreach ($courses as $course) {
            if($coursesetting = $this->getCourseSetting($course)) {
                $this->course_visibility[] = $coursesetting->visibility;
                $this->course_download[] = $coursesetting->downloadable;
            } else {
                //Fallback to default setting
                $this->course_visibility[] = true;
                $this->course_download[] = false;
            }
        }
        //Check visibility
        if(in_array(true, $this->course_visibility)){
            $this->video->visibility = true;
        } else {
            $this->video->visibility = false;
        }
        //Check downloadability
        if(in_array(true, $this->course_download)){
            $this->video->download = true;
        } else {
            $this->video->download = false;
        }
        $this->video->save();
    }

    private function getCourseSetting($course_id)
    {
        return CoursesettingsPermissions::where('course_id', $course_id)->first();
    }

}
