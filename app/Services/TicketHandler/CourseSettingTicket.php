<?php

namespace App\Services\TicketHandler;

use App\CoursePermissions;
use App\Video;

class CourseSettingTicket extends TicketPermissionHandler implements \App\Interfaces\TicketInterface
{
    protected $video, $courses, $courseSettings;

    public function __construct(Video $video)
    {
        parent::__construct($video);
        $this->video = $video;
        $this->courses = $video->courses();
    }

    public function cast()
    {
        //Collect all coursesettings
        foreach($this->courses as $this->course) {
            $this->courseSettings[] = $this->getCoursePermissionId($this->course->id);
            }
        if($this->courseSettings) {
            if (count($this->courseSettings) > 1) {
                //If there exist multiple settings -> set default to dsv students and staff
                $this->video->setAttribute('ticket_permission_id', 1);
            } else {
                $this->video->setAttribute('ticket_permission_id', $this->courseSettings[0]);
            }
        }
        return $this->video;
    }

    private function getCoursePermissionId($course_id)
    {
        return CoursePermissions::where('course_id', $course_id)->pluck('permission_id')->first();
    }
}
