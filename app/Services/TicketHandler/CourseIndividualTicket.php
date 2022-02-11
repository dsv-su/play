<?php

namespace App\Services\TicketHandler;

use App\CoursesettingsUsers;
use App\Video;

class CourseIndividualTicket extends TicketPermissionHandler implements \App\Interfaces\TicketInterface
{
    protected $video, $courses;

    public function __construct(Video $video)
    {
        parent::__construct($video);
        $this->video = $video;
        $this->courses = $video->courses();
    }

    public function cast()
    {
        foreach($this->courses as $this->course) {
            if($setting = $this->getCourseIndividuals($this->course->id)) {
                //Check if user is listed
                if($setting->username == app()->make('play_username') && in_array($setting->permission, ['read', 'edit', 'delete'])) {
                    $this->video->setAttribute('ticket', true);
                }
            }
        }
        return $this->video;
    }

    private function getCourseIndividuals($course_id)
    {
        return CoursesettingsUsers::where('course_id', $course_id)->first();
    }
}
