<?php

namespace Proto\Http\Controllers;

use Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Proto\Models\Event;

class AdventController extends Controller
{
    public function index() {
        $ids = [2063, 2067, 2068, 2072, 2070, 2064, 2071, 2065, 2066];
        $date = Carbon::createFromFormat('Y-m-d H:i:s', '2022-11-30 12:12:12');

//        to test uncomment the two lines below!
//        $ids=[2040,2,3, 1,5,2068, 7,2030,9];
//        $date=Carbon::createFromFormat('Y-m-d H:i:s', '2022-10-19 12:05:00');

        $events = Event::whereIn('id', $ids)->get();
        return view('advent.index',['eventsArray'=>$events, 'date'=>$date]);
    }

    public function toggleDecember() {
            Cookie::queue('disable-december', Cookie::get('disable-december') === 'disabled' ? 'enabled' : 'disabled', 43800);
            return Redirect::back();
    }
}
