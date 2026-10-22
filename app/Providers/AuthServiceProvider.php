<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Date;
use Laravel\Passport\Passport;
use Override;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    #[Override]
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     */
    public function boot(): void
    {
        Passport::tokensExpireIn(Date::now()->addDays(7));
        Passport::refreshTokensExpireIn(Date::now()->addDays(14));
    }
}
