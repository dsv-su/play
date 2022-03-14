<?php

namespace App\Http\Middleware;

use App\Services\Store\CheckPlayStoreApi;
use Closure;
use Illuminate\Http\Request;

class StatusPlayStore
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $store = new CheckPlayStoreApi();
        $check = $store->call('status/daemon2');
        if(is_array($check)) {
            if ($check['running'] == true) {
                app()->bind('store_status', function () {
                    return 'on';
                });

            } else {
                app()->bind('store_status', function () {
                    return 'off';
                });
            }
        } else {
            abort(512);
        }



        return $next($request);
    }
}
