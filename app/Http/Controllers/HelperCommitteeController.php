<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\Event;
use App\Models\HelpingCommittee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HelperCommitteeController extends Controller
{
    public function store(Request $request, Event $event): RedirectResponse
    {
        if (! $event->activity) {
            Session::flash('flash_message', 'This event has no activity data.');

            return back();
        }

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0', 'max:180'],
            'committee' => ['required', 'integer', 'exists:committees,id'],
        ]);

        $committee = Committee::query()->findOrFail($validated['committee']);

        $amount = $validated['amount'];
        if ($amount < 1) {
            Session::flash('flash_message', 'The amount of helpers should be positive.');

            return back();
        }

        if (HelpingCommittee::whereActivityId($event->activity->id)->whereCommitteeId($committee->id)->count() > 0) {
            Session::flash('flash_message', 'This committee is already helping at this event.');

            return back();
        }

        HelpingCommittee::query()->create([
            'activity_id' => $event->activity->id,
            'committee_id' => $committee->id,
            'amount' => $amount,
        ]);

        Session::flash('flash_message', 'Added '.$committee->name.' as helping committee.');

        return back();
    }

    public function update(Request $request, HelpingCommittee $helpingCommittee): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0', 'max:180'],
        ]);

        $helpingCommittee->update(
            ['amount' => $validated['amount']],
        );

        Session::flash('flash_message', 'Updated '.$helpingCommittee->committee->name.' to '.$validated['amount'].' helpers.');

        return back();
    }

    public function destroy(HelpingCommittee $helpingCommittee): RedirectResponse
    {
        $committee = $helpingCommittee->committee->name;
        $helpingCommittee->users()->detach();
        $helpingCommittee->delete();
        Session::flash('flash_message', 'Removed '.$committee.' as helping committee.');

        return back();
    }
}
