<?php

namespace App\Services;

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
            if (!$this->token = auth()->claims(['id' => $this->video->id])->setTTL(60)->attempt($this->credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
                }
            }
            else {
                $this->token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.Not authorized';
                }


        return $this->token;

    }

    private function check_permission($video)
    {
        if($video->permission == 'true')
        {
            // If the environment is not local
            if (!app()->environment('local')) {
                //Check entitlements
                $this->entitlements = explode(";", $video->entitlement);
                $this->server = explode(";", $_SERVER['entitlement']);
                foreach($this->entitlements as $this->entitlement)
                {
                    foreach($this->server as $this->server_entitlement)
                    {
                        if($this->entitlement == $this->server_entitlement) return true;
                    }
                }
            }

            return false;
        }
        else {
            return true;
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
