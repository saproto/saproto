<?php

namespace App\Http\Middleware;

use App\Data\AuthUserData;
use App\Data\MenuItemData;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Override;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    #[Override]
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    #[Override]
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth.user' => fn () => AuthUserData::fromModel($request->user()),
            'flash' => [
                'message'=>$request->session()->get('flash_message')
            ],
            'menuitems'=>fn()=> MenuItemData::collect(MenuItem::query()->whereNull('parent')->orderBy('order')->get()->toArray()),
        ]);
    }
}
