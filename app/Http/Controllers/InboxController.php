<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Redirect;

class InboxController extends Controller
{
    /** @return View */
    public function index()
    {
        $inboxes = json_decode(settings()->group('email')->get('additional_inboxes'));

        return view('inboxes.index', ['inboxes' => $inboxes]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'new_inbox' => 'required',
        ]);

        $inboxes = json_decode(settings()->group('email')->get('additional_inboxes'));
        $inboxes[] = $request->get('new_inbox');

        settings()->group('email')->set([
            'additional_inboxes' => json_encode($inboxes),
        ]);

        return Redirect::back();
    }

    public function destroy($inbox)
    {
        $inboxes = json_decode(settings()->group('email')->get('additional_inboxes'));
        $toDelete = array_search($inbox, $inboxes);
        unset($inboxes[$toDelete]);

        settings()->group('email')->set([
            'additional_inboxes' => json_encode($inboxes),
        ]);

        return Redirect::back();
    }
}
