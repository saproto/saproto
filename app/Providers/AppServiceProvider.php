<?php

namespace Proto\Providers;

use Illuminate\Support\ServiceProvider;
use Proto\Models\MenuItem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('website.navigation.navbar', function ($view) {
            $menuItems = MenuItem::where('parent', null)->orderBy('order')->get();
            $view->with('menuItems', $menuItems);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
