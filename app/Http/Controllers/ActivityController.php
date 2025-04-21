<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityParticipation;
use App\Models\Committee;
use App\Models\Event;
use App\Models\HelpingCommittee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class ActivityController extends Controller
{
    public function store(Request $request, int $id): RedirectResponse
    {
        /** @var Event $event */
        $event = Event::query()->with('activity')->findOrFail($id);

        $request->validate([
            'registration_start' => 'required|date',
            'registration_end' => 'required|date|after:registration_start',
            'deregistration_end' => 'required|date|after:registration_end',
            'participants' => 'required|integer',
            'price' => 'required|numeric',
            'no_show_fee' => 'required|numeric|min:0',
            'hide_participants' => 'required|boolean',
            'redirect_url' => 'nullable|url',
        ]);

        $newPrice = floatval(str_replace(',', '.', $request->get('price')));
        $newNoShow = floatval(str_replace(',', '.', $request->get('no_show_fee')));

        $newRegistrationStart = $request->date('registration_start')->getTimestamp();
        $newRegistrationEnd = $request->date('registration_end')->getTimestamp();

        $activity = $event->activity ?? new Activity;

        if ($activity->users->count() > 0) {
            if ($newNoShow > $activity->no_show_fee) {
                Session::flash('flash_message', 'You cannot make the no show fee higher since this activity already has participants.');

                return Redirect::route('event::edit', ['id' => $event->id]);
            }

            if ($newPrice > floatval($activity->price)) {
                Session::flash('flash_message', 'You cannot make the price of this activity higher since this activity already has participants.');

                return Redirect::route('event::edit', ['id' => $event->id]);
            }
        }

        $data = [
            'registration_start' => $newRegistrationStart,
            'registration_end' => $newRegistrationEnd,
            'deregistration_end' => $request->date('deregistration_end')->getTimestamp(),
            'participants' => $request->get('participants'),
            'price' => $newPrice,
            'no_show_fee' => $newNoShow,
            'hide_participants' => $request->has('hide_participants'),
            'redirect_url' => $request->get('redirect_url') ?? null,
        ];

        if (! $activity->validate($data)) {
            return Redirect::route('event::edit', ['id' => $event->id])->withErrors($activity->errors());
        }

        $activity->fill($data);

        $activity->save();

        if (! $event->activity) {
            $activity->event()->associate($event);
            $activity->save();
        }

        ParticipationController::processBackupQueue($activity);

        Session::flash('flash_message', 'Your changes have been saved.');

        return Redirect::route('event::edit', ['id' => $event->id]);
    }

    public function destroy(Request $request, int $id): RedirectResponse
    {
        /** @var Event $event */
        $event = Event::query()->findOrFail($id);
        if (! $event->activity) {
            Session::flash('flash_message', 'There is no participation data to delete.');

            return Redirect::back();
        }

        if (count($event->activity->users) > 0) {
            Session::flash('flash_message', 'You cannot delete participation data because there are still participants to this activity.');

            return Redirect::back();
        }

        ActivityParticipation::withTrashed()->where('activity_id', $event->activity->id)->forceDelete();

        $event->activity->delete();

        Session::flash('flash_message', 'Participation data deleted.');

        return Redirect::route('event::edit', ['id' => $event->id]);
    }

    public function checklist(int $id): View
    {
        /** @var Event $event */
        $event = Event::query()->findOrFail($id);
        if (! Auth::check() || ! Auth::user()->can('board') && ! $event->isEventAdmin(Auth::user())) {
            abort(403, 'You may not see this page.');
        }

        if (! $event->activity) {
            abort(404, 'This event has no activity.');
        }

        return view('event.checklist', ['event' => $event]);
    }

    public function addHelp(Request $request, int $id): RedirectResponse
    {
        /** @var Event $event */
        $event = Event::query()->findOrFail($id);
        if (! $event->activity) {
            Session::flash('flash_message', 'This event has no activity data.');

            return Redirect::back();
        }

        $amount = $request->input('amount');
        if ($amount < 1) {
            Session::flash('flash_message', 'The amount of helpers should be positive.');

            return Redirect::back();
        }

        $committee = Committee::query()->findOrFail($request->input('committee'));

        if (HelpingCommittee::whereActivityId($event->activity->id)->whereCommitteeId($committee->id)->count() > 0) {
            Session::flash('flash_message', 'This committee is already helping at this event.');

            return Redirect::back();
        }

        HelpingCommittee::query()->create([
            'activity_id' => $event->activity->id,
            'committee_id' => $committee->id,
            'amount' => $amount,
            'notification_sent' => false,
        ]);

        Session::flash('flash_message', 'Added '.$committee->name.' as helping committee.');

        return Redirect::back();
    }

    public function updateHelp(Request $request, int $id): RedirectResponse
    {
        $request->validate(['amount' => 'required|integer|min:1']);
        /** @var HelpingCommittee $help */
        $help = HelpingCommittee::query()->findOrFail($id);
        $amount = $request->input('amount');

        $help->amount = ($amount > 0 ? $amount : $help->amount);

        $help->notification_sent = false;
        $help->save();

        Session::flash('flash_message', 'Updated '.$help->committee->name.' as helping committee.');

        return Redirect::back();
    }

    public function deleteHelp(Request $request, int $id): RedirectResponse
    {
        /** @var HelpingCommittee $help */
        $help = HelpingCommittee::query()->findOrFail($id);

        foreach (ActivityParticipation::withTrashed()->where('committees_activities_id', $help->id)->get() as $participation) {
            $participation->delete();
        }

        $help->delete();
        Session::flash('flash_message', 'Removed '.$help->committee->name.' as helping committee.');

        return Redirect::back();
    }
}
