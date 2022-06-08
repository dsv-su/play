<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use ConsoleTVs\Charts\Registrar as Charts;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Charts $charts)
    {
        Paginator::useBootstrap();
        //Bypass until php7.4
        /*$charts->register([
            \App\Charts\PresentationStats::class
        ]);*/
    }
}
