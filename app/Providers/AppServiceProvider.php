<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Laravel\Passport\Passport;
use Laravel\Pennant\Feature;
use Override;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Feature::discover();

        Model::automaticallyEagerLoadRelationships();

        Passport::$clientUuids = false;
        Passport::authorizationView('vendor.passport.authorize');

        if (! $this->app->isProduction()) {
            Passport::$validateKeyPermissions = false;
        }

        Password::defaults(function () {
            $rule = Password::min(10)->max(72)->letters();

            return $this->app->isProduction()
                ? $rule->mixedCase()->numbers()->symbols()->uncompromised()
                : $rule;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    #[Override]
    public function register() {}
}
