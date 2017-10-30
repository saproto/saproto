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

        if ($request->wizard > 0) Session::flash("wizard", true);

        return view('users.bankaccounts.addbank', ['user' => $user, 'new' => true]);
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

        $bankdata = BankController::doVerifyIban($request->input('iban'), $request->input('bic'));
        if ($bankdata->status == false) {
            Session::flash("flash_message", $bankdata->message);
            return Redirect::back();
        }

        $bank = Bank::create([
            'iban' => $bankdata->iban,
            'bic' => $bankdata->bic,
            'machtigingid' => BankController::generateAuthorizationId($user)
        ]);

        $user->bank()->delete();
        $bank->user()->associate($user);
        $bank->save();

        Session::flash("flash_message", "New withdrawal authorization added.");

        if (Session::get('wizard')) return Redirect::route('becomeamember');

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

        $bankdata = BankController::doVerifyIban($request->input('iban'), $request->input('bic'));
        if ($bankdata->status == false) {
            Session::flash("flash_message", $bankdata->message);
            return Redirect::back();
        }

        $bank = Bank::create([
            'iban' => $bankdata->iban,
            'bic' => $bankdata->bic,
            'machtigingid' => BankController::generateAuthorizationId($user)
        ]);

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
        if ($user->hasUnpaidOrderlines()) {
            Session::flash("flash_message", "You cannot revoke your bank authorization while you still have unpaid orderlines.");
            return Redirect::back();
        }
        $user->bank->delete();

        Session::flash("flash_message", "Deleted bank account.");
        return Redirect::route('user::dashboard', ['id' => $id]);
    }

    public function verifyIban(Request $request)
    {
        return json_encode(BankController::doVerifyIban($request->input('iban'), $request->input('bic')));
    }

    public static function doVerifyIban($iban, $bic = null)
    {
        $response = (object)[
            'status' => true,
            'message' => 'Valid',
            'iban' => iban_to_machine_format($iban),
            'bic' => str_replace(' ', '', strtoupper($bic))
        ];

        if (!verify_iban($response->iban)) {
            $response->status = false;
            $response->message = 'Your IBAN is not valid.';
            return $response;
        }

        if (!iban_country_is_sepa(iban_get_country_part($response->iban))) {
            $response->status = false;
            $response->message = 'Your bank is not a member of SEPA (Single Euro Payments Area) so you can\'t use this bank account here. Please try another one.';
            return $response;
        }

        try {

            $openiban_response = json_decode(file_get_contents('https://openiban.com/validate/' . $response->iban . '?validateBankCode=true&getBIC=true'));

            if (property_exists($openiban_response->bankData, 'bic')) {

                $response->bic = $openiban_response->bankData->bic;

            } else {

                if ($response->bic != '' && BankController::verifyBic($response->bic)) {
                    $response->status = false;
                    $response->message = 'Your BIC is not valid.';
                    return $response;
                }
            }

        } catch (\ErrorException $e) {

            if ($response->bic != '' && BankController::verifyBic($response->bic)) {
                $response->status = false;
                $response->message = 'Your BIC is not valid.';
                return $response;
            }

        }

        return $response;

    }

    public static function verifyBic($bic)
    {
        return preg_match('/([a-zA-Z]{4}[a-zA-Z]{2}[a-zA-Z0-9]{2}([a-zA-Z0-9]{3})?)/', $bic) !== 1;
    }

    public static function generateAuthorizationId($user)
    {
        return "PROTOX" . str_pad($user->id, 5, "0", STR_PAD_LEFT) . "X" . str_pad(mt_rand(0, 99999), 5, "0");
    }

}