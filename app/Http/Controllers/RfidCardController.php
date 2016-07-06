<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;
use Proto\Models\RfidCard;

use Redirect;
use Auth;

class RfidCardController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rfid = RfidCard::findOrFail($id);
        if (($rfid->user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }
        return view('users.rfid.edit', ['card' => $rfid]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rfid = RfidCard::findOrFail($id);
        if (($rfid->user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }

        $rfid->name = $request->input('name');
        $rfid->save();

        $request->session()->flash('flash_message', 'Your RFID card has been updated.');
        return Redirect::route('user::dashboard', ['id' => $rfid->user->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $rfid = RfidCard::findOrFail($id);
        if (($rfid->user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }
        $rfid->delete();

        $request->session()->flash('flash_message', 'Your RFID card has been deleted.');
        return Redirect::back();
    }
}
