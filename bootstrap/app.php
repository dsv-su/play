<?php

use App\Http\Middleware\CheckEditPermission;
use App\Http\Middleware\CheckEntitlement;
use App\Http\Middleware\CheckPresentationPermission;
use App\Http\Middleware\CheckVideoPermission;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Middleware\PlayAdmin;
use App\Http\Middleware\PlayAuthenticate;
use App\Http\Middleware\Playback;
use App\Http\Middleware\RedirectLinks;
use App\Http\Middleware\SetLocale;
use App\Providers\AppServiceProvider;
use App\Providers\PlayServiceProvider;
use App\Providers\SystemServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append([

        ]);

        $middleware->encryptCookies(['language']); // exclude from encryption
        $middleware->web(append: [
            SetLocale::class,
        ]);
        $middleware->alias([
            'playauth' => PlayAuthenticate::class,
            'play-admin' => PlayAdmin::class,
            'entitlements' => CheckEntitlement::class,
            'playback' => Playback::class,
            'video-permission' => CheckVideoPermission::class,
            'presentation-permission' => CheckPresentationPermission::class,
            'redirect-links' => RedirectLinks::class,
            'edit-permission' => CheckEditPermission::class,
            'jwt' => JwtMiddleware::class,
        ]);

    })
    ->withProviders([
        AppServiceProvider::class,
        PlayServiceProvider::class,
        SystemServiceProvider::class,
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
