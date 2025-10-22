<?php

namespace App\Services\TicketHandler;

use App\Models\Video;

class CourseAdminTicket implements \App\Interfaces\TicketInterface
{
    protected Video $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function cast(): Video
    {
        $remote = $_SERVER['REMOTE_USER'] ?? null;
        if (!$remote) {
            return $this->video;
        }

        // DB stores usernames without domain
        $username = explode('@', $remote, 2)[0];

        $hasTicket = $this->video->coursepermissions()
            ->where('username', $username)
            ->where('permission', 'delete') // keep your original rule
            ->exists();

        if ($hasTicket) {
            $this->video->setAttribute('ticket', true);
        }

        return $this->video;
    }
}

