<?php

namespace Proto\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Proto\Models\EmailList;
use Proto\Models\User;
use Redirect;

class EmailListController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('emailadmin.editlist', ['list' => null]);
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
        EmailList::create([
            'name'           => $request->input('name'),
            'description'    => $request->input('description'),
            'is_member_only' => $request->has('is_member_only'),
        ]);
        $request->session()->flash('flash_message', 'Your list has been created!');

        return Redirect::route('email::admin');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('emailadmin.editlist', ['list' => EmailList::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $list = EmailList::findOrFail($id);
        $list->fill([
            'name'           => $request->input('name'),
            'description'    => $request->input('description'),
            'is_member_only' => $request->has('is_member_only'),
        ]);
        $list->save();

        $request->session()->flash('flash_message', 'The list has been updated!');

        return Redirect::route('email::admin');
    }

    /**
     * Toggle subscription states for a user.
     *
     * @param Request $request
     * @param $id
     * @param $user_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleSubscription(Request $request, $id)
    {
        $user = Auth::user();
        $list = EmailList::findOrFail($id);

        if ($list->isSubscribed($user)) {
            if ($list->unsubscribe($user)) {
                $request->session()->flash('flash_message', 'You have been unsubscribed to the list '.$list->name.'.');

                return Redirect::route('user::dashboard');
            }
        } else {
            if ($list->is_member_only && !$user->is_member) {
                $request->session()->flash('flash_message', 'This list is only for members.');

                return Redirect::route('user::dashboard');
            }
            if ($list->subscribe($user)) {
                $request->session()->flash('flash_message', 'You have been subscribed to the list '.$list->name.'.');

                return Redirect::route('user::dashboard');
            }
        }

        $request->session()->flash('flash_message', 'Something went wrong toggling your subscription for '.$list->name.'.');

        return Redirect::route('user::dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $list = EmailList::findOrFail($id);
        $list->delete();

        $request->session()->flash('flash_message', 'The list has been deleted!');

        return Redirect::route('email::admin');
    }

    public static function autoSubscribeToLists($type, $user)
    {
        $lists = config('proto.'.$type);
        foreach ($lists as $list) {
            $list = EmailList::find($list);
            if ($list) {
                $list->subscribe($user);
            }
        }
    }
}
