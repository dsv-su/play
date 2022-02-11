<?php

namespace App\Services\TicketHandler;

use App\Video;

class AdminTicket extends TicketPermissionHandler implements \App\Interfaces\TicketInterface
{
    protected $video;

    public function __construct(Video $video)
    {
        parent::__construct($video);
        $this->video = $video;
    }

    public function cast()
    {
        if(app()->make('play_role') == 'Administrator') {
            $this->video->setAttribute('ticket', true);
        }
        return $this->video;
    }
}
