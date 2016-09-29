<?php

namespace Proto\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Proto\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Proto\Http\Middleware\VerifyCsrfToken::class,

        // Our own middleware
        \Proto\Http\Middleware\EnforceHTTPS::class,
        \Proto\Http\Middleware\DevelopmentAccess::class,
        \Proto\Http\Middleware\EnforceTFA::class
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Proto\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \Proto\Http\Middleware\RedirectIfAuthenticated::class,
        'member' => \Proto\Http\Middleware\Member::class,
        'forcedomain' => \Proto\Http\Middleware\ForceDomain::class
    ];
}
