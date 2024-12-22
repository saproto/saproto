<?php

namespace App\Http\Middleware;

use App\Data\MenuData;
use App\Data\UserData;
use App\Models\MenuItem;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractCursorPaginator;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Enumerable;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

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
                'user' => fn(): ?UserData => $request->user()
                    ? UserData::from($request->user())
                    : null,
                'user.roles' => $request->user() ? $request->user()->roles->pluck('name') : [],
                'user.permissions' => $request->user() ? $request->user()->getPermissionsViaRoles()->pluck('name') : [],
            ],
            'menuItems' => fn(): DataCollection|PaginatedDataCollection|CursorPaginatedDataCollection|Enumerable|AbstractPaginator|Paginator|AbstractCursorPaginator|CursorPaginator|array => MenuData::collect(MenuItem::query()->where(function ($query) {
                if (Auth::user()?->cannot('member')) {
                    $query->where('is_member_only', false);
                }
            })->where('parent')->orderBy('order')->with('page')->with('children')->get()),
            'csrf' => fn() => csrf_token(),
            'flash' => [
                'message' => $request->session()->get('flash_message'),
                'message_type' => $request->session()->get('flash_message_type'),
            ],

            'impersonating' => fn(): bool => session('impersonator') !== null,
        ];
    }
}
