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
        abort_if(! $helpingCommittee->activity, 403, $helpingCommittee->activity->event->title.' does not have a signup.');
        abort_if($helpingCommittee->activity->closed, 403, 'This activity is closed, you cannot change participation anymore.');

        $user = Auth::user();
        if ($request->has('user_id')) {
            $user = User::query()->findOrFail($request->input('user_id'));
            abort_unless($user->id == Auth::id() || Auth::user()->can('board'), 403, 'You are not allowed to add this helper to this event.');
        }

        abort_unless($helpingCommittee->committee->isMember($user), 403, $user->name.' is not a member of the '.$helpingCommittee->committee->name.' and thus cannot help on behalf of it.');
        abort_if($helpingCommittee->users->contains('id', $user->id), 403, $user->name.' is already helping for the '.$helpingCommittee->committee->name);
        abort_if($helpingCommittee->users->count() >= $helpingCommittee->amount, 403, 'There are already enough people of your committee helping, thanks though!');

        $helpingCommittee->users()->attach($user->id);
        Session::flash('flash_message', 'Added '.$user->name.' as helper for '.$helpingCommittee->activity->event->title.'.');

        return back();
    }

    public function destroy(HelpingCommittee $helpingCommittee, User $user): RedirectResponse
    {
        abort_unless($user->id == Auth::id() || Auth::user()->can('board'), 403, 'You are not allowed to unsubscribe this user from this event.');
        $helpingCommittee->users()->detach($user->id);
        Session::flash('flash_message', 'Removed '.$user->name.' as helper for the '.$helpingCommittee->committee->name.'.');

        return back();
    }
}
