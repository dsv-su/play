<?php

namespace App\Services\Filters;

use App\CourseadminPermission;
use App\Interfaces\VisibilityInterface;
use App\Video;

class CourseAdminPermissionFilter extends VisibilityFilter implements VisibilityInterface
{
    protected $user, $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
        $this->user = app()->make('play_username');
    }

    public function cast()
    {
        if($users = $this->getCourseAdminUsers()) {
            foreach($users as $user) {
                if($user->username == $this->user) {
                    if(!$this->video->visibility) {
                        $this->video->setAttribute('visibility', true);
                        $this->video->setAttribute('hidden', true);
                    }
                    switch($user->permission) {
                        case('edit'):
                            $this->video->setAttribute('edit', true);
                            break;
                        case('delete'):
                            $this->video->setAttribute('edit', true);
                            $this->video->setAttribute('delete', true);
                    }
                }
            }
        }
    }

    private function getCourseAdminUsers()
    {
        return CourseadminPermission::where('video_id', $this->video->id)->get();
    }

}
