<?php

namespace App\Services\Ldap;

use LdapRecord\Container;
use LdapRecord\Connection;

class LdapContainer
{
    public function bind()
    {
        $connection = new Connection([
            'hosts'    => ['ldap.su.se'],
            'username' => null,
            'password' => null,
        ]);
        $connection->connect();

        Container::addConnection($connection);
    }
}
