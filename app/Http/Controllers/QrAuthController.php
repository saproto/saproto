<?php

namespace App\Http\Controllers;

use App\Events\QRAuthApproved;
use App\Models\QrAuthRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use Milon\Barcode\DNS2D;

class QrAuthController extends Controller
{
    /**
     * @return Response
     */
    public function showCode(string $code)
    {
        $qrAuthRequest = QrAuthRequest::query()->where('qr_token', '=', $code)->first();

        abort_if($qrAuthRequest == null, 404);

        return response((new DNS2D)->getBarcodeSVG(route('qr::dialog', $qrAuthRequest->qr_token), 'QRCODE'))->header('Content-Type', 'image/svg+xml');
    }

    public function generateRequest(Request $request): QrAuthRequest
    {
        abort_unless($request->has('description'), 500, 'No description was provided.');

        $qrAuthRequest = new QrAuthRequest;
        $qrAuthRequest->description = $request->description;
        $qrAuthRequest->qr_token = Str::random(8);
        $qrAuthRequest->auth_token = md5(Str::random(40));
        $qrAuthRequest->save();

        return $qrAuthRequest;
    }

    public function showDialog(string $code): View|Factory
    {
        $qrAuthRequest = QrAuthRequest::query()->where('qr_token', '=', $code)->first();

        abort_if($qrAuthRequest === null, 404);

        return view('auth.qr.dialog', ['description' => $qrAuthRequest->description, 'code' => $qrAuthRequest->qr_token]);
    }

    public function approve(string $code): View|Factory
    {
        $qrAuthRequest = QrAuthRequest::query()->where('qr_token', '=', $code)->first();

        abort_if($qrAuthRequest === null, 404);

        $qrAuthRequest->approved_at = Date::now();
        $qrAuthRequest->user_id = Auth::id();

        $qrAuthRequest->save();

        event(new QRAuthApproved($qrAuthRequest->auth_token));

        return view('auth.qr.done');
    }

    public function isApproved(Request $request): string
    {
        $qrAuthRequest = QrAuthRequest::query()->where('auth_token', '=', $request->code)->first();

        abort_if($qrAuthRequest === null, 404);

        if ($qrAuthRequest->isApproved()) {
            return 'true';
        }

        return 'false';
    }
}
