<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Proto\Models\HashMapItem;

class IsAlfredThereController extends Controller
{
    public static $HashMapItemKey = 'is_alfred_there';

    public function showMiniSite()
    {
        return view('isalfredthere.minisite');
    }

    public function getApi()
    {
        header('Access-Control-Allow-Origin: *');

        return json_encode(IsAlfredThereController::getAlfredsStatusObject());
    }

    public function getAdminInterface()
    {
        return view('isalfredthere.admin', ['status' => IsAlfredThereController::getAlfredsStatusObject()]);
    }

    public function postAdminInterface(Request $request)
    {
        $status = IsAlfredThereController::getAlfredsStatus();

        $new_status = $request->input('where_is_alfred');
        $arrival_time = $request->input('back');

        if ($new_status == 'there' || $new_status == 'unknown') {
            $status->value = $new_status;
        } elseif ($new_status == 'away') {
            $status->value = $arrival_time;
        }
        $status->save();

        return Redirect::back();
    }

    public static function getAlfredsStatus()
    {
        $status = HashMapItem::where('key', IsAlfredThereController::$HashMapItemKey)->first();
        if ($status == null) {
            $status = HashMapItem::create([
                'key'   => IsAlfredThereController::$HashMapItemKey,
                'value' => 'unknown',
            ]);
        }

        return $status;
    }

    public static function getAlfredsStatusObject()
    {
        $status = IsAlfredThereController::getAlfredsStatus();
        $result = new \stdClass();
        if ($status->value == 'there' or $status->value == 'unknown') {
            $result->status = $status->value;

            return $result;
        } elseif (preg_match('/^[0-9]{2}-[0-9]{2}-[0-9]{4}/', $status->value) === 1) {
            $result->status = 'away';
            $result->back = $status->value;
            $result->backunix = strtotime($status->value);

            return $result;
        }
        $result->status = 'unknown';

        return $result;
    }
}
