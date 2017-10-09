<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\Display;

class DisplayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $displays = Display::all();
        return view('protube.display.index', ['stations' => $displays]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Display::create($request->all());
        Session::flash('flash_message', 'Display added.');
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $display = Display::findOrFail($id);
        Session::flash('flash_message', 'Display ' . $display->name . ' added.');
        $display->delete();
        return Redirect::back();
    }

    public function update(Request $request, $id)
    {
        $display = Display::findOrFail($id);
        Session::flash('flash_message', 'Display ' . $display->name . ' updated.');
        $display->fill($request->all());
        $display->save();
        return Redirect::back();
    }

    /**
     * Return a public list of radio stations for Herbert.
     *
     * @return mixed
     */
    public function api()
    {
        return Display::all();
    }


}
