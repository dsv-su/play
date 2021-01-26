<?php

namespace App\Http\Middleware;

use App\Services\AuthHandler;
use Closure;
use Illuminate\Http\Request;


class CheckEntitlement
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $system = new AuthHandler();
        $system = $system->authorize();
        $auth_param = $system->global->authorization_parameter;
        //$authstring = $system->global->authorization; //For multiple entitlements
        $entitlement = $system->global->authorization;
        //$auth = explode(";", $authstring); //For multiple entitlements
        $match = 0;
        if(!$request->server('REMOTE_USER'))
        {
            if($system->global->app_env == 'local') {
                return $next($request);
            } else {
                return redirect()->guest(route('sulogin'));
            }
        }
        else
        {
            $server = explode(";", $_SERVER[$auth_param]);
            //foreach ($auth as $entitlement)  //For multiple entitlements
            //{                                 //For multiple entitlements
                foreach($server as $server_entitlement)
                {
                    if($entitlement == $server_entitlement)
                    {
                        $match++;
                    }
                }
            //} //For multiple entitlements
        }

        if ($match !== 1)
        {
            abort(401);

        }

        return $next($request);
    }
}
