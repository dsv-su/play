<?php

namespace App\Services\Staff;

use App\Services\AuthHandler;

class StaffCheck
{
    protected $authHandler, $system, $auth_param, $auth;
    private $file, $system_config;

    public function __construct()
    {
        $this->authHandler = new AuthHandler();
        $this->system = $this->authHandler->authorize();
        $this->auth_param = $this->system->global->authorization_parameter;
        $this->auth = $this->staff_entitlement();
    }

    public function check()
    {
        if($_SERVER[$this->auth_param] ?? false) {
            $server_entitlements = explode(";", $_SERVER[$this->auth_param]);
            if(in_array($this->auth, $server_entitlements)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function staff_entitlement()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            abort(510);
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['global']['staff'];
    }
}
