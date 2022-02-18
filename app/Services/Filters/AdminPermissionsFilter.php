<?php

namespace App\Services\Filters;

use App\Interfaces\VisibilityInterface;
use App\Video;

class AdminPermissionsFilter extends VisibilityFilter implements VisibilityInterface
{
    protected $user, $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
        //$this->user = app()->make('play_auth'); //Use in production
        $this->user = app()->make('play_role');
    }

    public function cast()
    {
        if($this->getAdminUsers()) {
            if(!$this->video->visibility) {
                $this->video->setAttribute('visibility', true);
                $this->video->setAttribute('hidden', true);
            }
            $this->video->setAttribute('edit', true);
            $this->video->setAttribute('delete', true);
        }
    }

    private function getAdminUsers()
    {
        if($this->user == 'Administrator') {
            return true;
        } else {
            return false;
        }
    }
}
