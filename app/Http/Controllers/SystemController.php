<?php

namespace App\Http\Controllers;

use App\Services\AuthHandler;
use App\Services\ConfigurationHandler;
use Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class SystemController extends Controller
{
    /**
     * Create the session, send the user away to the SU IDP
     * for authentication.
     */
    public function SUlogin()
    {
        $system = new AuthHandler();
        $system = $system->authorize();

        return Redirect::to('https://' . Request::server('SERVER_NAME')
            . ':' . Request::server('SERVER_PORT') . $system->global->login_route
            . '?target=' . action('\\' . __class__ . '@SUidpReturn'));
    }

    /**
     * Redirect user to intended route on returned successful login
     * from the SU IdP. Assign role to user.
     */

    public function SUidpReturn()
    {
        $system = new AuthHandler();
        $system = $system->authorize();

        // Get Shibboleth entitlements
        $server = explode(";", $_SERVER['entitlement']);

        // Roles
        $role_admin = $system->global->admin;
        $role_uploader = $system->global->uploader;
        $role_staff = $system->global->staff;

        // Assign role to user
        if(in_array($role_admin, $server)) {
            app()->bind('play_role', function () {
                return 'Administrator';
            });
        }
        elseif (in_array($role_uploader, $server)) {
            app()->bind('play_role', function () {
                return 'Uploader';
            });
        }
        elseif (in_array($role_staff, $server)) {
            app()->bind('play_role', function () {
                return 'Staff';
            });
        }
        else  {
            app()->bind('play_role', function () {
                return 'Student';
            });
        }

        Session::regenerate();
        return redirect()->intended('/');
    }

    public function start()
    {
        //Persist system configuration
        $init = new ConfigurationHandler();
        $init->system();
    }
}
