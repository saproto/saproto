<?php

namespace Proto\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mail;
use Proto\Mail\AnonymousEmail;
use Proto\Models\Committee;
use Proto\Models\CommitteeMembership;
use Proto\Models\HelperReminder;
use Proto\Models\StorageEntry;
use Proto\Models\User;
use Redirect;
use Session;

class CommitteeController extends Controller
{
    public function overview($showSociety = false)
    {
        if (Auth::check() && Auth::user()->can('board')) {
            return view('committee.list', ['data' => Committee::where('is_society', $showSociety)->orderby('name', 'asc')->get()]);
        } else {
            $publicGroups = Committee::where('public', 1)->where('is_society', $showSociety)->get();

            if ($showSociety) {
                $userGroups = Auth::check() ? Auth::user()->societies : [];
            } else {
                $userGroups = Auth::check() ? Auth::user()->committees : [];
            }

            $mergedGroups = $publicGroups->merge($userGroups)->sortBy('name');

            return view('committee.list', ['data' => $mergedGroups]);
        }
    }

    public function indexApi(Request $request)
    {
        $showSocieties = filter_var($request->get('show_societies', false), FILTER_VALIDATE_BOOLEAN);

        $data = [];
        foreach (Committee::where('public', 1)->where('is_society', $showSocieties)->orderBy('name', 'asc')->get() as $committee) {
            if (Auth::user() && Auth::user()->is_member) {
                $current_members = [];
                foreach ($committee->users as $user) {
                    $current_members[] = (object) [
                        'name'    => $user->name,
                        'photo'   => $user->photo_preview,
                        'edition' => $user->pivot->edition,
                        'role'    => $user->pivot->role,
                        'since'   => strval($user->pivot->created_at),
                    ];
                }
            } else {
                $current_members = null;
            }

            $data[] = (object) [
                'id'              => $committee->id,
                'name'            => $committee->name,
                'description'     => $committee->description,
                'email'           => sprintf('%s@%s', $committee->slug, config('proto.emaildomain')),
                'photo'           => $committee->image->generateImagePath(null, null),
                'current_members' => $current_members,
            ];
        }

        return $data;
    }

    public function show($id)
    {
        $committee = Committee::fromPublicId($id);

        if (!$committee->public && (!Auth::check() || (!Auth::user()->can('board') && !$committee->isMember(Auth::user())))) {
            abort(404);
        }

        return view('committee.show', ['committee' => $committee, 'members' => $committee->allmembers(),
            'subscribed_to_helper_notification'    => Auth::check() && $committee->wantsToReceiveHelperReminder(Auth::user()),
        ]);
    }

    public function add(Request $request)
    {
        $committee = new Committee();

        $committee->fill($request->all());
        $committee->save();

        Session::flash('flash_message', 'Your new committee has been added!');

        return Redirect::route('committee::show', ['id' => $committee->getPublicId()]);
    }

    public function edit($id, Request $request)
    {
        $committee = Committee::find($id);

        if ($committee->slug == config('proto.rootcommittee') && $request->slug != $committee->slug) {
            Session::flash('flash_message', "This committee is protected. You cannot change it's e-mail alias.");

            return Redirect::back();
        }

        $committee->fill($request->all());

        $committee->save();

        Session::flash('flash_message', 'Changes have been saved.');

        return Redirect::route('committee::edit', ['new' => false, 'id' => $id]);
    }

    public function image($id, Request $request)
    {
        $committee = Committee::find($id);

        $image = $request->file('image');
        if ($image) {
            $file = new StorageEntry();
            $file->createFromFile($image);

            $committee->image()->associate($file);
            $committee->save();
        } else {
            $committee->image()->dissociate();
            $committee->save();
        }

        return Redirect::route('committee::show', ['id' => $committee->getPublicId()]);
    }

    public function addForm()
    {
        return view('committee.edit', ['new' => true]);
    }

    public function editForm($id)
    {
        $committee = Committee::find($id);

        if ($committee == null) {
            abort(404);
        }

        return view('committee.edit', ['new' => false, 'id' => $id, 'committee' => $committee, 'members' => $committee->allmembers()]);
    }

