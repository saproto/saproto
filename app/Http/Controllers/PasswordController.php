<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Models\PasswordEntry;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\Permission;

use Redirect;
use Crypt;
use Auth;

class PasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        foreach (PasswordEntry::all() as $entry) {

        }
        return view('passwordstore.index', ['passwords' => PasswordEntry::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('passwordstore.edit', ['password' => null, 'type' => $request->get('type')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $permission = Permission::findOrFail($request->get('permission_id'));

        if ($request->get('type') == 'password') {

            PasswordEntry::create([
                'permission_id' => $permission->id,
                'description' => $request->get('description'),
                'username' => Crypt::encrypt($request->get('username')),
                'password' => Crypt::encrypt($request->get('password')),
                'url' => ($request->get('url') == "" ? null : $request->get('url')),
                'note' => null
            ]);

            $request->session()->flash('flash_message', 'Password saved.');
            return Redirect::route('passwordstore::index');

        } elseif ($request->get('type') == 'note') {

            PasswordEntry::create([
                'permission_id' => $permission->id,
                'description' => $request->get('description'),
                'username' => null,
                'password' => null,
                'url' => null,
                'note' => Crypt::encrypt($request->get('note'))
            ]);

            $request->session()->flash('flash_message', 'Note saved.');
            return Redirect::route('passwordstore::index');

        }

        $request->session()->flash('flash_message', 'Invalid input.');
        return Redirect::route('passwordstore::index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $password = PasswordEntry::findOrFail($id);
        if ($password->canAccess(Auth::user())) {
            $password->delete();
            $request->session()->flash('flash_message', 'Password entry deleted.');
            return Redirect::route('passwordstore::index');
        }
        $request->session()->flash('flash_message', 'You are not allowed to access this entry.');
        return Redirect::route('passwordstore::index');
    }
}
