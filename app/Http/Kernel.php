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
    ];

    protected $middlewareGroups = [
        'web' => [
            \Proto\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Proto\Http\Middleware\VerifyCsrfToken::class,
            \Proto\Http\Middleware\EnforceHTTPS::class,
            \Proto\Http\Middleware\DevelopmentAccess::class,
            \Proto\Http\Middleware\EnforceTFA::class,
            \Proto\Http\Middleware\EnforceWizard::class,
            \Proto\Http\Middleware\ApiMiddleware::class,
            \Spatie\Csp\AddCspHeaders::class,
        ],
        'api' => [
            'throttle:60,1',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'member' => \Proto\Http\Middleware\Member::class,
        'utwente' => \Proto\Http\Middleware\Utwente::class,
        'forcedomain' => \Proto\Http\Middleware\ForceDomain::class,
        'saml' => \Proto\Http\Middleware\Saml::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    ];
}
