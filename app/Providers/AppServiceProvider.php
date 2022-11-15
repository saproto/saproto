<?php

namespace Proto\Providers;

use Illuminate\Pagination\Paginator;
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
        Paginator::useBootstrapFive();

        view()->composer('website.navigation.navbar', function ($view) {
            $menuItems = MenuItem::where('parent', null)->orderBy('order')->with('page')->with('children')->get();
            $view->with('menuItems', $menuItems);
        });

        view()->composer('website.layouts.macros.achievement-popup', function ($view) {
            if (Auth::check()) {
                $newAchievementsQuery = Auth::user()->achievements()->where('alerted', false);
                $newAchievements = $newAchievementsQuery->get();
                if(count($newAchievements) > 0) {
                    $newAchievementsQuery->update(['alerted' => true]);
                    $view->with('newAchievements', $newAchievements);
                }
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
