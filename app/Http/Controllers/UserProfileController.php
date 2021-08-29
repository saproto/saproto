<?php

namespace Proto\Http\Controllers;

use Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Proto\Models\CommitteeMembership;
use Proto\Models\User;

class UserProfileController extends Controller
{
    /**
     * @param int|null $id
     * @return View
     */
    public function show($id = null)
    {
        if ($id == null) {
            $user = Auth::user();
        } else {
            $user = User::fromPublicId($id);
        }

        if ($user == null) {
            abort(404);
        }

        $pastCommittees = $this->getPastMemberships($user, false);
        $pastSocieties = $this->getPastMemberships($user, true);

        return view('users.profile.profile', ['user' => $user, 'pastcommittees' => $pastCommittees, 'pastsocieties' => $pastSocieties]);
    }

    /**
     * @param User $user
     * @param bool $with_societies
     * @return Collection|CommitteeMembership[]
     */
    private function getPastMemberships($user, $with_societies)
    {
        return CommitteeMembership::onlyTrashed()
            ->with('committee')
            ->where('user_id', $user->id)
            ->get()
            ->where('committee.is_society', $with_societies);
    }
}
