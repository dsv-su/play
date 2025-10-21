<?php

namespace App\Services\TicketHandler;

use App\Models\Video;

class PresentationIndividualTicket extends TicketPermissionHandler implements \App\Interfaces\TicketInterface
{
    protected Video $video;

    public function __construct(Video $video)
    {
        parent::__construct($video);
        $this->video = $video;
    }

    public function cast(): Video
    {
        $remote = $_SERVER['REMOTE_USER'] ?? null;
        if (!$remote) {
            // No authenticated remote user nothing to grant
            return $this->video;
        }

        // Compare using the REMOTE_USER "local part" (before the @)
        // since the DB stores usernames without the domain.
        $local = explode('@', $remote, 2)[0];

        // Check if this user has an individual permission for this video
        // and that permission is one of read/edit/delete.
        $hasTicket = $this->video->individualPermissions
            ->where('username', $local)
            ->whereIn('permission', ['read', 'edit', 'delete'])
            ->exists();

        if ($hasTicket) {
            $this->video->setAttribute('ticket', true);
        }

        return $this->video;
    }
}

