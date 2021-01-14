<?php

namespace App\Providers;

use App\Services\ConfigurationHandler;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class PlayServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        app()->singleton('init', function(){
            return new ConfigurationHandler();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // If the environment is local
        if (app()->environment('local')) {
            $play_user = 'Developer';
        } else {
            $play_user = $_SERVER['displayName'];
        }

        View::share('play_user', $play_user);
    }
}
