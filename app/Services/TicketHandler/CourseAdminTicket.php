<?php

namespace App\Services\TicketHandler;

use App\Video;

class CourseAdminTicket extends TicketPermissionHandler implements \App\Interfaces\TicketInterface
{
    protected $video, $cadmin;

    public function __construct(Video $video)
    {
        parent::__construct($video);
        $this->video = $video;
    }

    public function cast()
    {
        foreach ($this->video->coursepermissions as $this->cadmin) {
            if($this->cadmin->username. '@su.se' == $_SERVER['REMOTE_USER'] && $this->cadmin->permission == 'delete') {
                $this->video->setAttribute('ticket', true);
            }
        }
        return $this->video;
    }
}
