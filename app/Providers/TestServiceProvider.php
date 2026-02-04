<?php

namespace App\Providers;

use Illuminate\Database\Events\DatabaseRefreshed;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Override;
use Spatie\Permission\PermissionRegistrar;

class TestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('testing')) {
            Event::listen(DatabaseRefreshed::class, function () {
                Artisan::call('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);
                resolve(PermissionRegistrar::class)->forgetCachedPermissions();
            });
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    #[Override]
    public function register() {}
}
