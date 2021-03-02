<?php

namespace App\Http\Middleware;

use App\Services\Store\CheckPlayStoreApi;
use App\Services\CountPresentations;
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
        $check = $store->call('daemon-status');
        if($check['running'] == true) {
            app()->bind('store_status', function() {
                return 'on';
            });
            app()->bind('total_videos', function() {
                $videos = new CountPresentations();
                return $videos->latest();
            });
        }
        else {
            app()->bind('store_status', function() {
                return 'off';
            });
        }
        return $next($request);
    }
}
