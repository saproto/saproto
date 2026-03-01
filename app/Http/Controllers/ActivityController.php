<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityParticipation;
use App\Models\Event;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\Factory;

class ActivityController extends Controller
{
    /**
     * @return RedirectResponse
     */
    public function store(Request $request, Event $event)
    {
        $new = $event->activity === null;
        $activity = ($new ? new Activity : $event->activity);

        $newPrice = floatval(str_replace(',', '.', $request->price));
        $newNoShow = floatval(str_replace(',', '.', $request->no_show_fee));

        $newRegistrationStart = $request->date('registration_start')->timestamp;
        $newRegistrationEnd = $request->date('registration_end')->timestamp;

        if ($newRegistrationEnd < $newRegistrationStart) {
            Session::flash('flash_message', 'You cannot let the event sign-up end before the sign-up starts.');

            return to_route('event::edit', ['event' => $event]);
        }

        if ($newRegistrationEnd >= $event->start) {
            Session::flash('flash_message', 'You cannot let the event sign-up end after the event starts.');

            return to_route('event::edit', ['event' => $event]);
        }

        if ($newNoShow > $activity->no_show_fee && $activity->users->count() > 0) {
            Session::flash('flash_message', 'You cannot make the no show fee higher since this activity already has participants.');

            return to_route('event::edit', ['event' => $event]);
        }

        if ($newNoShow < 0) {
            Session::flash('flash_message', 'The no show fee should be a positive amount.');

            return to_route('event::edit', ['event' => $event]);
        }

        if ($newPrice > floatval($activity->price) && $activity->users->count() > 0) {
            Session::flash('flash_message', 'You cannot make the price of this activity higher since this activity already has participants.');

            return to_route('event::edit', ['event' => $event]);
        }

        $data = [
            'registration_start' => $newRegistrationStart,
            'registration_end' => $newRegistrationEnd,
            'deregistration_end' => $request->date('deregistration_end')->timestamp,
            'participants' => $request->participants,
            'price' => $newPrice,
            'no_show_fee' => $newNoShow,
            'hide_participants' => $request->has('hide_participants'),
            'redirect_url' => $request->redirect_url,
        ];

        if (! $activity->validate($data)) {
            return to_route('event::edit', ['event' => $event])->withErrors($activity->errors());
        }

        $activity->fill($data);

        $activity->save();

        if ($new) {
            $activity->event()->associate($event);
            $activity->save();
        }

        ParticipationController::processBackupQueue($activity);

        Session::flash('flash_message', 'Your changes have been saved.');

        return to_route('event::edit', ['event' => $event]);
    }

    /**
     * @return RedirectResponse
     */
    public function destroy(Request $request, Event $event)
    {
        if (! $event->activity) {
            Session::flash('flash_message', 'There is no participation data to delete.');

            return back();
        }

        if (count($event->activity->users) > 0) {
            Session::flash('flash_message', 'You cannot delete participation data because there are still participants to this activity.');

            return back();
        }

        ActivityParticipation::query()->where('activity_id', $event->activity->id)->delete();

        $event->activity->delete();

        Session::flash('flash_message', 'Participation data deleted.');

        return to_route('event::edit', ['event' => $event]);
    }

    public function checklist(Event $event): View|Factory
    {
        abort_if(! Auth::check() || ! Auth::user()->can('board') && ! $event->isEventAdmin(Auth::user()), 403, 'You may not see this page.');

        abort_if($event->activity === null, 404, 'This event has no activity.');

        return view('event.checklist', ['event' => $event]);
    }
}
