<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append([

        ]);
        $middleware->encryptCookies(['language']); // exclude from encryption
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);
        $middleware->alias([
            'playauth' => \App\Http\Middleware\PlayAuthenticate::class,
            'entitlements' => \App\Http\Middleware\CheckEntitlement::class,
            'playback' => \App\Http\Middleware\Playback::class,
            'video-permission' => \App\Http\Middleware\CheckVideoPermission::class,
            'presentation-permission' => \App\Http\Middleware\CheckPresentationPermission::class,
            'redirect-links' => \App\Http\Middleware\RedirectLinks::class,
            'edit-permission' => \App\Http\Middleware\CheckEditPermission::class,
        ]);


    })
    ->withProviders([
        App\Providers\AppServiceProvider::class,
        App\Providers\PlayServiceProvider::class,
        App\Providers\SystemServiceProvider::class,
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
