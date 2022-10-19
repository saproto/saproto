<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Proto\Models\Event;

class AdventController extends Controller
{
    public function index(){
        $ids=[[1,2,3,4],[5,6,7,8],[9,10,11,12]];
        $events=[];
        foreach ($ids as $key=>$id){
            $events[$key]=Event::whereIn('id', $id)->get();
        }
        return view('advent.index',['events'=>$events]);
    }
}
