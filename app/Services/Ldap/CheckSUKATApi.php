<?php

namespace App\Services\Ldap;

use LdapRecord\Container;

class CheckSUKATApi
{
    //Checks if the default LDAP container instance exists
    public function call()
    {
        if (Container::getInstance()->exists('default')) {
            return true;
        }
        else return false;
    }
}
