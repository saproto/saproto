<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Events\DatabaseRefreshed;
use Illuminate\Support\Facades\Artisan;
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
                app(PermissionRegistrar::class)->forgetCachedPermissions();
            });
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    #[Override]
    public function register()
    {
    }
}
