<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\URL;
use Proto\Models\Account;
use Proto\Models\Dinnerform;
use Proto\Models\StorageEntry;
use Proto\Models\User;

use Session;
use Redirect;
use Auth;
use Response;

class DinnerformController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('dinnerform.admin', ['dinnerform' => null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $dinnerform = new Dinnerform();
        $dinnerform->restaurant = $request->restaurant;
        $dinnerform->description = $request->description;
        $dinnerform->url = $request->url;
        $dinnerform->start = strtotime($request->start);
        $dinnerform->end = strtotime($request->end);

        if ($dinnerform->end < $dinnerform->start) {
            Session::flash("flash_message", "You cannot let the dinner form close before it opens.");
            return Redirect::back();
        }

        $dinnerform->save();

        Session::flash("flash_message", "Your dinner form at '" . $dinnerform->restaurant . "' has been added.");
        return Redirect::route('homepage');

    }

    /**
     * Display the specified event.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dinnerform = Dinnerform::fromPublicId($id);

        if ($dinnerform->start < date('U') && $dinnerform->end > date('U')) {
            return Redirect::away($dinnerform->url);
        } else {
            Session::flash("flash_message", "Sorry, you can't order anymore, because food is already on its way");
            return Redirect::route('homepage');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $dinnerform = Dinnerform::findOrFail($id);
        if($dinnerform != null) {
            return view('dinnerform.admin', ['dinnerform' => $dinnerform]);
        } else {
            return Redirect::route('homepage');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {

        $dinnerform = Dinnerform::findOrFail($id);

        $changed_important_details = $dinnerform->start != strtotime($request->start) || $dinnerform->end != strtotime($request->end) || $dinnerform->restaurant != $request->restaurant ? true : false;

        $dinnerform->restaurant = $request->restaurant;
        $dinnerform->start = strtotime($request->start);
        $dinnerform->end = strtotime($request->end);
        $dinnerform->description = $request->description;

        if ($dinnerform->end < $dinnerform->start) {
            Session::flash("flash_message", "You cannot let the dinnerform close before it opens.");
            return Redirect::back();
        }

        $dinnerform->save();

        if ($changed_important_details) {
            Session::flash("flash_message", "Your dinner form for '" . $dinnerform->restaurant . "' has been saved. You updated some important information. Don't forget to update your participants with this info!");
        } else {
            Session::flash("flash_message", "Your dinner form for '" . $dinnerform->restaurant . "' has been saved.");
        }

        return Redirect::route('homepage');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dinnerform = Dinnerform::findOrFail($id);

        Session::flash("flash_message", "The dinner form '" . $dinnerform->restaurant . "' has been deleted.");

        if(URL::previous() != route('dinnerform::edit', ['id' => $dinnerform->id])) {
            $dinnerform->delete();
            return Redirect::back();
        } else {
            $dinnerform->delete();
            return Redirect::route('dinnerform::add');
        }
    }

}
