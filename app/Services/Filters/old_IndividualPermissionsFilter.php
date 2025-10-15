<?php

namespace App\Services\Filters;

use App\Models\IndividualPermission;
use App\Interfaces\VisibilityInterface;
use App\Models\Video;

class oldIndividualPermissionsFilter extends VisibilityFilter implements VisibilityInterface
{
    protected $video, $user;

    public function __construct(Video $video)
    {
        $this->video = $video;
        $this->user = app()->make('play_username');
    }

    public function cast()
    {
        if($users = $this->getIndividualSettingUsers()) {
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

    private function getIndividualSettingUsers()
    {
        return IndividualPermission::where('video_id', $this->video->id)->get();
    }
}
