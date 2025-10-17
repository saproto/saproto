<?php

namespace App\Http\Controllers;

use App\Enums\MembershipTypeEnum;
use App\Models\Member;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class RegistrationHelperController extends Controller
{
    /**
     * Display a list of pending members.
     *
     * @return View
     */
    public function index(Request $request): \Illuminate\Contracts\View\View|Factory
    {
        $search = $request->input('query');

        /** @param Builder<Member> $q */
        $users = User::query()->whereHas('member', static function ($q) {
            $q->whereMembershipType(MembershipTypeEnum::PENDING);
        });

        if ($search) {
            $users = $users->where(static function (\Illuminate\Contracts\Database\Query\Builder $q) use ($search) {
                $q->whereLike('name', "%{$search}%")
                    ->orWhereLike('calling_name', "%{$search}%")
                    ->orWhereLike('email', "%{$search}%")
                    ->orWhereLike('utwente_username', "%{$search}%")
                    ->orWhereHas('member', static function (\Illuminate\Contracts\Database\Query\Builder $q) use ($search) {
                        $q->whereLike('proto_username', "%{$search}%");
                    });
            });
        }

        $users = $users->paginate(20);

        return view('users.admin.registration_helper.overview', ['users' => $users, 'query' => $search]);
    }

    /**
     * Show the user details for registration helper.
     *
     * @return View
     */
    public function details(int $id): \Illuminate\Contracts\View\View|Factory
    {
        $user = User::query()->whereHas('member', static function ($q) {
            $q->whereMembershipType(MembershipTypeEnum::PENDING)->orWhere('updated_at', '>', Carbon::now()->subDay());
        })->findOrFail($id);
        /** @var User $user */
        $memberships = $user->getMemberships();

        return view('users.admin.registration_helper.details', ['user' => $user, 'memberships' => $memberships]);
    }
}
