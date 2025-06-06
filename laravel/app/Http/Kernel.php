<?php

namespace App\Http;

use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        #\Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        #\Illuminate\Foundation\Http\Middleware\TrimStrings::class,
        #\Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            #EncryptCookies::class,
            #\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            #\Illuminate\Session\Middleware\StartSession::class,
            #\Illuminate\View\Middleware\ShareErrorsFromSession::class,
            #VerifyCsrfToken::class,
            #\Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            #// \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            #// \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            #\Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

}
