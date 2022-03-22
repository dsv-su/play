<?php

namespace App\Services\TicketHandler;

use App\Permission;
use App\Services\AuthHandler;

class Entitlement
{
    protected $entitlement, $explicit_entitlements, $explicit_entitlement, $server, $server_entitlement;

    public function validate($id)
    {
        if(app()->environment('local') or $id == 4) {
           return true;
        } else {
            $system = app(AuthHandler::class);
            $this->entitlement = Permission::where('id', $id)->pluck('entitlement')->first();
            $this->explicit_entitlements = explode(";", $this->entitlement);
            if(!isset($_SERVER[$system->global->authorization_parameter])) {
                return false;
            }
            $this->server = explode(";", $_SERVER[$system->global->authorization_parameter]);
            foreach ($this->explicit_entitlements as $this->explicit_entitlement) {
                foreach ($this->server as $this->server_entitlement) {
                    if ($this->explicit_entitlement == $this->server_entitlement) return true;
                }
            }
            return false;
        }

    }
}
