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
            abort(404, "Member $id not found.");
        }
        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403, "You cannot add a bank account for " . $user->name . ".");
        }
        if ($user->bank != null) {
            abort(500, "This user already has a bank account.");
        }
        return view('users.bankaccounts.addbank', ['user' => $user]);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user == null) {
            abort(404, "Member $id not found.");
        }
        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403, "You cannot delete a bank account for " . $user->name . ".");
        }
        if ($user->bank == null) {
            abort(500, "This user has no bank account.");
        }
        $user->bank->user_id = null;
        $user->bank->save();

        Session::flash("flash_message", "Deleted bank account.");
        return Redirect::route('user::profile', ['id' => $id]);
    }

    public function add($id, Request $request)
    {

        $user = User::find($id);

        if ($user == null) {
            abort(404, "Member $id not found.");
        }

        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403, "You cannot add a bank account for " . $user->name . ".");
        }

        // Establish new bank
        $new = array(
            'iban' => strtoupper($request->input("iban")),
            'bic' => strtoupper($request->input("bic")),
            'machtigingid' => "PROTOX" . str_pad($user->id, 5, "0", STR_PAD_LEFT) . "X" . str_pad(mt_rand(0, 99999), 5, "0"),
            'withdrawal_type' => "FRST",
            'user_id' => $user->id
        );

        $bank = new Bank();
        if (!$bank->validate($new)) {
            return Redirect::route('user::bank::add', ['id' => $id])->withErrors($bank->errors());
        }

        // Save it baby!
        $bank->fill($new);
        $bank->save();

        Session::flash("flash_message", "New withdrawal authorization added.");

        return Redirect::route('user::profile', ['id' => $id]);

    }

}