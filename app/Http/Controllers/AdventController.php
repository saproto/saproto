<?php

namespace Proto\Http\Controllers;

use Carbon;
use Proto\Models\Event;

class AdventController extends Controller
{
    public function index(){
        $ids=[[2028,13,73,17],[15,61,72,84],[84,34,31,42]];
        $date=Carbon::create('first day of december')->addHours(12);
        $date=Carbon::createFromFormat('Y-m-d H:i:s', '2022-10-19 12:05:00');
        $events=[];
        foreach ($ids as $key=>$id){
            $events[$key]=Event::whereIn('id', $id)->get();
        }
        return view('advent.index',['eventsArray'=>$events, 'date'=>$date]);
    }
}
