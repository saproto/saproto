<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

class AdventController extends Controller
{
    public function index(){
        return view('advent.index');
    }
}
