<?php

namespace Proto\Providers;

use Illuminate\Support\Facades\Auth;
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
        view()->composer('website.layouts.macros.achievement-popup', function ($view) {
            if (Auth::check()) {
                $newAchievementsQuery = Auth::user()->achievements()->where('alerted', false);
                $newAchievements = $newAchievementsQuery->get();
                $newAchievementsQuery->update(['alerted' => true]);
                $view->with('newAchievements', $newAchievements);
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
