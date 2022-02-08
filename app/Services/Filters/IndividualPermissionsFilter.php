<?php

namespace App\Services\Filters;

use App\IndividualPermission;
use App\Interfaces\VisibilityInterface;
use App\Video;

class IndividualPermissionsFilter extends VisibilityFilter implements VisibilityInterface
{
    protected $video, $user;

    public function __construct(Video $video)
    {
        parent::__construct($video);
        $this->video = $video;
        $this->user = app()->make('play_username');
    }

    public function cast()
    {
        if($users = $this->getIndividualSettingUsers()) {
            foreach($users as $user) {
                if($user->username == $this->user) {
                    switch($user->permission) {
                        case('read'):
                            $this->video->setAttribute('visibility', true);
                            break;
                        case('edit'):
                            $this->video->setAttribute('visibility', true);
                            $this->video->setAttribute('edit', true);
                            break;
                        case('delete'):
                            $this->video->setAttribute('visibility', true);
                            $this->video->setAttribute('edit', true);
                            $this->video->setAttribute('delete', true);
                    }
                }
            }
        }
    }

    private function getIndividualSettingUsers()
    {
        return IndividualPermission::where('video_id', $this->video->id)->get();
    }
}
