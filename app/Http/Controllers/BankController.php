<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\Bank;
use Proto\Models\User;

use Auth;
use Entrust;
use Session;
use Redirect;


class BankController extends Controller
{

    public function addForm($id)
    {
        $user = User::find($id);
        if ($user == null) {
            abort(404);
        }
        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }
        if ($user->bank != null) {
            abort(500);
        }
        return view('users.bankaccounts.addbank', ['user' => $user]);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user == null) {
            abort(404);
        }
        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }
        if ($user->bank == null) {
            abort(500);
        }
        $user->bank->delete();

        Session::flash("flash_message", "Deleted bank account.");
        return Redirect::route('user::dashboard', ['id' => $id]);
    }

    public function add($id, Request $request)
    {

        $user = User::find($id);

        if ($user == null) {
            abort(404);
        }

        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }

        // Sanitize input
        $request->request->add(['iban' => strtoupper($request->input("iban")), 'bic' => strtoupper($request->input("bic")), 'machtigingid' => "PROTOX" . str_pad($user->id, 5, "0", STR_PAD_LEFT) . "X" . str_pad(mt_rand(0, 99999), 5, "0")]);

        $this->validate($request, [
            'iban' => 'required|regex:([A-Z]{2}[0-9]{2}[a-zA-Z0-9]{4}[0-9]{7}([a-zA-Z0-9]?){0,16})',
            'bic' => 'required|regex:([a-zA-Z]{4}[a-zA-Z]{2}[a-zA-Z0-9]{2}([a-zA-Z0-9]{3})?)',
            'machtigingid' => 'required|unique:bankaccounts,machtigingid|regex:((PROTO)(X)([0-9]{5})(X)([0-9]{5}))',
        ]);

        // Save it baby!
        $bank = Bank::create($request->all());
        $bank->user()->associate($user);
        $bank->save();

        Session::flash("flash_message", "New withdrawal authorization added.");

        return Redirect::route('user::dashboard', ['id' => $id]);

    }

}