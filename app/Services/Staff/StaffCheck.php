<?php

namespace App\Services\Staff;

use App\Services\AuthHandler;

class StaffCheck
{
    protected $authHandler, $system, $auth_param, $auth;

    public function __construct()
    {
        $this->authHandler = new AuthHandler();
        $this->system = $this->authHandler->authorize();
        $this->auth_param = $this->system->global->authorization_parameter;
        $this->auth = 'urn:mace:swami.se:gmai:dsv-user:staff';
    }

    public function is()
    {
        $test = 'urn:mace:swami.se:gmai:dsv-user:staff;urn:mace:swami.se:gmai:dsv-user:cms;urn:mace:swami.se:gmai:dsv-user:dmc;urn:mace:swami.se:gmai:dsv-user:play-admin;urn:mace:swami.se:gmai:dsv-user:play-uploader;urn:mace:swami.se:gmai:dsv-user:toker-test;urn:mace:swami.se:gmai:dsv-user:gdpr-test';
        $server_entitlements = explode(";", $test);
        //dd($this->auth,$server_entitlements);
        //$server_entitlements = explode(";", $_SERVER[$this->auth_param]);
        if(in_array($this->auth, $server_entitlements)) {
            return true;
        } else {
            return false;
        }
    }
}
