<?php

namespace App\Services\TicketHandler;

use App\Video;
use App\VideoPermission;

class PresentationTicket extends TicketPermissionHandler implements \App\Interfaces\TicketInterface
{
    protected $video;

    public function __construct(Video $video)
    {
        parent::__construct($video);
        $this->video = $video;
    }

    public function cast()
    {
        $this->video->setAttribute('ticket_permission_id', $this->getPresentationPermission());

        return $this->video;
    }

    private function getPresentationPermission()
    {
        return VideoPermission::where('video_id', $this->video->id)->pluck('permission_id')->first();
    }
}
