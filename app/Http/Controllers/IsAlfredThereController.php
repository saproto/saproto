<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Proto\Models\HashMapItem;
use stdClass;

class IsAlfredThereController extends Controller
{
    public static $HashMapItemKey = 'is_alfred_there';
    public static $HashMapTextKey = 'is_alfred_there_text';
    /** @return View */
    public function showMiniSite()
    {
        return view('isalfredthere.minisite');
    }

    /** @return false|string */
    public function getApi()
    {
        header('Access-Control-Allow-Origin: *');
        return json_encode(self::getAlfredsStatusObject());
    }

    /** @return View */
    public function getAdminInterface()
    {
        return view('isalfredthere.admin', ['status' => self::getAlfredsStatusObject()]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function postAdminInterface(Request $request)
    {
        $text=self::getOrCreateHasMapItem(self::$HashMapTextKey);
        $status = self::getOrCreateHasMapItem(self::$HashMapItemKey);
        $new_status = $request->input('where_is_alfred');
        $arrival_time = $request->input('back');

        if ($new_status === 'there' || $new_status === 'unknown') {
            $status->value = $new_status;
            $text->value='';
        } elseif ($new_status === 'away') {
            $status->value = strtotime($arrival_time);
            $text->value = $request->input('is_alfred_there_text');
        }elseif($new_status === 'text_only'){
            $text->value = $request->input('is_alfred_there_text');
            $status->value='unknown';
        }
        $status->save();
        $text->save();
        return Redirect::back();
    }

    /** @return HashMapItem|null */
    public static function getOrCreateHasMapItem($key)
    {
        $item = HashMapItem::where('key', $key)->first();
        if (!$item) {
            $item = HashMapItem::create([
                'key' => $key,
                'value' => '',
            ]);
        }
        return $item;
    }

    /** @return stdClass */
    public static function getAlfredsStatusObject()
    {
        $result = new stdClass();
        $result->text=self::getOrCreateHasMapItem(self::$HashMapTextKey)->value;

        $status = self::getOrCreateHasMapItem(self::$HashMapItemKey);
        if ($status->value == 'there' ?? $status->value == 'unknown') {
            $result->status = $status->value;
            return $result;
        } elseif (preg_match('/^[0-9]{10}/', $status->value) === 1) {
            $result->status = 'away';
            $result->back = date('Y-m-d H:i', $status->value);
            $result->backunix = $status->value;
            return $result;
        }
        $result->status = 'unknown';
        return $result;
    }
}
