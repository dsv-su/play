<?php

namespace App\Http\Controllers;

use App\Services\AuthHandler;
use App\Services\ConfigurationHandler;
use App\Services\Daisy\DaisyIntegration;
use App\System;
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
     * from the SU IdP.
     */

    public function SUidpReturn()
    {
        Session::regenerate();
        return redirect()->intended('/');
    }

    public function start()
    {
        if (!System::find(1)) {
            //Initiate system
            app()->make('init')->check_system();
            return redirect()->action([SystemController::class, 'start']);
        } else {
            $daisy = new DaisyIntegration();
            $daisy->init();
            return redirect('/')->with(['message' => 'Play has initiated successfully!', 'alert' => 'alert-success']);
        }
    }
}
