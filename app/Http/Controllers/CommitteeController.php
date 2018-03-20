<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Object_;
use Illuminate\Support\Facades\Log;

use Proto\Mail\AnonymousEmail;
use Proto\Models\StorageEntry;
use Proto\Models\Committee;
use Proto\Models\CommitteeMembership;
use Proto\Models\User;

use Auth;
use Session;
use Redirect;
use Mail;


class CommitteeController extends Controller
{

    public function overview()
    {
        if (Auth::check() && Auth::user()->can('board')) {
            return view('committee.list', ['data' => Committee::orderby('name', 'asc')->get()]);
        } else {
            return view('committee.list', ['data' => Committee::where('public', 1)->orderby('name', 'asc')->get()]);
        }
    }

    public function show($id)
    {
        $committee = Committee::fromPublicId($id);

        if (!$committee->public && (!Auth::check() || !Auth::user()->can('board'))) {
            abort(404);
        }

        return view('committee.show', ['committee' => $committee, 'members' => $committee->allmembers()]);
    }

    public function add(Request $request)
    {

        $committee = new Committee();

        $committee->fill($request->all());
        $committee->save();

        Session::flash("flash_message", "Your new committee has been added!");

        return Redirect::route('committee::show', ['id' => $committee->getPublicId()]);

    }

    public function edit($id, Request $request)
    {

        $committee = Committee::find($id);

        if ($committee->slug == config('proto.rootcommittee') && $request->slug != $committee->slug) {

            Session::flash("flash_message", "This committee is protected. You cannot change it's e-mail alias.");

            return Redirect::back();

        }

        $committee->fill($request->all());

        $committee->save();

        Session::flash("flash_message", "Changes have been saved.");

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

        return Redirect::route('committee::show', ['id' => Event::findOrFail($id)->getPublicId()]);

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
     * Committee membership tools below
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
            Session::flash("flash_message", "Ill-formatted start date.");
            return Redirect::back();
        }
        if ($request->end != "" && ($membership->deleted_at = date('Y-m-d H:i:s', strtotime($request->end))) === false) {
            Session::flash("flash_message", "Ill-formatted end date.");
            return Redirect::back();
        } elseif ($request->end == "") {
            $membership->deleted_at = null;
        }

        $membership->save();

        Session::flash("flash_message", "You have added " . $membership->user->name . " to " . $membership->committee->name . ".");

        return Redirect::back();

    }

    public function editMembershipForm($id)
    {

        $membership = CommitteeMembership::withTrashed()->findOrFail($id);

        return view("committee.membership-edit", ["membership" => $membership]);

    }

    public function editMembership($id, Request $request)
    {

        $membership = CommitteeMembership::withTrashed()->findOrFail($id);

        $membership->role = $request->role;
        $membership->edition = $request->edition;
        if (($membership->created_at = date('Y-m-d H:i:s', strtotime($request->start))) === false) {
            Session::flash("flash_message", "Ill-formatted start date.");
            return Redirect::back();
        }
        if ($request->end != "" && ($membership->deleted_at = date('Y-m-d H:i:s', strtotime($request->end))) === false) {
            Session::flash("flash_message", "Ill-formatted end date.");
            return Redirect::back();
        } elseif ($request->end == "") {
            $membership->deleted_at = null;
        }

        $membership->save();

        return Redirect::route("committee::edit", ["id" => $membership->committee->id]);

    }

    public function deleteMembership($id)
    {

        $membership = CommitteeMembership::withTrashed()->findOrFail($id);

        Session::flash("flash_message", "You have removed " . $membership->user->name . " from " . $membership->committee->name . ".");

        $committee_id = $membership->committee->id;

        $membership->forceDelete();

        return Redirect::route("committee::edit", ["id" => $committee_id]);

    }

    public function showAnonMailForm($id)
    {

        $committee = Committee::fromPublicId($id);

        if (!$committee->allow_anonymous_email) {
            Session::flash("flash_message", "This committee does not accept anonymous e-mail at this time.");
            return Redirect::back();
        }

        return view('committee.anonmail', ['committee' => $committee]);

    }

    public function postAnonMailForm(Request $request, $id)
    {

        $committee = Committee::fromPublicId($id);

        if (!$committee->allow_anonymous_email) {
            Session::flash("flash_message", "This committee does not accept anonymous e-mail at this time.");
            return Redirect::back();
        }

        $email = $committee->getEmailAddress();
        $name = $committee->name;

        $message_content = strip_tags($request->get('message'));
        $message_hash = md5($message_content);

        Log::info('Anonymous e-mail with hash ' . $message_hash . ' sent to ' . $name . ' by user #' . Auth::user()->id);

        Mail::to((object)[
            'name' => $committee->name,
            'email' => $committee->getEmailAddress()
        ])->queue((new AnonymousEmail($committee, $message_content, $message_hash))->onQueue('low'));

        Session::flash("flash_message", "Your anonymous e-mail has been sent!");

        return Redirect::route('committee::show', ['id' => $committee->getPublicId()]);

    }

}