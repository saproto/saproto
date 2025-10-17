<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Database\Query\Builder;
use App\Mail\AnonymousEmail;
use App\Models\Committee;
use App\Models\CommitteeMembership;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class CommitteeController extends Controller
{
    /**
     * @return View
     */
    public function index(bool $showSociety = false): \Illuminate\Contracts\View\View|Factory
    {
        if (Auth::user()?->can('board')) {
            $data = Committee::query()->where('is_society', $showSociety)->orderby('name')->get();

            return view('committee.list', ['data' => $data, 'society' => $showSociety]);
        }

        $data = Committee::query()->where(function ($q) use ($showSociety) {
            $q->where('is_society', $showSociety)->where(function (Builder $q) {
                $q->where('public', true)->orWhere(function (Builder $q) {
                    $q->whereHas('users', static function (Builder $q) {
                        $q->where('user_id', Auth::user()?->id);
                    });
                });
            });
        })->orderBy('name')->get();

        return view('committee.list', ['data' => $data, 'society' => $showSociety]);
    }

    public function show(string $id): View
    {
        $committee = Committee::fromPublicId($id);

        abort_if(! $committee->public && ! Auth::user()?->can('board') && ! $committee->isMember(Auth::user()), 404);

        $pastEvents = $committee->pastEvents()->take(6)->get();
        $upcomingEvents = $committee->upcomingEvents()->get();
        $pastHelpedEvents = $committee->pastHelpedEvents()->take(6)->get();

        return view('committee.show', [
            'committee' => $committee,
            'members' => $committee->allMembers(),
            'pastEvents' => $pastEvents,
            'upcomingEvents' => $upcomingEvents,
            'pastHelpedEvents' => $pastHelpedEvents,
        ]);
    }

    public function create(): View
    {
        return view('committee.edit', ['new' => true]);
    }

    public function store(Request $request): RedirectResponse
    {
        $committee = new Committee;

        $committee->fill($request->all());
        $committee->save();

        Session::flash('flash_message', 'Your new committee has been added!');

        return to_route('committee::show', ['id' => $committee->getPublicId()]);
    }

    public function edit(int $id): View
    {
        $committee = Committee::query()->findOrFail($id);

        return view('committee.edit', ['new' => false, 'id' => $id, 'committee' => $committee, 'members' => $committee->allMembers()]);
    }

    public function update(int $id, Request $request): RedirectResponse
    {
        // Retrieve the committee
        $committee = Committee::query()->find($id);

        // Check if the committee is protected
        if ($committee->slug === Config::string('proto.rootcommittee') && $request->slug != $committee->slug) {
            Session::flash('flash_message', "This committee is protected. You cannot change it's e-mail alias.");

            return back();
        }

        // Update the committee with the request data
        $committee->fill($request->all());

        // The is_active value is either unset or 'on' so only set it to false if selected.
        $committee->is_active = ! $request->has('is_active');

        $committee->save();

        // Redirect back with a message
        Session::flash('flash_message', 'Changes have been saved.');

        return to_route('committee::edit', ['new' => false, 'id' => $id]);
    }

    public function image(int $id, Request $request): RedirectResponse
    {
        $committee = Committee::query()->findOrFail($id);
        $request->validate([
            'image' => ['nullable', 'image', 'max:5120', 'mimes:jpeg,png,jpg'], // max 5MB
        ]);
        if ($request->has('image')) {
            try {
                $committee->addMediaFromRequest('image')
                    ->usingFileName('committee_'.$committee->id)
                    ->toMediaCollection();
            } catch (FileDoesNotExist|FileIsTooBig $e) {
                Session::flash('flash_message', $e->getMessage());

                return back();
            }
        } else {
            $committee->getFirstMedia()->delete();
        }

        return to_route('committee::show', ['id' => $committee->getPublicId()]);
    }

    /* Committee membership tools below. */
    public function addMembership(Request $request): RedirectResponse
    {
        User::query()->findOrFail($request->user_id);
        Committee::query()->findOrFail($request->committee_id);

        $request->validate([
            'start' => ['required', 'date'],
            'end' => ['nullable', 'date'],
            'role' => ['required', 'string'],
            'edition' => ['nullable', 'string'],
            'committee_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $membership = new CommitteeMembership;
        $membership->role = $request->role;
        $membership->edition = $request->edition;
        $membership->user_id = $request->user_id;
        $membership->committee_id = $request->committee_id;
        $membership->created_at = $request->date('start');
        $membership->deleted_at = $request->date('end');

        $membership->save();

        Session::flash('flash_message', 'You have added '.$membership->user->name.' to '.$membership->committee->name.'.');

        return back();
    }

    public function editMembershipForm(int $id): View
    {
        $membership = CommitteeMembership::withTrashed()->findOrFail($id);

        return view('committee.membership-edit', ['membership' => $membership]);
    }

    public function updateMembershipForm(Request $request, int $id): RedirectResponse
    {
        $membership = CommitteeMembership::withTrashed()->findOrFail($id);

        $validated = $request->validate([
            'start' => ['required', 'date'],
            'end' => ['nullable', 'date'],
            'role' => ['required', 'string'],
            'edition' => ['nullable', 'string'],
        ]);

        $membership->role = $validated['role'];
        $membership->edition = $validated['edition'];
        $membership->created_at = $request->date('start');
        $membership->deleted_at = $request->date('end');
        $membership->save();

        return to_route('committee::edit', ['id' => $membership->committee->id]);
    }

    /**
     * @throws Exception
     */
    public function deleteMembership(int $id): RedirectResponse
    {
        $membership = CommitteeMembership::withTrashed()->findOrFail($id);
        $committee_id = $membership->committee->id;

        Session::flash('flash_message', 'You have removed '.$membership->user->name.' from '.$membership->committee->name.'.');

        $membership->forceDelete();

        return to_route('committee::edit', ['id' => $committee_id]);
    }

    public function endEdition(int $committeeID, string $edition): RedirectResponse
    {
        $memberships = CommitteeMembership::query()->where('edition', $edition)->whereHas('committee', static function (Builder $q) use ($committeeID) {
            $q->where('id', $committeeID);
        })->get();
        foreach ($memberships as $membership) {
            $membership->delete();
        }

        Session::flash('flash_message', 'all members from the edition ended!');

        return back();
    }

    public function showAnonMailForm(string $id): View|RedirectResponse
    {
        $committee = Committee::fromPublicId($id);

        if (! $committee->allow_anonymous_email) {
            Session::flash('flash_message', 'This committee does not accept anonymous e-mail at this time.');

            return back();
        }

        return view('committee.anonmail', ['committee' => $committee]);
    }

    /**
     * @return RedirectResponse
     */
    public function sendAnonMailForm(Request $request, string $id)
    {
        $committee = Committee::fromPublicId($id);

        if (! $committee->allow_anonymous_email) {
            Session::flash('flash_message', 'This committee does not accept anonymous e-mail at this time.');

            return back();
        }

        $name = $committee->name;

        $message_content = strip_tags($request->get('message'));
        $message_hash = md5($message_content);

        Log::info('Anonymous e-mail with hash '.$message_hash.' sent to '.$name.' by user #'.Auth::user()->id);

        Mail::to((object) [
            'name' => $committee->name,
            'email' => $committee->email,
        ])->queue((new AnonymousEmail($committee, $message_content, $message_hash))->onQueue('low'));

        Session::flash('flash_message', sprintf('Thanks for submitting your anonymous e-mail! The e-mail will be sent to the %s straightaway. Please remember that they cannot reply to your e-mail, so you will not receive any further confirmation other than this notification.', $committee->name));

        return to_route('committee::show', ['id' => $committee->getPublicId()]);
    }
}
