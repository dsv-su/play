<?php

namespace App\Services;

use App\Permission;
use App\Video;
use App\VideoPermission;
use Illuminate\Database\Eloquent\Model;

class TicketHandler extends Model
{
    protected $credentials, $video, $entitlements, $entitlement, $server, $server_entitlement;
    protected $individuals, $iper, $courseadmins, $cper;

    public function __construct(Video $video)
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
            if (!$this->token = auth()->claims(['id' => $this->video->id])->attempt($this->credentials)) {
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

        if($this->permissions == 4) {
            //If the external permission setting is set (overriding shibboleth SSO)
            return true;
        }
        elseif($this->cperm($video)) {
            //Check if user is course administrator
            return true;
        }
        elseif($this->iperm()) {
            //Check if individual permissions have been set for this presentation
            return true;
        }
        else {
            //Check group permissions

            //Get all permission entitlements
            foreach($this->permissions as $this->permission) {

                $this->entitlements = Permission::where('id', $this->permission)->pluck('entitlement');

                //Check if user entitlement exists in permission entitlement
                if (!app()->environment('local') && $this->permission != 4) {
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



    }

    //Check if user is a course administrator
    private function cperm($video)
    {
        //If app is local override
        if (app()->environment('local')) {
            return true;
        }
        else {
            //Check if user is courseadmin
            if($this->courseadmins = $video->coursepermissions ?? false) {
                foreach($this->courseadmins as $this->cper) {
                    //Check if user is listed
                    if($this->cper->username . '@su.se' == $_SERVER['eppn']) {
                        //Check if user has set permissions
                        if(in_array($this->cper->permission, ['read', 'edit', 'delete'])) {
                            return true;
                        }
                    }

                }
            }
            return false;
        }
    }

    //Check if individual permissions settings have been applied for this presentation
    private function iperm()
    {
        //If app is local override
        if (app()->environment('local')) {
            return true;
        }
        else {
            //Check if individual permissions has been set for presentation
            if($this->individuals = $this->video->ipermissions ?? false) {
                foreach($this->individuals as $this->iper) {
                    //Check if user is listed
                    if($this->iper->username . '@su.se' == $_SERVER['eppn']) {
                        //Check if user has set permissions
                        if(in_array($this->iper->permission, ['read', 'edit', 'delete'])) {
                            return true;
                        }
                    }

                }
            }
            return false;
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
