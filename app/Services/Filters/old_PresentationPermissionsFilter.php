<?php

namespace App\Services\Filters;

use App\Models\Video;

class oldPresentationPermissionsFilter extends VisibilityFilter implements \App\Interfaces\VisibilityInterface
{
    protected $video, $permissions, $permission;

    public function __construct(Video $video)
    {
        $this->video = $video;
        //Retrive all the related permissions
        $this->permissions = $video->status;
    }
    public function cast()
    {
        //Set a permission type
        foreach($this->permissions as $this->permission) {
            if($id = $this->permission->permission_id) {
                switch($id) {
                    case(1):
                        $this->video->setAttribute('permission_type', 'dsv');
                        break;
                    case(2):
                        $this->video->setAttribute('permission_type', 'dsv_staff');
                        break;
                    case(3):
                        $this->video->setAttribute('permission_type', 'custom');
                        break;
                    case(4):
                        $this->video->setAttribute('permission_type', 'public');
                        break;
                    default:
                        $this->video->setAttribute('permission_type', 'custom');
                }
            }
        }
    }
}
