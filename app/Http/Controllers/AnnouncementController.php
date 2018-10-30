<?php

namespace Proto\Http\Controllers;

use Auth;
use Cookie;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Proto\Models\Announcement;
use Proto\Models\HashMapItem;

class AnnouncementController extends Controller
{

    public function index()
    {

        return view("announcements.list", ['announcements' => Announcement::orderBy('display_from', 'asc')->get()]);

    }

    public function create()
    {

        return view('announcements.edit', ['announcement' => null]);

    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['display_from'] = date('Y-m-d H:i:s', strtotime($data['display_from']));
        $data['display_till'] = date('Y-m-d H:i:s', strtotime($data['display_till']));
        $announcement = Announcement::create($data);
        $announcement->save();

        Session::flash('flash_message', 'Announcement created.');
        return Redirect::route('announcement::edit', ['id' => $announcement->id]);

    }

    public function edit(Request $request, $id)
    {

        return view('announcements.edit', ['announcement' => Announcement::findOrFail($id)]);

    }

    public function update(Request $request, $id)
    {

        $announcement = Announcement::findOrFail($id);
        $data = $request->except(['_token', 'id']);
        $data['display_from'] = date('Y-m-d H:i:s', strtotime($data['display_from']));
        $data['display_till'] = date('Y-m-d H:i:s', strtotime($data['display_till']));
        $announcement->fill($data);
        $announcement->save();

        Session::flash('flash_message', 'Announcement updated.');
        return Redirect::route('announcement::edit', ['id' => $announcement->id]);

    }

    public function destroy($id)
    {

        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        Session::flash('flash_message', 'Announcement deleted.');
        return Redirect::route('announcement::index');

    }

    public function clear()
    {

        Announcement::where('display_till', '<', date('Y-m-d'))->delete();

        Session::flash('flash_message', 'Announcements cleared.');
        return Redirect::route('announcement::index');

    }

    public function dismiss($id)
    {

        $announcement = Announcement::findOrFail($id);

        if (!$announcement->is_dismissable) {
            Session::flash('flash_message', 'You cannot dismiss this announcement.');
            return Redirect::back();
        }

        $announcement->dismissForUser(Auth::user());

        Session::flash('flash_message', 'Announcement dismissed.');
        return Redirect::back();

    }

}
