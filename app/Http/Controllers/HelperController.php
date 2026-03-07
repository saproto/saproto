<?php

namespace App\Http\Controllers;

use App\Models\HelpingCommittee;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HelperController extends Controller
{
    public function store(Request $request, HelpingCommittee $helpingCommittee): RedirectResponse
    {
        if (! $helpingCommittee->activity) {
            Session::flash('flash_message', 'This event does not have a signup.');

            return back();
        }

        if ($helpingCommittee->activity->closed) {
            Session::flash('flash_message', 'This activity is closed, you cannot change participation anymore.');

            return back();
        }

        $user = Auth::user();
        if ($request->has('user_id')) {
            $user = User::query()->findOrFail($request->input('user_id'));
            if ($user->id !== Auth::id() && ! Auth::user()->can('board')) {
                Session::flash('flash_message', 'You are not allowed to add this helper to this event.');

                return back();
            }
        }
        if (! $helpingCommittee->committee->isMember($user)) {
            Session::flash('flash_message', $user->name.' is not a member of the '.$helpingCommittee->committee->name.' and thus cannot help on behalf of it.');

            return back();
        }

        if ($helpingCommittee->users->contains('id', $user->id)) {
            Session::flash('flash_message', $user->name.' is already helping for the '.$helpingCommittee->committee->name);

            return back();
        }

        if ($helpingCommittee->users->count() >= $helpingCommittee->amount) {
            Session::flash('flash_message', 'There are already enough people of your committee helping, thanks though!');

            return back();
        }

        $helpingCommittee->users()->attach($user->id);
        $helpingCommittee->activity->event->updateUniqueUsersCount();
        Session::flash('flash_message', 'Added '.$user->name.' as helper for '.$helpingCommittee->activity->event->title.'.');

        return back();
    }

    public function destroy(HelpingCommittee $helpingCommittee, User $user): RedirectResponse
    {
        if ($user->id !== Auth::id() && ! Auth::user()->can('board')) {
            Session::flash('flash_message', 'You are not allowed to unsubscribe this user from this event.');

            return back();
        }

        $helpingCommittee->users()->detach($user->id);
        $helpingCommittee->activity->event->updateUniqueUsersCount();
        Session::flash('flash_message', 'Removed '.$user->name.' as helper for the '.$helpingCommittee->committee->name.'.');

        return back();
    }
}
