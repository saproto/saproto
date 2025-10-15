<?php

namespace App\Http\Controllers;

use App\Models\Tempadmin;
use App\Models\User;
use App\Services\ProTubeApiService;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TempAdminController extends Controller
{
    /**
     * @return View
     */
    public function index(): \Illuminate\Contracts\View\View|Factory
    {
        $tempadmins = Tempadmin::query()
            ->with('user')
            ->with('creator')
            ->where('end_at', '>', DB::raw('NOW()'))
            ->latest('end_at')
            ->get();
        $pastTempadmins = Tempadmin::query()->where('end_at', '<=', DB::raw('NOW()'))->latest('end_at')->take(10)->get();

        return view('tempadmin.list', ['tempadmins' => $tempadmins, 'pastTempadmins' => $pastTempadmins]);
    }

    /** @return View */
    public function create(): \Illuminate\Contracts\View\View|Factory
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

    /**
     * @return View
     */
    public function edit(Tempadmin $tempadmin): \Illuminate\Contracts\View\View|Factory
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

    public function make(int $id): RedirectResponse
    {
        $user = User::query()->findOrFail($id);

        $tempAdmin = new Tempadmin;
        $tempAdmin->created_by = Auth::user()->id;
        $tempAdmin->start_at = Date::today();
        $tempAdmin->end_at = Date::tomorrow();
        $tempAdmin->user()->associate($user);
        $tempAdmin->save();

        ProTubeApiService::updateAdmin($user->id, $user->isTempadminLaterToday());

        return back();
    }

    public function end(int $id): RedirectResponse
    {
        /** @var User $user */
        $user = User::query()->findOrFail($id);

        foreach ($user->tempadmin as $tempadmin) {
            if (Date::now()->between(Date::parse($tempadmin->start_at), Date::parse($tempadmin->end_at))) {
                $tempadmin->end_at = Date::now()->subSeconds(1);
                $tempadmin->save();
            }
        }

        ProTubeApiService::updateAdmin($user->id, $user->isTempadminLaterToday());

        return back();
    }

    /**
     * @throws Exception
     */
    public function endId(int $id): RedirectResponse
    {
        /** @var Tempadmin $tempadmin */
        $tempadmin = Tempadmin::query()->findOrFail($id);

        if (Date::parse($tempadmin->start_at)->isFuture()) {
            $tempadmin->delete();
        } else {
            $tempadmin->end_at = Date::now()->subSeconds(1);
            $tempadmin->save();
        }

        ProTubeApiService::updateAdmin($tempadmin->user->id, $tempadmin->user->isTempadminLaterToday());

        return back();
    }
}
