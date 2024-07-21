<?php

namespace App\Providers;

use Aacotroneo\Saml2\Events\Saml2LoginEvent;
use App\Handlers\Events\AuthLoginEventHandler;
use App\Handlers\Events\SamlLoginEventHandler;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     * @var array<string, array<string>>
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
