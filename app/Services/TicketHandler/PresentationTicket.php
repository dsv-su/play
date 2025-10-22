<?php

namespace App\Services\TicketHandler;

use App\Models\Video;
use App\Models\VideoPermission;

class PresentationTicket implements \App\Interfaces\TicketInterface
{
    protected Video $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function cast(): Video
    {
        $this->video->setAttribute('ticket_permission_id', $this->getPresentationPermission());

        return $this->video;
    }

    private function getPresentationPermission(): int
    {
        // Returns the permission_id for this video, defaulting to 1 if missing
        return (int) (VideoPermission::where('video_id', $this->video->id)->value('permission_id') ?? 1);
    }
}

