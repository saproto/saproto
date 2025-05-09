<?php

namespace App\Http\Controllers;

use App\Models\ActivityParticipation;
use App\Models\Event;
use App\Models\HelperParticipation;
use App\Models\HelpingCommittee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class HelperParticipationController extends Controller
{

    public function store(Event $event, Request $request)
    {
        $request->validate([
            'helping_committee_id' => 'required|exists:helping_committees_activities,id',
        ]);

        abort_if(! $event->activity, 403, $event->title.' does not have a signup.');
        abort_if($event->activity->closed, 403, 'This activity is closed, you cannot change participation anymore.');

        $helpingCommittee = HelpingCommittee::query()->findOrFail($request->input('helping_committee_id'));
        abort_unless($helpingCommittee->users->has(Auth::user()), 403, 'You are already helping at '.$event->title.'.');

        abort_unless($helpingCommittee->committee->isMember(Auth::user()), 403, 'You are not a member of the '.$helpingCommittee->committee.' and thus cannot help on behalf of it.');
        abort_if($helpingCommittee->users->count() >= $helpingCommittee->amount, 403, 'There are already enough people of your committee helping, thanks though!');

        ActivityParticipation::query()->create([
            'activity_id' => $event->activity->id,
            'user_id' => Auth::user()->id,
            'committees_activities_id' => $helpingCommittee->id,
        ]);

        return Redirect::back();
    }

    public function destroy(HelperParticipation $helperParticipation)
    {
        abort_unless($helperParticipation->user->id == Auth::id() || Auth::user()->can('board'), 403, 'You are not allowed to unsubscribe this user from this event.');

        $helperParticipation->delete();
            Session::flash('flash_message', $helperParticipation->user->name.' is not helping with '.$helperParticipation->helpingCommittee->activity->event->title.' anymore.');
        $helperParticipation->helpingCommittee->activity->event->updateUniqueUsersCount();
            return Redirect::back();
    }
}
