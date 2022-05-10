<?php

namespace Proto\Http\Controllers;

use Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use Proto\Models\Dinnerform;
use Session;

class DinnerformController extends Controller
{
    /**
     * @param  int $id
     * @return RedirectResponse
     */
    public function show($id)
    {
        /** @var Dinnerform $dinnerform */
        $dinnerform = Dinnerform::findOrFail($id);

        if ($dinnerform->isCurrent()) {
            return Redirect::away($dinnerform->url);
        } else {
            Session::flash('flash_message', "Sorry, you can't order anymore, food is already on its way");
            return Redirect::route('homepage');
        }
    }

    /** @return View */
    public function create()
    {
        $dinnerformList = Dinnerform::all()->sortByDesc('end');

        return view('dinnerform.admin', ['dinnerformCurrent' => null, 'dinnerformList' => $dinnerformList]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->end < $request->start) {
            Session::flash('flash_message', 'You cannot let the dinner form close before it opens.');
            return Redirect::back();
        }

        $dinnerform = Dinnerform::create([
            'restaurant' => $request->restaurant,
            'description' => $request->description,
            'url' => $request->url,
            'start' => strtotime($request->start),
            'end' => strtotime($request->end),
        ]);

        Session::flash('flash_message', "Your dinner form at '".$dinnerform->restaurant."' has been added.");
        return Redirect::route('dinnerform::add');
    }

    /**
     * @param  int $id
     * @return View
     */
    public function edit($id)
    {
        $dinnerformCurrent = Dinnerform::findOrFail($id);
        $dinnerformList = Dinnerform::all()->sortByDesc('end');

        return view('dinnerform.admin', ['dinnerformCurrent' => $dinnerformCurrent, 'dinnerformList' => $dinnerformList]);
    }

    /**
     * @param Request $request
     * @param  int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if ($request->end < $request->start) {
            Session::flash('flash_message', 'You cannot let the dinnerform close before it opens.');
            return Redirect::back();
        }

        /** @var Dinnerform $dinnerform */
        $dinnerform = Dinnerform::findOrFail($id);
        $changed_important_details = $dinnerform->start->timestamp != strtotime($request->start) || $dinnerform->end->timestamp != strtotime($request->end) || $dinnerform->restaurant != $request->restaurant;

        $dinnerform->update([
            'restaurant' => $request->restaurant,
            'description' => $request->description,
            'url' => $request->url,
            'start' => strtotime($request->start),
            'end' => strtotime($request->end),
        ]);

        if ($changed_important_details) {
            Session::flash('flash_message', "Your dinner form for '".$dinnerform->restaurant."' has been saved. You updated some important information. Don't forget to update your participants with this info!");
        } else {
            Session::flash('flash_message', "Your dinner form for '".$dinnerform->restaurant."' has been saved.");
        }

        return Redirect::route('dinnerform::add');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        $dinnerform = Dinnerform::findOrFail($id);

        Session::flash('flash_message', "The dinner form for '".$dinnerform->restaurant."' has been deleted.");

        $dinnerform->delete();

        if (URL::previous() != route('dinnerform::edit', ['id' => $dinnerform->id])) {
            return Redirect::back();
        } else {
            return Redirect::route('dinnerform::add');
        }
    }

    /**
     * Close the dinnerform by changing the end time to the current time.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function close($id)
    {
        /** @var Dinnerform $dinnerform */
        $dinnerform = Dinnerform::findOrFail($id);
        $dinnerform->end = Carbon::now();
        $dinnerform->save();

        return Redirect::route('dinnerform::add');
    }
}
