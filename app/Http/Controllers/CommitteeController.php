<?php

namespace App\Http\Controllers;

use App\Mail\AnonymousEmail;
use App\Models\Committee;
use App\Models\CommitteeMembership;
use App\Models\StorageEntry;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class CommitteeController extends Controller
{
    /**
     * @return View
     */
    public function index(bool $showSociety = false)
    {
        if (Auth::user()?->can('board')) {
            $data = Committee::query()->where('is_society', $showSociety)->orderby('name')->get();

            return view('committee.list', ['data' => $data, 'society' => $showSociety]);
        }

        $data = Committee::query()->where(function ($q) use ($showSociety) {
            $q->where('is_society', $showSociety)->where(function ($q) {
                $q->where('public', true)->orWhere(function ($q) {
                    $q->whereHas('users', static function ($q) {
                        $q->where('user_id', Auth::user()?->id);
                    });
                });
            });
        })->orderBy('name')->get();

        return view('committee.list', ['data' => $data, 'society' => $showSociety]);
    }

    /**
     * @return View
     */
    public function show(string $id): View
    {
        $committee = Committee::fromPublicId($id);

        if (! $committee->public && ! Auth::user()?->can('board') && ! $committee->isMember(Auth::user())) {
            abort(404);
        }

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

    /** @return View */
    public function create(): View
    {
        return view('committee.edit', ['new' => true]);
    }

    /**
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $committee = new Committee;

        $committee->fill($request->all());
        $committee->save();

        Session::flash('flash_message', 'Your new committee has been added!');

        return Redirect::route('committee::show', ['id' => $committee->getPublicId()]);
    }

    /**
     * @return View
     */
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

            return Redirect::back();
        }

        // Update the committee with the request data
        $committee->fill($request->all());

        // The is_active value is either unset or 'on' so only set it to false if selected.
        $committee->is_active = ! $request->has('is_active');

        $committee->save();

        // Redirect back with a message
        Session::flash('flash_message', 'Changes have been saved.');

        return Redirect::route('committee::edit', ['new' => false, 'id' => $id]);
    }

    /**
     * @throws FileNotFoundException
     */
    public function image(int $id, Request $request): RedirectResponse
    {
        $committee = Committee::query()->find($id);

        $image = $request->file('image');
        if ($image) {
            $file = new StorageEntry;
            $file->createFromFile($image);
            $committee->image()->associate($file);
        } else {
            $committee->image()->dissociate();
        }

        $committee->save();

        return Redirect::route('committee::show', ['id' => $committee->getPublicId()]);
    }

    /* Committee membership tools below. */
    public function addMembership(Request $request): RedirectResponse
    {
        User::query()->findOrFail($request->user_id);
        Committee::query()->findOrFail($request->committee_id);

        $request->validate([
            'start'=>'required|date',
            'end'=>'nullable|date',
            'role'=> 'required|string',
            'edition'=> 'required|string',
            'committee_id'=> 'required|integer',
            'user_id'=> 'required|integer|exists:users,id',
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

        return Redirect::back();
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
            'start'=>'required|date',
            'end'=>'nullable|date',
            'role'=> 'required|string',
            'edition'=> 'required|string',
        ]);

        $membership->role = $validated['role'];
        $membership->edition = $validated['edition'];
        $membership->created_at = $request->date('start');
        $membership->deleted_at = $request->date('end');
        $membership->save();


        return Redirect::route('committee::edit', ['id' => $membership->committee->id]);
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

        return Redirect::route('committee::edit', ['id' => $committee_id]);
    }

    public function endEdition(int $committeeID, string $edition): RedirectResponse
    {
        $memberships = CommitteeMembership::query()->where('edition', $edition)->whereHas('committee', static function ($q) use ($committeeID) {
            $q->where('id', $committeeID);
        })->get();
        foreach ($memberships as $membership) {
            $membership->delete();
        }

        Session::flash('flash_message', 'all members from the edition ended!');

        return Redirect::back();
    }

    public function showAnonMailForm(string $id): View|RedirectResponse
    {
        $committee = Committee::fromPublicId($id);

        if (! $committee->allow_anonymous_email) {
            Session::flash('flash_message', 'This committee does not accept anonymous e-mail at this time.');

            return Redirect::back();
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

            return Redirect::back();
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

        return Redirect::route('committee::show', ['id' => $committee->getPublicId()]);
    }
}
