<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Proto\Models\RadioStation;

class RadioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stations = RadioStation::all();

        return view('protube.radio.index', ['stations' => $stations]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        RadioStation::create($request->all());
        Session::flash('flash_message', 'Radio station added.');

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $radio = RadioStation::findOrFail($id);
        Session::flash('flash_message', 'Radio station '.$radio->name.' added.');
        $radio->delete();

        return Redirect::back();
    }

    /**
     * Return a public list of radio stations for Herbert.
     *
     * @return mixed
     */
    public function api()
    {
        return RadioStation::all();
    }
}
