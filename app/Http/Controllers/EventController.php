<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Models\Account;
use App\Models\Activity;
use App\Models\Committee;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\HelpingCommittee;
use App\Models\PhotoAlbum;
use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Mollie\Api\Exceptions\ApiException;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $category = EventCategory::query()->find($request->input('category'));

        // if there is a category, get only the events that are in that category
        $events = Event::query()
            ->orderBy('start')
            ->when($category, static function ($query) use ($category) {
                $query->whereHas('Category', static function (Builder $q) use ($category) {
                    $q->where('id', $category->id)->where('deleted_at', null);
                });
            })
            ->where('start', '>', Date::now()->timestamp)
            ->get();

        $data = [[], [], []];

        $data[0] = $events->where('start', '>', Date::now()->timestamp)
            ->where('start', '<=', Date::now()->addWeek()->timestamp);

        $data[1] = $events
            ->where('start', '>', Date::now()->addWeek()->timestamp)
            ->where('start', '<=', Date::now()->addMonth()->timestamp);

        $data[2] = $events->where('start', '>', Date::now()->addMonth()->timestamp);

        $years = $this->getAvailableYears();

        $reminder = Auth::user()?->getCalendarAlarm();

        $calendar_url = route('ical::calendar', ['personal_key' => (Auth::check() ? Auth::user()->getPersonalKey() : null)]);

        return view('event.calendar', [
            'events' => $data,
            'years' => $years,
            'ical_url' => $calendar_url,
            'reminder' => $reminder,
            'cur_category' => $category,
        ]);
    }

    public function finindex(): \Illuminate\Contracts\View\View|Factory
    {
        $activities = Activity::query()
            ->with('event')
            ->withCount('users')
            ->where('closed', false)
            ->orderBy('registration_end')
            ->get();

        return view('event.notclosed', ['activities' => $activities]);
    }

    /**
     * @throws ApiException
     */
    public function show(Event $event): View
    {
        $methods = [];
        if (Config::boolean('omnomcom.mollie.use_fees')) {
            $methods = MollieController::getPaymentMethods();
        }

        return view('event.display', ['event' => $event, 'payment_methods' => $methods]);
    }

    public function create(): \Illuminate\Contracts\View\View|Factory
    {
        return view('event.edit', ['event' => null]);
    }

    /**
     * @return RedirectResponse
     */
    public function store(StoreEventRequest $request)
    {
        $event = Event::query()->create([
            'title' => $request->title,
            'start' => $request->date('start')->timestamp,
            'end' => $request->date('end')->timestamp,
            'location' => $request->location,
            'maps_location' => $request->maps_location,
            'secret' => $request->publication ? false : $request->secret,
            'description' => $request->description,
            'summary' => $request->summary,
            'is_featured' => $request->has('is_featured'),
            'is_external' => $request->has('is_external'),
            'force_calendar_sync' => $request->has('force_calendar_sync'),
            'publication' => $request->publication ? $request->date('publication')->timestamp : null,
        ]);

        $file = $request->file('image');
        if ($file) {
            try {
                $event->addMediaFromRequest('image')
                    ->usingFileName('event_'.$event->id)
                    ->toMediaCollection('header');
            } catch (FileDoesNotExist|FileIsTooBig $e) {
                Session::flash('flash_message', $e->getMessage());

                return back();
            }
        }

        $committee = Committee::query()->find($request->input('committee'));
        $event->committee()->associate($committee);
        $category = EventCategory::query()->find($request->input('category'));
        $event->category()->associate($category);
        $event->save();

        Session::flash('flash_message', "Your event '".$event->title."' has been added.");

        return to_route('event::show', ['event' => $event]);
    }

    public function edit(Event $event): \Illuminate\Contracts\View\View|Factory
    {
        return view('event.edit', ['event' => $event]);
    }

    public function update(StoreEventRequest $request, Event $event): RedirectResponse
    {
        $event->title = $request->title;
        $event->start = $request->date('start')->timestamp;
        $event->end = $request->date('end')->timestamp;
        $event->location = $request->location;
        $event->maps_location = $request->maps_location;
        $event->secret = $request->publication ? false : $request->secret;
        $event->description = $request->description;
        $event->summary = $request->summary;
        $event->involves_food = $request->has('involves_food');
        $event->is_featured = $request->has('is_featured');
        $event->is_external = $request->has('is_external');
        $event->force_calendar_sync = $request->has('force_calendar_sync');
        $event->publication = $request->publication ? $request->date('publication')->timestamp : null;

        if ($event->end < $event->start) {
            Session::flash('flash_message', 'You cannot let the event end before it starts.');

            return back();
        }

        $file = $request->file('image');
        if ($file) {
            try {
                $event->addMediaFromRequest('image')
                    ->usingFileName('event_'.$event->id)
                    ->toMediaCollection('header');
            } catch (FileDoesNotExist|FileIsTooBig $e) {
                Session::flash('flash_message', $e->getMessage());

                return back();
            }
        }

        if ($request->has('committee')) {
            $committee = Committee::query()->find($request->input('committee'));
            $event->committee()->associate($committee);
        }

        if ($request->has('category')) {
            $category = EventCategory::query()->find($request->input('category'));
            $event->category()->associate($category);
        }

        $event->save();

        $changed_important_details = $event->start !== $request->date('start')->timestamp || $event->end !== $request->date('end')->timestamp || $event->location != $request->location;

        if ($changed_important_details) {
            Session::flash('flash_message', "Your event '".$event->title."' has been saved. <br><b class='text-warning'>You updated some important information. Don't forget to update your participants with this info!</b>");
        } else {
            Session::flash('flash_message', "Your event '".$event->title."' has been saved.");
        }

        return back();
    }

    public function archive(Request $request, int $year): \Illuminate\Contracts\View\View|Factory
    {
        /** @var EventCategory|null $category */
        $category = EventCategory::query()->find($request->input('category'));

        // if there is a category, get only the events that are in that category
        $eventsPerMonth = Event::query()
            ->orderBy('start')
            ->unless(empty($category), static function ($query) use ($category) {
                $query->whereHas('Category', static function (Builder $q) use ($category) {
                    $q->where('id', $category->id)->where('deleted_at', null);
                });
            })->where('start', '>', Date::create($year, 1, 1, 0, 0, 1)->timestamp)
            ->where('start', '<', Date::create($year, 12, 31, 23, 59, 59)->timestamp)
            ->get()
            ->groupBy(fn (Event $event) => Date::createFromTimestamp($event->start, date_default_timezone_get())->month);

        $years = $this->getAvailableYears();

        return view('event.archive', [
            'years' => $years,
            'year' => $year,
            'eventsPerMonth' => $eventsPerMonth,
            'cur_category' => $category,
        ]);
    }

    /**
     * @return Collection<int, string>
     */
    private function getAvailableYears(): Collection
    {
        return Cache::remember('event::availableyears', Date::now()->diff(Date::now()->endOfDay()), static fn () => collect(DB::select('SELECT DISTINCT Year(FROM_UNIXTIME(start)) AS start FROM events WHERE deleted_at IS NULL ORDER BY Year(FROM_UNIXTIME(start))'))->pluck('start'));
    }

    /**
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function destroy(Event $event)
    {
        if ($event->activity !== null) {
            Session::flash('flash_message', "You cannot delete event '".$event->title."' since it has a participation details.");

            return back();
        }

        Session::flash('flash_message', "The event '".$event->title."' has been deleted.");

        foreach ($event->getMedia('header') as $media) {
            $media->delete();
        }

        $event->delete();

        return to_route('event::index');
    }

    /**
     * @return RedirectResponse
     */
    public function forceLogin(Event $event)
    {
        return to_route('event::show', ['event' => $event]);
    }

    public function admin(Event $event): RedirectResponse|Factory|\Illuminate\Contracts\View\View
    {
        $event->load(['tickets.purchases.user', 'tickets.purchases.orderline.molliePayment', 'tickets.product']);

        if (! $event->isEventAdmin(Auth::user())) {
            Session::flash('flash_message', 'You are not an event admin for this event!');

            return back();
        }

        return view('event.admin', ['event' => $event]);
    }

    public function scan(Event $event): RedirectResponse|Factory|\Illuminate\Contracts\View\View
    {

        if (! $event->isEventAdmin(Auth::user())) {
            Session::flash('flash_message', 'You are not an event admin for this event!');

            return back();
        }

        return view('event.scan', ['event' => $event]);
    }

    public function finclose(Request $request, int $id): RedirectResponse
    {
        /** @var Activity $activity */
        $activity = Activity::query()->findOrFail($id);

        if ($activity->event && ! $activity->event->over()) {
            Session::flash('flash_message', 'You cannot close an activity before it has finished.');

            return back();
        }

        if ($activity->closed) {
            Session::flash('flash_message', 'This activity is already closed.');

            return back();
        }

        $activity->attendees = $request->input('attendees');

        $account = Account::query()->findOrFail($request->input('account'));

        if (count($activity->users) === 0 || $activity->price == 0) {
            $activity->closed = true;
            $activity->closed_account = $account->id;
            $activity->save();

            Session::flash('flash_message', 'This activity is now closed. It either was free or had no participants, so no orderlines or products were created.');

            return back();
        }

        $product = Product::query()->create([
            'account_id' => $account->id,
            'name' => 'Activity: '.($activity->event ? $activity->event->title : $activity->comment),
            'price' => $activity->price,
        ]);
        $product->save();

        foreach ($activity->users as $user) {
            $product->buyForUser($user, 1, null, null, null, null, sprintf('activity_closed_by_%u', Auth::user()->id));
        }

        $activity->closed = true;
        $activity->closed_account = $account->id;
        $activity->save();

        Session::flash('flash_message', 'This activity has been closed and the relevant orderlines were added.');

        return back();
    }

    public function linkAlbum(Request $request, Event $event): RedirectResponse
    {
        /** @var PhotoAlbum $album */
        $album = PhotoAlbum::query()->findOrFail($request->album_id);

        $album->event()->associate($event);
        $album->save();

        Session::flash('flash_message', 'The album '.$album->name.' has been linked to this activity!');

        return back();
    }

    public function unlinkAlbum(int $album): RedirectResponse
    {
        /** @var PhotoAlbum $album */
        $album = PhotoAlbum::query()->findOrFail($album);
        $album->event()->dissociate();
        $album->save();

        Session::flash('flash_message', 'The album '.$album->name.' has been unlinked from an activity!');

        return back();
    }

    /**
     * @return array<int, object>
     */
    public function apiUpcomingEvents(int $limit, Request $request): array
    {
        $user = Auth::user() ?? null;
        $noFutureLimit = $request->boolean('no_future_limit');
        /** @var Collection<int, Event> $events */
        $events = Event::query()
            ->orderBy('start')
            ->where('end', '>', Date::today()->timestamp)
            ->unless($noFutureLimit, static function ($query) {
                $query->where('start', '<', Date::now()->addMonth()->timestamp);
            })
            ->whereNull('publication')
            ->orderBy('start')
            ->with('activity.users.media')
            ->with('activity.backupUsers')
            ->with('committee.users')
            ->with('tickets')
            ->take($limit)
            ->get();

        $data = [];

        foreach ($events as $event) {
            if ($event->secret && ($user == null || $event->activity == null || (
                ! $event->activity->isParticipating($user) &&
                ! $event->activity->isHelping($user) &&
                ! $event->isOrganising($user)
            ))) {
                continue;
            }

            $userParticipation = $event->activity?->getParticipation($user);

            $participants = ($user?->is_member && $event->activity ? $event->activity->users->map(static fn ($item) => (object) [
                'name' => $item->name,
                'photo' => $item->getFirstMediaUrl('profile_picture', 'thumb'),
            ]) : null);
            $backupParticipants = ($user?->is_member && $event->activity ? $event->activity->backupUsers->map(static fn ($item) => (object) [
                'name' => $item->name,
                'photo' => $item->getFirstMediaUrl('profile_picture', 'thumb'),
            ]) : null);
            $data[] = (object) [
                'id' => $event->id,
                'title' => $event->title,
                'image' => ($event->getFirstMediaUrl('header', 'card')),
                'description' => $event->description,
                'start' => $event->start,
                'organizing_committee' => ($event->committee ? [
                    'id' => $event->committee->id,
                    'name' => $event->committee->name,
                ] : null),
                'registration_start' => $event->activity?->registration_start,
                'registration_end' => $event->activity?->registration_end,
                'deregistration_end' => $event->activity?->deregistration_end,
                'total_places' => $event->activity?->participants,
                'available_places' => $event->activity?->freeSpots(),
                'is_full' => $event->activity?->isFull(),
                'end' => $event->end,
                'location' => $event->location,
                'current' => $event->current(),
                'over' => $event->over(),
                'has_signup' => $event->activity !== null,
                'price' => $event->activity?->price,
                'no_show_fee' => $event->activity?->no_show_fee,
                'user_signedup' => $user && $userParticipation !== null,
                'user_signedup_backup' => $user && $userParticipation?->backup,
                'user_signedup_id' => $userParticipation?->id,
                'can_signup' => ($user && $event->activity?->canSubscribe()),
                'can_signup_backup' => ($user && $event->activity?->canSubscribeBackup()),
                'can_signout' => ($user && $event->activity?->canUnsubscribe()),
                'tickets' => ($user && $event->tickets->count() > 0 ? $event->tickets->pluck('purchases')->flatten()->filter(fn ($purchase): bool => $purchase->user_id === Auth::id())->pluck('api_attributes') : null),
                'participants' => $participants,
                'is_helping' => ($user && $event->activity ? $event->activity->isHelping($user) : null),
                'is_organizing' => ($user && $event->committee ? $event->committee->isMember($user) : null),
                'backupParticipants' => $backupParticipants,
            ];
        }

        return $data;
    }

    public function setReminder(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $hours = floatval($request->input('hours'));

        if ($request->has('delete') || $hours <= 0) {
            $user->setCalendarAlarm(null);
            Session::flash('flash_message', 'Reminder removed.');
        } else {
            $user->setCalendarAlarm($hours);
            Session::flash('flash_message', sprintf('Reminder set to %s hours.', $hours));
        }

        return back();
    }

    public function toggleRelevantOnly(): RedirectResponse
    {
        $user = Auth::user();
        $user->toggleCalendarRelevantSetting();
        if ($user->pref_calendar_relevant_only) {
            Session::flash('flash_message', 'From now on your calendar will only sync events relevant to you.');
        } else {
            Session::flash('flash_message', 'From now on your calendar will sync all events.');
        }

        return back();
    }

    public function icalCalendar(?string $personal_key = null): \Illuminate\Http\Response
    {
        $user = User::query()->where('personal_key', $personal_key)->whereNotNull('personal_key')->first();

        $calendar_name = $user ? sprintf('S.A. Proto Calendar for %s', $user->calling_name) : 'S.A. Proto Calendar';

        $calendar = 'BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//HYTTIOAOAc//S.A. Proto Calendar//EN
CALSCALE:GREGORIAN
'.
            'X-WR-CALNAME:'.$calendar_name."\r\n".
            "X-WR-CALDESC:All of Proto's events, straight from the website!"."\r\n".
            'BEGIN:VTIMEZONE'."\r\n".
            'TZID:'.date_default_timezone_get().''."\r\n".
            'BEGIN:STANDARD'."\r\n".
            'DTSTART:20161002T030000'."\r\n".
            'RRULE:FREQ=YEARLY;BYDAY=-1SU;BYHOUR=3;BYMINUTE=0;BYMONTH=10'."\r\n".
            'TZNAME:Central European Standard Time'."\r\n".
            'TZOFFSETFROM:+0200'."\r\n".
            'TZOFFSETTO:+0100'."\r\n".
            'END:STANDARD'."\r\n".
            'BEGIN:DAYLIGHT'."\r\n".
            'DTSTART:20160301T020000'."\r\n".
            'RRULE:FREQ=YEARLY;BYDAY=-1SU;BYHOUR=2;BYMINUTE=0;BYMONTH=3'."\r\n".
            'TZNAME:Central European Daylight Time'."\r\n".
            'TZOFFSETFROM:+0100'."\r\n".
            'TZOFFSETTO:+0200'."\r\n".
            'END:DAYLIGHT'."\r\n".
            'END:VTIMEZONE'."\r\n";

        $reminder = $user?->pref_calendar_alarm;

        $relevant_only = $user?->pref_calendar_relevant_only;
        $events = Event::query()
            ->orderBy('start')
            ->where('start', '>', Date::now()->subMonths(6)->timestamp)
            ->unless($user, function ($query) {
                $query->where('secret', false);
            })
            ->without('media')
            ->get();

        foreach ($events as $event) {
            /** @var Event $event */
            if (! $event->mayViewEvent($user)) {
                continue;
            }

            if (! $event->force_calendar_sync && $relevant_only && ! ($event->activity?->isParticipating($user) || $event->isOrganising($user) || $event->hasBoughtTickets($user) || $event->activity?->isHelping($user))) {
                continue;
            }

            if ($event->over()) {
                $info_text = 'This activity is over.';
            } elseif ($event->activity !== null && $event->activity->participants == -1) {
                $info_text = 'Sign-up required, but no participant limit.';
            } elseif ($event->activity !== null && $event->activity->participants > 0) {
                $info_text = 'Sign-up required! There are roughly '.$event->activity->freeSpots().' of '.$event->activity->participants.' places left.';
            } elseif ($event->tickets_count > 0) {
                $info_text = 'Ticket purchase required.';
            } else {
                $info_text = 'No sign-up necessary.';
            }

            $status = null;

            if ($user) {
                $userParticipation = $event->activity?->getParticipation($user);
                if ($event->isOrganising($user)) {
                    $status = 'Organizing';
                    $info_text .= ' You are organizing this activity.';
                } elseif ($event->activity) {
                    if ($event->activity->isHelping($user)) {
                        $status = 'Helping';
                        $info_text .= ' You are helping with this activity.';
                    } elseif ($userParticipation?->backup) {
                        $status = 'On back-up list';
                        $info_text .= ' You are on the back-up list for this activity';
                    } elseif ($userParticipation !== null || $event->hasBoughtTickets($user)) {
                        $status = 'Participating';
                        $info_text .= ' You are participating in this activity.';
                    }
                }
            }

            $calendar .= 'BEGIN:VEVENT
'.
                sprintf('UID:%s@proto.utwente.nl', $event->id)."\r\n".
                sprintf('DTSTAMP:%s', gmdate('Ymd\THis\Z', Date::parse($event->created_at)->timestamp))."\r\n".
                sprintf('DTSTART:%s', Date::createFromTimestamp($event->start, date_default_timezone_get())->format('Ymd\THis'))."\r\n".
                sprintf('DTEND:%s', Date::createFromTimestamp($event->end, date_default_timezone_get())->format('Ymd\THis'))."\r\n".
                sprintf('SUMMARY:%s', empty($status) ? $event->title : sprintf('[%s] %s', $status, $event->title))."\r\n".
                sprintf('DESCRIPTION:%s', $info_text.' More information: '.route('event::show', ['event' => $event]))."\r\n".
                sprintf('LOCATION:%s', $event->location)."\r\n".
                sprintf(
                    'ORGANIZER;CN=%s:MAILTO:%s',
                    ($event->committee ? $event->committee->name : 'S.A. Proto'),
                    ($event->committee ? $event->committee->email : 'board@proto.utwente.nl')
                )."\r\n".
                sprintf('LAST_UPDATED:%s', gmdate('Ymd\THis\Z', Date::parse($event->updated_at)->timestamp))."\r\n".
                sprintf('SEQUENCE:%s', $event->update_sequence)."\r\n";

            if ($reminder && $status) {
                $calendar .= 'BEGIN:VALARM
'.
                    sprintf('TRIGGER:-PT%dM', ceil($reminder * 60))."\r\n".
                    'ACTION:DISPLAY'."\r\n".
                    sprintf('DESCRIPTION:%s at %s', sprintf('[%s] %s', $status, $event->title), Date::createFromTimestamp($event->start, date_default_timezone_get())->format('l F j, H:i:s'))."\r\n".
                    'END:VALARM'."\r\n";
            }

            $calendar .= 'END:VEVENT
';
        }

        $calendar .= 'END:VCALENDAR';

        $calendar_wrapped = '';
        foreach (explode("\r\n", $calendar) as $line) {
            if (preg_match('(SUMMARY|DESCRIPTION|LOCATION)', $line) === 1) {
                $search = [';', ','];
                $replace = ['\;', '\,'];
                $line = str_replace($search, $replace, $line);
            }

            $calendar_wrapped .= wordwrap($line, 75, "\r\n ", true)."\r\n";
        }

        return Response::make($calendar_wrapped)
            ->header('Content-Type', 'text/calendar; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="protocalendar.ics"');
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function copyEvent(Request $request): RedirectResponse
    {
        $event = Event::query()->findOrFail($request->input('id'));

        $oldStart = Date::createFromTimestamp($event->start, date_default_timezone_get());

        $newDate = Date::createFromFormat('Y-m-d', $request->input('newDate'))
            ->setHour($oldStart->hour)
            ->setMinute($oldStart->minute)
            ->setSecond($oldStart->second)
            ->timestamp;

        $diff = $newDate - $event->start;

        $newEvent = $event->withoutRelations()->replicate()->fill([
            'title' => $event->title.' [copy]',
            'secret' => $event->publication ? false : $event->secret,
            'start' => $newDate,
            'end' => $event->end + $diff,
            'publication' => $event->publication ? $event->publication + $diff : null,
            'unique_users_count' => 0,
            'update_sequence' => 0,
        ]);
        $newEvent->save();

        $event->getFirstMedia('header')
            ?->copy($newEvent, collectionName: 'header', fileName: 'event_'.$newEvent->id);

        if ($event->activity) {
            $newActivity = $event->activity->replicate([
                'attendees',
                'closed',
                'closed_account',
            ])->fill([
                'event_id' => $newEvent->id,
                'registration_start' => $event->activity->registration_start + $diff,
                'registration_end' => $event->activity->registration_end + $diff,
                'deregistration_end' => $event->activity->deregistration_end + $diff,
            ]);
            $newActivity->save();

            foreach ($event->activity->helpingCommittees as $helpingCommittee) {
                HelpingCommittee::query()->create([
                    'activity_id' => $newActivity->id,
                    'committee_id' => $helpingCommittee->committee_id,
                    'amount' => $helpingCommittee->amount,
                ]);
            }
        }

        Session::flash('flash_message', 'Copied the event!');

        return Redirect::to(route('event::edit', ['event' => $newEvent]));
    }
}