    /**
     * Committee membership tools below.
     */
    public function addMembership(Request $request)
    {
        $user = User::find($request->user_id);
        $committee = Committee::find($request->committee_id);
        if ($user == null) {
            abort(404);
        }
        if ($committee == null) {
            abort(404);
        }

        $membership = new CommitteeMembership();

        $membership->role = $request->role;
        $membership->edition = $request->edition;
        $membership->user_id = $request->user_id;
        $membership->committee_id = $request->committee_id;
        if (($membership->created_at = date('Y-m-d H:i:s', strtotime($request->start))) === false) {
            Session::flash('flash_message', 'Ill-formatted start date.');

            return Redirect::back();
        }
        if ($request->end != '' && ($membership->deleted_at = date('Y-m-d H:i:s', strtotime($request->end))) === false) {
            Session::flash('flash_message', 'Ill-formatted end date.');

            return Redirect::back();
        } elseif ($request->end == '') {
            $membership->deleted_at = null;
        }

        $membership->save();

        Session::flash('flash_message', 'You have added '.$membership->user->name.' to '.$membership->committee->name.'.');

        return Redirect::back();
    }

    public function editMembershipForm($id)
    {
        $membership = CommitteeMembership::withTrashed()->findOrFail($id);

        return view('committee.membership-edit', ['membership' => $membership]);
    }

    public function editMembership($id, Request $request)
    {
        $membership = CommitteeMembership::withTrashed()->findOrFail($id);

        $membership->role = $request->role;
        $membership->edition = $request->edition;
        if (($membership->created_at = date('Y-m-d H:i:s', strtotime($request->start))) === false) {
            Session::flash('flash_message', 'Ill-formatted start date.');

            return Redirect::back();
        }
        if ($request->end != '' && ($membership->deleted_at = date('Y-m-d H:i:s', strtotime($request->end))) === false) {
            Session::flash('flash_message', 'Ill-formatted end date.');

            return Redirect::back();
        } elseif ($request->end == '') {
            $membership->deleted_at = null;
        }

        $membership->save();

        return Redirect::route('committee::edit', ['id' => $membership->committee->id]);
    }

    public function deleteMembership($id)
    {
        $membership = CommitteeMembership::withTrashed()->findOrFail($id);

        Session::flash('flash_message', 'You have removed '.$membership->user->name.' from '.$membership->committee->name.'.');

        $committee_id = $membership->committee->id;

        $membership->forceDelete();
        HelperReminder::where('committee_id', $committee_id)->where('user_id', $membership->user->id)->delete();

        return Redirect::route('committee::edit', ['id' => $committee_id]);
    }

    public function showAnonMailForm($id)
    {
        $committee = Committee::fromPublicId($id);

        if (!$committee->allow_anonymous_email) {
            Session::flash('flash_message', 'This committee does not accept anonymous e-mail at this time.');

            return Redirect::back();
        }

        return view('committee.anonmail', ['committee' => $committee]);
    }

    public function postAnonMailForm(Request $request, $id)
    {
        $committee = Committee::fromPublicId($id);

        if (!$committee->allow_anonymous_email) {
            Session::flash('flash_message', 'This committee does not accept anonymous e-mail at this time.');

            return Redirect::back();
        }

        $email = $committee->getEmailAddress();
        $name = $committee->name;

        $message_content = strip_tags($request->get('message'));
        $message_hash = md5($message_content);

        Log::info('Anonymous e-mail with hash '.$message_hash.' sent to '.$name.' by user #'.Auth::user()->id);

        Mail::to((object) [
            'name'  => $committee->name,
            'email' => $committee->getEmailAddress(),
        ])->queue((new AnonymousEmail($committee, $message_content, $message_hash))->onQueue('low'));

        Session::flash('flash_message', sprintf(
            'Thanks for submitting your anonymous e-mail! The e-mail will be sent to the %s straightaway. Please remember that they cannot reply to your e-mail, so you will not receive any further confirmation other than this notification.',
            $committee->name
        ));

        return Redirect::route('committee::show', ['id' => $committee->getPublicId()]);
    }

    public function toggleHelperReminder($slug)
    {
        $committee = Committee::fromPublicId($slug);
        $user = Auth::user();

        if (!$committee->isMember($user)) {
            Session::flash('flash_message', 'You cannot subscribe for helper notifications for a committee you are not in.');

            return Redirect::route('committee::show', ['id' => $committee->getPublicId()]);
        }

        if ($committee->wantsToReceiveHelperReminder($user)) {
            HelperReminder::where('user_id', $user->id)->where('committee_id', $committee->id)->delete();
            Session::flash('flash_message', sprintf('You will no longer receive helper notifications for the %s.', $committee->name));
        } else {
            HelperReminder::create(['user_id' => $user->id, 'committee_id' => $committee->id]);
            Session::flash('flash_message', sprintf('You will now receive helper notifications for the %s.', $committee->name));
        }

        return Redirect::route('committee::show', ['id' => $committee->getPublicId()]);
    }
}
