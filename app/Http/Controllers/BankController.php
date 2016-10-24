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
use Validator;


class BankController extends Controller
{

    public function addForm($id, Request $request)
    {
        $user = User::findOrFail($id);

        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }
        if ($user->bank != null) {
            Session::flash("flash_message", "You already have a bank authorization. Please use the update form.");
            return Redirect::route('user::dashboard', ['id' => $id]);
        }

        if($request->wizard > 0) Session::flash("wizard", true);

        return view('users.bankaccounts.addbank', ['user' => $user, 'new' => true]);
    }

    public static function validateBankInput($data, $user)
    {

        $newbankdata = array(
            'iban' => strtoupper(str_replace(' ', '', $data['iban'])),
            'bic' => strtoupper(str_replace(' ', '', $data['bic'])),
            'machtigingid' => "PROTOX" . str_pad($user->id, 5, "0", STR_PAD_LEFT) . "X" . str_pad(mt_rand(0, 99999), 5, "0")
        );

        $v = Validator::make($newbankdata, [
            'iban' => 'required|regex:([A-Z]{2}[0-9]{2}[a-zA-Z0-9]{4}[0-9]{7}([a-zA-Z0-9]?){0,16})',
            'bic' => 'required|regex:([a-zA-Z]{4}[a-zA-Z]{2}[a-zA-Z0-9]{2}([a-zA-Z0-9]{3})?)',
            'machtigingid' => 'required|unique:bankaccounts,machtigingid|regex:((PROTO)(X)([0-9]{5})(X)([0-9]{5}))'
        ]);

        if ($v->fails()) {
            return false;
        }

        return $newbankdata;

    }

    public function add($id, Request $request)
    {

        $user = User::find($id);

        if ($user == null) {
            abort(404);
        }

        if ($user->id != Auth::id()) {
            abort(403);
        }

        $bankdata = BankController::validateBankInput($request->all(), $user);
        if ($bankdata == false) {
            Session::flash("flash_message", "Your IBAN and/or BIC are invalid. Please check again.");
            return Redirect::back();
        }
        $bank = Bank::create($bankdata);
        $bank->user()->associate($user);
        $bank->save();

        Session::flash("flash_message", "New withdrawal authorization added.");

        if(Session::get('wizard')) return Redirect::route('becomeamember');

        return Redirect::route('user::dashboard', ['id' => $id]);

    }

    public function editForm($id)
    {
        $user = User::findOrFail($id);

        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }
        if ($user->bank == null) {
            Session::flash("flash_message", "You don't have a bank authorization to update.");
            return Redirect::route('user::dashboard', ['id' => $id]);
        }

        return view('users.bankaccounts.addbank', ['user' => $user, 'new' => false]);
    }

    public function edit($id, Request $request)
    {
        $user = User::findOrFail($id);

        if ($user->id != Auth::id()) {
            abort(403);
        }
        if ($user->bank == null) {
            Session::flash("flash_message", "You don't have a bank authorization to update.");
            return Redirect::route('user::dashboard', ['id' => $id]);
        }

        $bankdata = BankController::validateBankInput($request->all(), $user);
        if ($bankdata == false) {
            Session::flash("flash_message", "Your IBAN and/or BIC are invalid. Please check again.");
            return Redirect::back();
        }
        $bank = Bank::create($bankdata);
        $user->bank()->delete();
        $bank->user()->associate($user);
        $bank->save();

        Session::flash("flash_message", "New withdrawal authorization added.");

        return Redirect::route('user::dashboard', ['id' => $id]);
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
            Session::flash("flash_message", "You don't have a bank authorization to revoke.");
            return Redirect::route('user::dashboard', ['id' => $id]);
        }
        if ($user->member) {
            Session::flash("flash_message", "As a member you cannot revoke your bank authorization. You can update it, though.");
            return Redirect::back();
        }
        $user->bank->delete();

        Session::flash("flash_message", "Deleted bank account.");
        return Redirect::route('user::dashboard', ['id' => $id]);
    }

}