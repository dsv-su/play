<?php

namespace App\Services\Filters;

use App\Interfaces\VisibilityInterface;
use App\Models\Video;

class AdminPermissionsFilter extends VisibilityFilter implements VisibilityInterface
{
    protected Video $video;
    protected string $role;

    public function __construct(Video $video)
    {
        $this->video = $video;
        $this->role = (string) app('play_role');
        // or: $this->role = (string) app()->make('play_role');
    }

    /**
     * If the current user is an Administrator:
     * - mark the video as editable & deletable
     * - if not visible already, mark it as 'hidden' (your original behavior)
     *
     * Return true when admin rules applied, otherwise null.
     */
    public function cast()
    {
        if (!$this->isAdmin()) {
            return;
        }

        if (!$this->video->getAttribute('visibility')) {
            // Keep your original behavior: do NOT force visibility true;
            // just mark as 'hidden' if it's not visible.
            $this->video->setAttribute('hidden', true);
        }

        $this->video->setAttribute('edit', true);
        $this->video->setAttribute('delete', true);

        return true;
    }

    private function isAdmin(): bool
    {
        // Strict comparison; adjust string to match your actual role name.
        return $this->role === 'Administrator';
    }
}

