<?php

namespace Proto\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Proto\Models\Alias;
use Proto\Models\User;
use Redirect;

class AliasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aliases = Alias::orderBy('alias', 'asc')->get();

        if ($aliases->count() > 0) {
            $data = [];
            foreach ($aliases as $alias) {
                $data[$alias->alias][] = $alias;
            }

            return view('aliases.index', ['aliases' => $data]);
        } else {
            return Redirect::route('alias::add');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('aliases.add');
    }

    /**
     * Update resource.
     *
     * @return mixed
     */
    public function update(Request $request)
    {
        $from = $request->input('from');
        $into = $request->input('into');

        $affected = DB::table('alias')->where('alias', $from)->update([
            'alias' => $into,
        ]);

        if ($affected > 0) {
            $request->session()->flash('flash_message', 'Renamed '.$from.' into '.$into.'.');

            return Redirect::back();
        } else {
            $request->session()->flash('flash_message', 'No such alias ('.$from.').');

            return Redirect::back();
        }
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
        if ($request->input('destination') != '') {
            $alias = Alias::create([
                'alias'       => $request->input('alias'),
                'destination' => $request->input('destination'),
            ]);
            $alias->save();

            $request->session()->flash('flash_message', 'Destination added to alias.');

            return Redirect::route('alias::index');
        } elseif ($request->input('user') != '') {
            $user = User::findOrFail($request->input('user'));

            $alias = Alias::create([
                'alias'   => $request->input('alias'),
                'user_id' => $user->id,
            ]);
            $alias->save();

            $request->session()->flash('flash_message', 'User added to alias.');

            return Redirect::route('alias::index');
        } else {
            $request->session()->flash('flash_message', 'No action performed.');

            return Redirect::route('alias::index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $idOrAlias)
    {
        $alias = Alias::find($idOrAlias);

        if ($alias) {
            $alias->delete();
            $request->session()->flash('flash_message', 'Entry deleted.');

            return Redirect::back();
        }

        $affected = DB::table('alias')->where('alias', $idOrAlias)->delete();
        if ($affected > 0) {
            $request->session()->flash('flash_message', 'Deleted alias <strong>'.$idOrAlias.'</strong> with '.$affected.' destinations.');

            return Redirect::back();
        } else {
            $request->session()->flash('flash_message', 'No such alias ('.$idOrAlias.').');

            return Redirect::back();
        }
    }
}
