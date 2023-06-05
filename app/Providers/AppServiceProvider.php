<?php

namespace Proto\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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

        view()->composer('website.navbar', function ($view) {
            $menuItems = MenuItem::where('parent', null)->orderBy('order')->with('page')->with('children')->get();
            $view->with('menuItems', $menuItems);
        });

        view()->composer('components.modals.achievement-popup', function ($view) {
            if (Auth::check()) {
                $newAchievementsQuery = Auth::user()->achievements()->where('alerted', false);
                $newAchievements = $newAchievementsQuery->get();
                if (count($newAchievements) > 0) {
                    $newAchievementsQuery->update(['alerted' => true]);
                    $view->with('newAchievements', $newAchievements);
                }
            }
        });

        self::bootProTubeHttpMacro();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Register the ProTube HTTP macro.
     *
     * @return void
     */
    private function bootProTubeHttpMacro(): void
    {
        Http::macro('protube', function () {
            // Ignore ssl errors during development
            return Http::withToken(config('protube.secret'))
                ->withOptions(['verify' => (config('app.env') === 'production')])
                ->baseUrl(config('protube.server'));
        });
    }
}
