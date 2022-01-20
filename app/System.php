<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperSystem
 */
class System extends Model
{
    protected $fillable = ['app_env', 'app_debug', 'app_url', 'authorization_parameter','authorization','login_route',
        'admin','uploader','staff', 'db', 'db_host', 'db_port', 'db_database', 'db_username', 'db_password', 'url',
        'username', 'password', 'sfapikey', 'daisy_url', 'daisy_username', 'daisy_password'];
}
