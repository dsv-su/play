<?php

namespace App\Providers;

use App\Cattura;
use App\Services\Cattura\CatturaRecoders;
use App\Services\ConfigurationHandler;
use App\Services\CountPresentations;
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

        app()->singleton('cattura', function(){
            return new CatturaRecoders(new Cattura());
        });

        app()->singleton('countpresentations', function(){
            return new CountPresentations();
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
