<?php

namespace App\Exceptions;

use App\Jobs\JobDevNotification;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Throwable;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     * These will be respected by shouldntReport().
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        TokenExpiredException::class,
        TokenBlacklistedException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
        'current_password',
        'new_password',
        'new_password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        // Central place to report exceptions (e.g., send dev notifications).
        $this->reportable(function (Throwable $e) {

            // Respect the dontReport list and any framework defaults.
            if ($this->shouldntReport($e)) {
                return;
            }

            $request = request();

            $exception = [
                'server'   => config('app.name'),
                'env'      => config('app.env'),
                'name'     => get_class($e),
                'message'  => $e->getMessage(),
                'file'     => $e->getFile(),
                'line'     => $e->getLine(),
                'url'      => $request?->fullUrl(),
                'method'   => $request?->method(),
                'ip'       => $request?->ip(),
                'input'    => $request ? Arr::except($request->all(), $this->dontFlash) : null,
                'headers'  => $request ? [
                    'user_agent' => $request->userAgent(),
                    'accept'     => $request->header('accept'),
                    'referer'    => $request->header('referer'),
                ] : null,
            ];

            // Dispatch a queued job to notify devs. Delay a few seconds so we don't block.
            try {
                JobDevNotification::dispatch($exception)->delay(now()->addSeconds(5));

            } catch (Throwable $dispatchError) {
                // Never break exception handling if notifications fail.
                Log::error('[Exception Notify] Failed to dispatch JobDevNotification', [
                    'error' => $dispatchError->getMessage(),
                ]);
            }
        });
    }

    /**
     * Report or log an exception.
     */
    public function report(Throwable $e): void
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }
}
