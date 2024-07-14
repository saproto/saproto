<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use App\Handlers\Events\AuthLoginEventHandler;
use Aacotroneo\Saml2\Events\Saml2LoginEvent;
use App\Handlers\Events\SamlLoginEventHandler;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Login::class => [
            AuthLoginEventHandler::class,
        ],
        Saml2LoginEvent::class => [
            SamlLoginEventHandler::class,
        ],
    ];

    /**
     * Register any other events for your application.
     */
    public function boot(): void
    {
        parent::boot();
    }
}
