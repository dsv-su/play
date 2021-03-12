<?php

namespace App\Services;

use App\Permission;
use App\VideoPermission;
use Illuminate\Database\Eloquent\Model;

class TicketHandler extends Model
{
    protected $credentials, $video, $entitlements, $entitlement, $server, $server_entitlement;

    public function __construct($video)
    {
        $this->video = $video;

    }

    public function issue()
    {
        $this->credentials = [
            'email'=> $this->ticket_user(),
            'password' => $this->ticket_pass()
        ];

        //Check permission for requested video
        if($this->check_permission($this->video)) {
            //Issue a valid ticket for requester
            if (!$this->token = auth()->attempt($this->credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
                }
            }
            else {
                $this->token = '';
                //abort(401);
                }


        return $this->token;

    }

    private function check_permission($video)
    {
        //Get all permissions for the video
        $this->permissions = VideoPermission::where('video_id', $video->id)->pluck('permission_id');

        //Get all permission entitlements
        foreach($this->permissions as $this->permission) {
            $this->entitlements = Permission::where('id', $this->permission)->pluck('entitlement');

            //Check if user entitlement exists in permission entitlement
            if (!app()->environment('local')) {
                foreach ($this->entitlements as $this->entitlement) {
                    $this->explicit_entitlements = explode(";", $this->entitlement);
                    $this->server = explode(";", $_SERVER['entitlement']);
                    foreach ($this->explicit_entitlements as $this->explicit_entitlement) {
                        foreach ($this->server as $this->server_entitlement) {
                            if ($this->explicit_entitlement == $this->server_entitlement) return true;
                        }
                    }

                }
                //
            } else {
                return true;
            }
        }
    }

    private function ticket_user()
    {
        $this->file = base_path().'/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path().'/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['ticket']['email'];
    }

    private function ticket_pass()
    {
        $this->file = base_path().'/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path().'/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['ticket']['password'];
    }

}
