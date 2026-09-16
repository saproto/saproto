<?php

namespace App\Http\Controllers;

use App\Models\Tempadmin;
use App\Models\User;
use App\Services\ProTubeApiService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class TempAdminController extends Controller
{
    public function index(): View|Factory
    {
        $tempadmins = Tempadmin::query()
            ->with('user')
            ->with('creator')
            ->where('end_at', '>', Date::now())
            ->orderByDesc('end_at')
            ->get();

        $pastTempadmins = Tempadmin::query()->where('end_at', '<=', Date::now())->orderByDesc('end_at')->take(10)->get();

        return view('tempadmin.list', ['tempadmins' => $tempadmins, 'pastTempadmins' => $pastTempadmins]);
    }

    public function create(): View|Factory
    {
        return view('tempadmin.edit', ['tempadmin' => null, 'new' => true]);
    }

    /**
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $tempAdminUser = User::query()->findOrFail($request->user_id);

        $tempadmin = new Tempadmin;
        $tempadmin->user()->associate($tempAdminUser);
        $tempadmin->creator()->associate(Auth::user());
        $tempadmin->start_at = $request->date('start_at')->toDateTimeString();
        $tempadmin->end_at = $request->date('end_at')->toDateTimeString();
        $tempadmin->save();

        ProTubeApiService::updateAdmin($tempAdminUser->id, $tempAdminUser->isTempadminLaterToday());

        return to_route('tempadmins.index');
    }

    public function edit(Tempadmin $tempadmin): View|Factory
    {
        return view('tempadmin.edit', ['item' => $tempadmin, 'new' => false]);
    }

    /**
     * @return RedirectResponse
     */
    public function update(Tempadmin $tempadmin, Request $request)
    {
        $tempadmin->start_at = $request->date('start_at')->toDateTimeString();
        $tempadmin->end_at = $request->date('end_at')->toDateTimeString();
        $tempadmin->save();

        ProTubeApiService::updateAdmin($tempadmin->user->id, $tempadmin->user->isTempadminLaterToday());

        return to_route('tempadmins.index');
    }

    public function make(User $user): RedirectResponse
    {
        $tempAdmin = new Tempadmin;
        $tempAdmin->created_by = Auth::user()->id;
        $tempAdmin->start_at = Date::today();
        $tempAdmin->end_at = Date::tomorrow();
        $tempAdmin->user()->associate($user);
        $tempAdmin->save();

        ProTubeApiService::updateAdmin($user->id, $user->isTempadminLaterToday());

        return back();
    }

    public function end(User $user): RedirectResponse
    {
        foreach ($user->tempadmin as $tempadmin) {
            if (Date::now()->between(Date::parse($tempadmin->start_at), Date::parse($tempadmin->end_at))) {
                $tempadmin->end_at = Date::now()->subSecond();
                $tempadmin->save();
            } elseif (Date::parse($tempadmin->start_at)->isFuture()) {
                $tempadmin->delete();
            }
        }

        ProTubeApiService::updateAdmin($user->id, $user->isTempadminLaterToday());

        return back();
    }
}
