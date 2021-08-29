<?php

namespace Proto\Http\Controllers;

use Auth;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Proto\Models\QrAuthRequest;
use Proto\Models\RfidCard;
use Redirect;

class RfidCardController extends Controller
{
    /**
     * @param Request $request
     * @return string This method returns raw HTML and is intended to be used via AJAX!
     * @throws Exception
     */
    public function store(Request $request)
    {
        switch ($request->input('credentialtype')) {
            case 'qr':
                $qrAuthRequest = QrAuthRequest::where('auth_token', $request->input('credentials'))->first();
                if (! $qrAuthRequest) {
                    return "<span style='color: red;'>Invalid authentication token.</span>";
                }
                $user = $qrAuthRequest->authUser();
                if (! $user) {
                    return "<span style='color: red;'>QR authentication hasn't been completed.</span>";
                }
                break;

            default:
                return "<span style='color: red;'>Invalid credential type.</span>";
        }

        if (! $user->is_member) {
            return "<span style='color: red;'>You must be a member to use the OmNomCom.</span>";
        }

        $uid = $request->input('card');
        if (strlen($uid) == 0) {
            return "<span style='color: red;'>Empty card UID provided. Did you scan your card properly?</span>";
        }

        $card = RfidCard::where('card_id', $uid)->first();
        if ($card) {
            if ($card->user->id == $user->id) {
                return "<span style='color: red;'>This card is already registered to you!</span>";
            } else {
                return "<span style='color: red;'>This card is already registered to someone.</span>";
            }
        } else {
            $card = RfidCard::create([
                'user_id' => $user->id,
                'card_id' => $uid,
            ]);
            $card->save();

            return "<span style='color: green;'>This card has been successfully registered to ".$user->name.'.</span>';
        }
    }

    /**
     * @param $id
     * @return View
     */
    public function edit($id)
    {
        /** @var RfidCard $rfid */
        $rfid = RfidCard::findOrFail($id);
        if (($rfid->user->id != Auth::id()) && (! Auth::user()->can('board'))) {
            abort(403);
        }

        return view('users.rfid.edit', ['card' => $rfid]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        /** @var RfidCard $rfid */
        $rfid = RfidCard::findOrFail($id);
        if ($rfid->user->id != Auth::id()) {
            abort(403);
        }

        $rfid->name = $request->input('name');
        $rfid->save();

        $request->session()->flash('flash_message', 'Your RFID card has been updated.');
        return Redirect::route('user::dashboard');
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Request $request, $id)
    {
        /** @var RfidCard $rfid */
        $rfid = RfidCard::findOrFail($id);
        if ($rfid->user->id != Auth::id()) {
            abort(403);
        }
        $rfid->delete();

        $request->session()->flash('flash_message', 'Your RFID card has been deleted.');
        return Redirect::back();
    }
}
