<?php

namespace App\Providers;

use App\Cattura;
use App\Services\AuthHandler;
use App\Services\Cattura\CatturaRecoders;
use App\Services\ConfigurationHandler;
use App\Services\CountPresentations;
use App\Services\Daisy\DaisyIntegration;
use App\Services\Filters\VisibilityFilter;
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

        app()->singleton('authHandler', function(){
            return new AuthHandler();
        });

        app()->singleton('daisyIntegration', function(){
            return new DaisyIntegration();
        });

        app()->singleton('cattura', function(){
            return new CatturaRecoders(new Cattura());
        });

        app()->singleton('countpresentations', function(){
            return new CountPresentations();
        });

        app()->bind('visibility', function(){
            return new VisibilityFilter();
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
