<?php

namespace App\Providers;

use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Laravel\Passport\Passport;
use Override;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Passport::$clientUuids = false;

        Password::defaults(function () {
            $rule = Password::min(10)->max(72)->letters();

            return $this->app->isProduction()
                ? $rule->mixedCase()->numbers()->symbols()->uncompromised()
                : $rule;
        });

        Model::preventLazyLoading(! app()->isProduction());

        view()->composer('*', function ($view) {
            view()->share('viewName', Str::replace('.', '-', (string) $view->getName()));
        });

        view()->composer('website.navbar', static function ($view) {
            $menuItems = Cache::rememberForever('website.navbar', static fn () => MenuItem::query()->whereNull('parent')->orderBy('order')->with('page')->with('children')->get());
            $view->with('menuItems', $menuItems);
        });

        view()->composer('components.modals.achievement-popup', static function ($view) {
            if (Auth::check()) {
                $key = 'achievement-popup::user::'.Auth::id();
                if (! Cache::has($key)) {
                    $newAchievementsQuery = Auth::user()->achievements()->where('alerted', false);
                    $newAchievements = $newAchievementsQuery->get();
                    if (count($newAchievements) > 0) {
                        $newAchievementsQuery->update(['alerted' => true]);
                        $view->with('newAchievements', $newAchievements);
                    }

                    Cache::put($key, true, now()->addHours(6));
                }
            }
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
