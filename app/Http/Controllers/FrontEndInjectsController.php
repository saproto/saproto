<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Proto\Models\FrontEndInjects;

use Session;
use Redirect;

class FrontEndInjectsController extends Controller
{
    /**
     * @return mixed
     */
    public function index() {
        $injects = FrontEndInjects::all();
        return view('frontendinjections.admin', ['injectCurrent' => null, 'injects' => $injects]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request) {
        $inject = new FrontEndInjects();
        $inject->name = $request->input('name');
        $inject->content = $request->input('content');
        $inject->enabled = $request->has('enabled');
        $inject->save();

        Session::flash('flash_message', 'The front-end injection has been created');
        return Redirect::back();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function edit(int $id) {
        $injects = FrontEndInjects::all();
        $injectCurrent = FrontEndInjects::findOrFail($id);
        return view('frontendinjections.admin', ['injectCurrent' => $injectCurrent, 'injects' => $injects]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id) {
        $inject = FrontEndInjects::findOrFail($id);
        $inject->name = $request->input('name');
        $inject->content = $request->input('content');
        $inject->enabled = $request->has('enabled');
        $inject->save();

        Session::flash('flash_message', 'The front-end injection has been updated');
        return Redirect::back();
    }

    public function destroy($id) {
        $inject = FrontEndInjects::findOrFail($id);
        Session::flash('flash_message', "The front-end inject '".$inject->name."' has been removed.");
        $inject->delete();
        return Redirect::route('inject::admin');
    }
}
