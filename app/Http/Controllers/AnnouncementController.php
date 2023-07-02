<?php

namespace Proto\Http\Controllers;

use Auth;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Proto\Models\Announcement;

class AnnouncementController extends Controller
{
    /** @return View */
    public function index()
    {
        return view('announcements.list', ['announcements' => Announcement::orderBy('display_from', 'asc')->get()]);
    }

    /** @return View */
    public function create()
    {
        return view('announcements.edit', ['announcement' => null]);
    }

    /**
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['display_from'] = date('Y-m-d H:i:s', strtotime($data['display_from']));
        $data['display_till'] = date('Y-m-d H:i:s', strtotime($data['display_till']));
        $announcement = new Announcement();
        $this->saveAnnouncement($announcement, $request);

        Session::flash('flash_message', 'Announcement created.');

        return Redirect::route('announcement::edit', ['id' => $announcement->id]);
    }

    /**
     * @param  int  $id
     * @return View
     */
    public function edit(Request $request, $id)
    {
        return view('announcements.edit', ['announcement' => Announcement::findOrFail($id)]);
    }

    /**
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);
        $this->saveAnnouncement($announcement, $request);
        Session::flash('flash_message', 'Announcement updated.');

        return Redirect::route('announcement::edit', ['id' => $announcement->id]);
    }

    private function saveAnnouncement($announcement, $request)
    {
        $announcement->description = $request->description;
        $announcement->content = $request->input('content');
        $announcement->display_from = date('Y-m-d H:i:s', strtotime($request->input('display_from')));
        $announcement->display_till = date('Y-m-d H:i:s', strtotime($request->input('display_till')));
        $announcement->show_guests = $request->has('show_guests');
        $announcement->show_users = $request->has('show_users');
        $announcement->show_members = $request->has('show_members');
        $announcement->show_only_homepage = $request->has('show_only_homepage');
        $announcement->show_only_new = $request->has('show_only_new');
        $announcement->show_only_firstyear = $request->has('show_only_firstyear');
        $announcement->show_only_active = $request->has('show_only_active');
        $announcement->show_as_popup = $request->has('show_as_popup');
        $announcement->show_style = $request->input('show_style');
        $announcement->is_dismissable = $request->has('is_dismissable');
        $announcement->save();
    }

    /**
     * @param  int  $id
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function destroy($id)
    {
        /** @var Announcement $announcement */
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        Session::flash('flash_message', 'Announcement deleted.');

        return Redirect::route('announcement::index');
    }

    /**
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function clear()
    {
        Announcement::where('display_till', '<', date('Y-m-d'))->delete();

        Session::flash('flash_message', 'Announcements cleared.');

        return Redirect::route('announcement::index');
    }

    /**
     * @param  int  $id
     * @return RedirectResponse
     */
    public function dismiss($id)
    {
        /** @var Announcement $announcement */
        $announcement = Announcement::find($id);

        if ($announcement == null || ! $announcement->is_dismissable) {
            return Redirect::back();
        }

        $announcement->dismissForUser(Auth::user());

        return Redirect::back();
    }
}
