<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\HelpingCommittee;
use Illuminate\Http\Request;

class HelpingCommitteeController extends Controller
{
    public function store(Event $event, Request $request)
    {
        $validated = $request->validate([
            'committee' => 'required|integer',
            'amount' => 'required|integer|min:1',
        ]);


        $committee = HelpingCommittee::query()->findOrFail($validated['committee']);

        HelpingCommittee::query()->create([
            'committee_id' => $committee->id,
            'activity_id' => $event->activity->id,
            'amount' => $validated['amount'],
        ]);
    }
    public function update(Request $request, HelpingCommittee $helpingCommittee)
    {
    }

    public function destroy(HelpingCommittee $helpingCommittee)
    {
    }
}
