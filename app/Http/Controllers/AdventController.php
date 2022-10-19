<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Proto\Models\Event;

class AdventController extends Controller
{
    public function index(){
        $ids=[1,2,3,4,5,6,7,8];
        $events=Event::whereIn('id', $ids)->get();
        return view('advent.index',['events'=>$events]);
    }
}
