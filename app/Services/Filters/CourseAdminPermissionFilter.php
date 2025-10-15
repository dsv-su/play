<?php

namespace App\Services\Filters;

use App\Interfaces\VisibilityInterface;
use App\Models\CourseadminPermission; // Ensure this class name matches your actual model
use App\Models\Video;

class CourseAdminPermissionFilter extends VisibilityFilter implements VisibilityInterface
{
    protected Video $video;
    protected string $username;

    public function __construct(Video $video)
    {
        $this->video    = $video;
        $this->username = app('play_username');
    }

    public function cast(): void
    {
        // Only fetch the current user's admin permission for this video
        $perm = CourseadminPermission::where('video_id', $this->video->id)
            ->where('username', $this->username)
            ->first();

        if (!$perm) {
            return; // no admin override
        }

        // If not already visible, set visible + mark hidden (same as your original logic)
        if (!$this->video->getAttribute('visibility')) {
            $this->video->setAttribute('visibility', true);
            $this->video->setAttribute('hidden', true);
        }

        // Capabilities
        if ($perm->permission === 'edit') {
            $this->video->setAttribute('edit', true);
        } elseif ($perm->permission === 'delete') {
            $this->video->setAttribute('edit', true);
            $this->video->setAttribute('delete', true);
        }
        // else: leave as-is for view/unknown
    }
}
