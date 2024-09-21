<?php

namespace App\Providers;

use App\Models\MenuItem;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        view()->composer('*', function ($view) {
            view()->share('viewName', Str::replace('.', '-', $view->getName()));
        });

        view()->composer('website.navbar', static function ($view) {
            $menuItems = MenuItem::query()->where('parent', null)->orderBy('order')->with('page')->with('children')->get();
            $view->with('menuItems', $menuItems);
        });

        view()->composer('components.modals.achievement-popup', static function ($view) {
            if (Auth::check()) {
                $newAchievementsQuery = Auth::user()->achievements()->where('alerted', false);
                $newAchievements = $newAchievementsQuery->get();
                if (count($newAchievements) > 0) {
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
