<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Proto\Http\Requests;

use Proto\Models\User;
use Proto\Models\WelcomeMessage;

use Session;
use Auth;
use Redirect;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function overview()
    {
        return view('welcomemessages.list', ['messages' => WelcomeMessage::orderBy('created_at', 'desc')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = WelcomeMessage::where('user_id', $request->user_id)->first();
        if (!$message) {
            $message = new WelcomeMessage();

            $message->user_id = $request->user_id;
            $message->message = $request->message;

            $message->save();

            Session::flash('flash_message', "Welcome Message set");
        } else {
            $message->message = $request->message;

            $message->save();

            Session::flash('flash_message', "Welcome Message updated");
        }
        return Redirect::route("welcomeMessages::list");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = WelcomeMessage::find($id);
        if (!$message) abort(404);
        $message->delete();
        Session::flash('flash_message', "Welcome Message removed");
        return Redirect::route("welcomeMessages::list");
    }

}
