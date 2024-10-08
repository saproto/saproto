<?php

namespace App\Http\Middleware;

use App\Data\MenuData;
use App\Data\UserData;
use App\Models\MenuItem;
use Auth;
use Illuminate\Http\Request;
use Inertia\Middleware;

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
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => fn() => $request->user()
                    ? UserData::from($request->user())
                    : null,
                'permissions' => fn() => Auth::user()?->getAllPermissions()->pluck('name')->mapWithKeys(function ($permission) {
                    return [$permission => true];
                })
            ],
            'menuItems' => fn() => MenuData::collect(MenuItem::query()->where(function ($query) {
                if (Auth::user()?->cannot('member')) {
                    $query->where('is_member_only', false);
                }
            })->where('parent')->orderBy('order')->with('page')->with('children')->get()),
            'csrf' => fn() => csrf_token(),
            'flash' => [
                'message' => fn() => $request->session()->get('flash_message')
            ],
//            todo: remove this
            'impersonating' => null
        ];
    }
}
