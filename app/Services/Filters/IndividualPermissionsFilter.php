<?php

namespace App\Services\Filters;

use App\Interfaces\VisibilityInterface;
use App\Models\IndividualPermission;
use App\Models\Video;

class IndividualPermissionsFilter extends VisibilityFilter implements VisibilityInterface
{
    protected Video $video;
    protected string $username;

    public function __construct(Video $video)
    {
        $this->video    = $video;
        $this->username = app('play_username'); // same as app()->make('play_username')
    }

    public function cast(): void
    {
        // Fetch only the relevant row for this user & video
        $perm = IndividualPermission::where('video_id', $this->video->id)
            ->where('username', $this->username)
            ->first();

        if (!$perm) {
            return; // no individual override; nothing to change
        }

        // If visibility isn't already truthy, set visibility + mark as 'hidden' (your original behavior)
        if (!$this->video->getAttribute('visibility')) {
            $this->video->setAttribute('visibility', true);
            $this->video->setAttribute('hidden', true);
        }

        // Grant capabilities based on permission
        if ($perm->permission === 'edit') {
            $this->video->setAttribute('edit', true);
        } elseif ($perm->permission === 'delete') {
            $this->video->setAttribute('edit', true);
            $this->video->setAttribute('delete', true);
        }
        // else: leave as-is for view/unknown
    }
}

