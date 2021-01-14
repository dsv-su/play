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
       //
    }
}
