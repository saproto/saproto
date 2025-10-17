<?php

namespace App\Http\Controllers;

use App\Models\ActivityParticipation;
use App\Models\CommitteeMembership;
use App\Models\OrderLine;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    /**
     * @return View
     */
    public function show(?string $id = null): \Illuminate\Contracts\View\View|Factory
    {
        $user = $id == null ? Auth::user() : User::fromPublicId($id);

        abort_if($user == null, 404);

        $pastCommittees = $this->getPastMemberships($user, false);
        $pastSocieties = $this->getPastMemberships($user, true);
        $moneySpent = $this->getSpentMoney($user);
        $totalProducts = $this->getProductsPurchased($user);
        $totalSignups = $this->getTotalSignups($user);
        $achievements = $user->achievements;
        $user->load('committees');

        return view('users.profile.profile', ['user' => $user, 'pastcommittees' => $pastCommittees, 'pastsocieties' => $pastSocieties, 'spentmoney' => $moneySpent, 'signups' => $totalSignups, 'totalproducts' => $totalProducts, 'achievements' => $achievements]);
    }

    /**
     * @return Collection|CommitteeMembership[]
     */
    private function getPastMemberships(User $user, bool $with_societies)
    {
        return CommitteeMembership::onlyTrashed()
            ->with('committee')
            ->where('user_id', $user->id)
            ->get()
            ->where('committee.is_society', $with_societies);
    }

    private function getSpentMoney(User $user): float
    {
        return OrderLine::query()->where('user_id', $user->id)->pluck('total_price')->sum();
    }

    private function getProductsPurchased(User $user): int
    {
        return OrderLine::query()->where('user_id', $user->id)->pluck('units')->sum();
    }

    private function getTotalSignups(User $user): int
    {
        return ActivityParticipation::query()->where('user_id', $user->id)->whereNull('committees_activities_id')->count();
    }
}
