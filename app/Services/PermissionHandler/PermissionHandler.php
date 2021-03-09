<?php

namespace App\Services\PermissionHandler;

use App\VideoPermission;
use LdapRecord\Models\Model;

class PermissionHandler extends Model
{
    protected $notification_id, $video, $video_permission;
    protected $vperm, $perm;

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
        if(!is_null($this->notification_id)) {
            if(!$this->video_permission = VideoPermission::where('notification_id', $this->notification_id)->first()) {
                //No permissions exist
                $this->permission = VideoPermission::create([
                    'video_id' => $this->video_id,
                    'notification_id' => $this->notification_id,
                    'permission_id' => 1,
                    'type' => 'public',
                ]);
            } else {
                //Update with video uid
                $this->video_permission->video_id = $this->video->id;
                $this->video_permission->save();
            }
        }

        //If there exist a permission setting
        if(!$this->video_permission = VideoPermission::where('video_id', $this->video->id)->first()) {
            //No permissions exist
            $this->permission = VideoPermission::create([
                'video_id' => $this->video->id,
                'permission_id' => 1,
                'type' => 'public',
            ]);
        } else {
                $this->video_permission->video_id = $this->video->id;
                $this->video_permission->save();
            }

        }

}
