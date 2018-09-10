<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;
use Proto\Models\RfidCard;
use Proto\Models\QrAuthRequest;

use Redirect;
use Auth;

class RfidCardController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * This method returns raw HTML and is intended to be used via AJAX!
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        switch ($request->input('credentialtype')) {
            case 'qr':
                $qrAuthRequest = QrAuthRequest::where('auth_token', $request->input('credentials'))->first();
                if (!$qrAuthRequest) {
                    return "<span style='color: red;'>Invalid authentication token.</span>";
                }

                $user = $qrAuthRequest->authUser();
                if (!$user) {
                    return "<span style='color: red;'>QR authentication hasn't been completed.</span>";
                }

                break;

            default:
                return "<span style='color: red;'>Invalid credential type.</span>";

                break;
        }

        if (!$user->member) {
            return "<span style='color: red;'>You must be a member to use the OmNomCom.</span>";
        }

        $uid = $request->input('card');
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
                'card_id' => $uid
            ]);
            $card->save();
            return "<span style='color: green;'>This card has been successfully registered to " . $user->name . ".</span>";
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rfid = RfidCard::findOrFail($id);
        if (($rfid->user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }
        return view('users.rfid.edit', ['card' => $rfid]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
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
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $rfid = RfidCard::findOrFail($id);
        if ($rfid->user->id != Auth::id()) {
        abort(403);
    }
        $rfid->delete();

        $request->session()->flash('flash_message', 'Your RFID card has been deleted.');
        return Redirect::back();
    }
}
