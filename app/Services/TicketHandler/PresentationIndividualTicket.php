<?php

namespace App\Services\TicketHandler;

use App\Video;

class PresentationIndividualTicket extends TicketPermissionHandler implements \App\Interfaces\TicketInterface
{
    protected $video, $iperm;

    public function __construct(Video $video)
    {
        parent::__construct($video);
        $this->video = $video;
    }

    public function cast()
    {
        foreach ($this->video->ipermissions as $this->iperm) {
            if($this->iperm->username == app()->make('play_username') && in_array($this->iperm->permission, ['read', 'edit', 'delete'])) {
                $this->video->setAttribute('ticket', true);
            }
        }
        return $this->video;
    }
}
