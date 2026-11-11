<?php

namespace App\Services\Ldap;

use LdapRecord\Connection;
use LdapRecord\Container;

class LdapContainer
{
    public function bind()
    {
        $connection = new Connection([
            'hosts' => ['ldap.su.se'],
            'username' => null,
            'password' => null,
        ]);
        $connection->connect();

        Container::addConnection($connection);
    }
}
