<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Carbon\Carbon;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\Member;
use Proto\Models\Tempadmin;
use Proto\Models\User;

use PDF;
use Auth;
use Entrust;
use Session;
use Redirect;
use Mail;

class MemberAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.members.overview');
    }

    public function showSearch(Request $request)
    {
        $search = $request->input('query');

        if ($search) {
            $users = User::where('name', 'LIKE', '%' . $search . '%')->orWhere('calling_name', 'LIKE', '%' . $search . '%')->orWhere('email', 'LIKE', '%' . $search . '%')->orWhere('utwente_username', 'LIKE', '%' . $search . '%')->paginate(20);
        } else {
            $users = User::paginate(20);
        }

        return view('users.members.nested.list', ['users' => $users]);
    }


    /**
     * Show the nested details view for member admin.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function showDetails($id)
    {
        $user = User::find($id);
        return view('users.members.nested.details', ['user' => $user]);
    }

    /**
     * Allows impersonation of another user.
     *
     * @param $id
     * @return mixed
     */
    public function impersonate($id)
    {
        if (Auth::user()->hasRole('admin')) {
            Session::put("impersonator", Auth::user()->id);
            Auth::loginUsingId($id);
            return redirect('/');
        } else {
            return abort(403);
        }
    }

    /**
     * Returns to the original user when impersonating.
     *
     * @return mixed
     */
    public function quitImpersonating()
    {
        if (Session::has("impersonator")) {
            Auth::loginUsingId(Session::get("impersonator"));
            Session::pull("impersonator");
            return response()->redirectTo("/");
        }
    }

    /**
     * Adds a member object to a user.
     *
     * @param $id
     * @return mixed
     */
    public function addMembership($id, Request $request)
    {
        $user = User::findOrFail($id);

        if (!($user->address && $user->bank)) {
            Session::flash("flash_message", "This user really needs a bank account and address. Don't bypass the system!");
            return Redirect::back();
        }

        $member = Member::create();
        $member->is_associate = !$request->input('is_primary');
        $member->user()->associate($user);

        $member->save();

        Mail::send('emails.membership', ['user' => $user, 'internal' => config('proto.internal')], function ($m) use ($user) {
            $m->replyTo('internal@proto.utwente.nl', config('proto.internal') . ' (Officer Internal Affairs)');
            $m->to($user->email, $user->name);
            $m->subject('Start of your membership of Study Association Proto');
        });

        Session::flash("flash_message", "Congratulations! " . $user->name . " is now our newest member!");

        return redirect()->route('user::member::list');
    }

    /**
     * Adds membership end date to member object.
     * Member object will be removed by cron job on end date.
     *
     * @param $id
     * @return mixed
     */
    public function endMembership($id)
    {
        $user = User::findOrFail($id);

        $user->member()->delete();

        Mail::send('emails.membershipend', ['user' => $user, 'secretary' => config('proto.secretary')], function ($m) use ($user) {
            $m->replyTo('secretary@proto.utwente.nl', config('proto.secretary') . ' (Secretary)');
            $m->to($user->email, $user->name);
            $m->subject('Termination of your membership of Study Association Proto');
        });

        Session::flash("flash_message", "Membership of " . $user->name . " has been termindated.");

        return redirect()->route('user::member::list');
    }

    public function showForm(Request $request, $id)
    {

        if ((!Auth::check() || !Auth::user()->can('board')) && $request->ip() != env('PRINTER_HOST')) {
            abort(403);
        }

        $user = User::findOrFail($id);

        if ($user->address === null) {
            Session::flash("flash_message", "This user has no address!");
            return Redirect::back();
        }

        $form = PDF::loadView('users.members.membershipform', ['user' => $user]);

        $form = $form->setPaper('a4');

        if ($request->ip() != env('PRINTER_HOST')) {
            return $form->stream();
        } else {
            return $form->download();
        }

    }

    public function printForm(Request $request)
    {

        $user = User::find($request->input('id'));

        if (!$user) {
            return "This user could not be found!";
        }

        if ($user->address->count() === 0) {
            return "This user has no address!";
        }

        $result = FileController::requestPrint('document', route('memberform::download', ['id' => $user->id]));

        if ($result === false) {
            return "Something went wrong trying to reach the printer service.";
        }

        return "The printer service responded: " . $result;

    }

    public function makeTempAdmin($id) {
        $user = User::findOrFail($id);

        $tempAdmin = new Tempadmin;

        $tempAdmin->created_by = Auth::user()->id;
        $tempAdmin->start_at = Carbon::today();
        $tempAdmin->end_at = Carbon::tomorrow();
        $tempAdmin->user()->associate($user);

        $tempAdmin->save();
        
        return redirect()->route('user::member::list');
    }

    public function endTempAdmin($id) {
        $user = User::findOrFail($id);

        foreach($user->tempadmin as $tempadmin) {
            if(Carbon::now()->between(Carbon::parse($tempadmin->start_at), Carbon::parse($tempadmin->end_at))) {
                $tempadmin->end_at = Carbon::now();
                $tempadmin->save();
            }
        }

        // Call Herbert webhook to run check through all connected admins. Will result in kick for users whose
        // temporary adminpowers were removed.
        file_get_contents(env('HERBERT_SERVER') . "/adminCheck");

        return redirect()->route('user::member::list');
    }

}
