<?php

use Illuminate\Support\Str;

$file = base_path().'/systemconfig/play.ini';
if (!file_exists($file)) {
    $file = base_path().'/systemconfig/play.ini.example';
}
$system_config = parse_ini_file($file, true);

return [

    /*
    |--------------------------------------------------------------------------
    | Default LDAP Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the LDAP connections below you wish
    | to use as your default connection for all LDAP operations. Of
    | course you may add as many connections you'd like below.
    |
    */

    'default' => env('LDAP_CONNECTION', 'default'),

    /*
    |--------------------------------------------------------------------------
    | LDAP Connections
    |--------------------------------------------------------------------------
    |
    | Below you may configure each LDAP connection your application requires
    | access to. Be sure to include a valid base DN - otherwise you may
    | not receive any results when performing LDAP search operations.
    |
    */

    'connections' => [

        'default' => [
            //'hosts' => [env('LDAP_HOST', '127.0.0.1')],
            'hosts' => [$system_config['sukat']['host']],
            //'username' => env('LDAP_USERNAME', 'cn=user,dc=local,dc=com'),
            'username' => $system_config['sukat']['username'],
            //'password' => env('LDAP_PASSWORD', 'secret'),
            'password' => $system_config['sukat']['password'],
            //'port' => env('LDAP_PORT', 389),
            'port' => $system_config['sukat']['port'],
            //'base_dn' => env('LDAP_BASE_DN', 'dc=local,dc=com'),
            'base_dn' => $system_config['sukat']['base_dn'],
            //'timeout' => env('LDAP_TIMEOUT', 5),
            'timeout' => $system_config['sukat']['timeout'],
            'use_ssl' => env('LDAP_SSL', false),
            'use_tls' => env('LDAP_TLS', false),

        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | LDAP Logging
    |--------------------------------------------------------------------------
    |
    | When LDAP logging is enabled, all LDAP search and authentication
    | operations are logged using the default application logging
    | driver. This can assist in debugging issues and more.
    |
    */

    'logging' => env('LDAP_LOGGING', true),

    /*
    |--------------------------------------------------------------------------
    | LDAP Cache
    |--------------------------------------------------------------------------
    |
    | LDAP caching enables the ability of caching search results using the
    | query builder. This is great for running expensive operations that
    | may take many seconds to complete, such as a pagination request.
    |
    */

    'cache' => [
        'enabled' => env('LDAP_CACHE', false),
        'driver' => env('CACHE_DRIVER', 'file'),
    ],

];
