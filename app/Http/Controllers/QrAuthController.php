<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Milon\Barcode\DNS2D;

use Auth;

use Proto\Models\QrAuthRequest;

class QrAuthController extends Controller
{
    public function showCode($code)
    {
        $qrAuthRequest = QrAuthRequest::where('qr_token', '=', $code)->first();

        if (!$qrAuthRequest) abort(404);


        return response(DNS2D::getBarcodeSVG(route('qr::dialog', $qrAuthRequest->qr_token), "QRCODE"))->header('Content-Type', 'image/svg+xml');
    }

    public function generateRequest(Request $request)
    {
        if (!$request->has('description')) abort(500, 'No description was provided.');

        $qrAuthRequest = new QrAuthRequest();
        $qrAuthRequest->description = $request->description;
        $qrAuthRequest->qr_token = str_random(8);
        $qrAuthRequest->auth_token = md5(str_random(40));
        $qrAuthRequest->save();

        return $qrAuthRequest;
    }

    public function showDialog($code)
    {
        $qrAuthRequest = QrAuthRequest::where('qr_token', '=', $code)->first();

        if (!$qrAuthRequest) abort(404);

        return view('auth.qr.dialog', ['description' => $qrAuthRequest->description, 'code' => $qrAuthRequest->qr_token]);
    }

    public function approve($code)
    {
        $qrAuthRequest = QrAuthRequest::where('qr_token', '=', $code)->first();

        if (!$qrAuthRequest) abort(404);

        $qrAuthRequest->approved_at = \Carbon::now();
        $qrAuthRequest->user_id = Auth::id();

        $qrAuthRequest->save();

        return view('auth.qr.done');
    }

    public function apiApprove($code)
    {
        $qrAuthRequest = QrAuthRequest::where('qr_token', '=', $code)->first();

        if (!$qrAuthRequest) abort(403);

        $qrAuthRequest->approved_at = \Carbon::now();
        $qrAuthRequest->user_id = Auth::id();

        $qrAuthRequest->save();

        return response()->json([ "status" => "ok" ], 200);
    }

    public function apiInfo($code)
    {
        $qrAuthRequest = QrAuthRequest::where('qr_token', '=', $code)->first();

        if (!$qrAuthRequest) abort(404);

        return response()->json(["description" => $qrAuthRequest->description], 200);
    }

    public function isApproved(Request $request)
    {
        $qrAuthRequest = QrAuthRequest::where('auth_token', '=', $request->code)->first();

        if (!$qrAuthRequest) abort(404);

        if ($qrAuthRequest->isApproved()) {
            return "true";
        } else {
            return "false";
        }
    }

    public function getAuthUser($authToken)
    {
        $qrAuthRequest = QrAuthRequest::where('auth_token', '=', $authToken)->first();

        if (!$qrAuthRequest) return false;

        return $qrAuthRequest->authUser();
    }
}
