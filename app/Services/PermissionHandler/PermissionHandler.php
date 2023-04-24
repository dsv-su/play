<?php

namespace App\Services\PermissionHandler;

use App\VideoPermission;
use LdapRecord\Models\Model;

class PermissionHandler extends Model
{
    protected $request, $video, $video_permission;
    protected $perm, $permission;

    public function __construct($request, $video)
    {
        $this->request = $request;
        $this->video_id = $request->id;
        $this->video = $video;
    }

    public function setPermission()
    {
        //If there exist a permission setting with uuid
        if(!$this->video_permission = VideoPermission::where('jobid', $this->request->jobid)->first()) {
            //No permissions exist -> set default permission
            $this->permission = VideoPermission::updateOrCreate(
                ['video_id' => $this->video->id],
                ['permission_id' => 1, 'type' => 'public']
            );
        } else {
                // A permission exist -> update
                $this->video_permission->video_id = $this->video->id;
                $this->video_permission->save();
            }

        }

}
