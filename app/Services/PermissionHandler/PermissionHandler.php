<?php

namespace App\Services\PermissionHandler;

use App\VideoPermission;
use LdapRecord\Models\Model;

class PermissionHandler extends Model
{
    protected $notification_id, $video, $video_permission;
    protected $perm, $permission;

    public function __construct($request, $video)
    {
        $this->notification_id = $request->notification_id;
        $this->video_id = $request->id;
        $this->video = $video;
    }

    public function setPermission()
    {
        //Check if video or notification exists

        //If there is a notification id
        /*if($this->notification_id) {
            if(! $this->video_permission = VideoPermission::where('notification_id', $this->notification_id)->first()) {
                //No permissions exist with a notification_id -> store notification_id and set default permission
                $this->permission = VideoPermission::create([
                    'video_id' => $this->video_id[0],
                    'notification_id' => $this->notification_id,
                    'permission_id' => 1,
                    'type' => 'public',
                ]);

            } else {
                // A permission with notification_id exist -> Update with video uid
                $this->video_permission->video_id = $this->video->id;
                $this->video_permission->save();
            }
        }*/

        //If there exist a permission setting with uuid
        if(!$this->video_permission = VideoPermission::where('reference_id', $this->video->id)->first()) {
            //No permissions exist -> set default permission
            $this->permission = VideoPermission::create([
                'video_id' => $this->video->id,
                'permission_id' => 1,
                'type' => 'public',
            ]);
        } else {
                // A permission exist -> update
                $this->video_permission->video_id = $this->video->id;
                $this->video_permission->save();
            }

        }

}
