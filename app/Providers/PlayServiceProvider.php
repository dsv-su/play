<?php

namespace App\Providers;

use App\Models\Cattura;
use App\Services\AuthHandler;
use App\Services\Cattura\CatturaRecoders;
use App\Services\ConfigurationHandler;
use App\Services\CountPresentations;
use App\Services\Daisy\DaisyIntegration;
use App\Services\Filters\VisibilityFilter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        //Staff
        Gate::before(function ($user = null, string $ability, array $arguments) {
            if ($ability !== 'manage-content') return null;

            $role = app()->make('play_role');
            return in_array($role, ['Uploader', 'Courseadmin', 'Administrator'], true);
        });

        // Fallback
        Gate::define('manage-content', fn ($user = null) =>
        in_array(app('play_role'), ['Uploader', 'Courseadmin', 'Administrator'], true)
        );

        //Admin
        Gate::before(function ($user = null, string $ability, array $arguments) {
            if ($ability !== 'admin-content') return null;

            $role = app()->make('play_role');
            return in_array($role, ['Administrator'], true);
        });

        // Fallback
        Gate::define('admin-content', fn ($user = null) =>
        in_array(app('play_role'), ['Administrator'], true)
        );
    }
}
