<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Proto\Models\SoundboardSound;
use Proto\Models\StorageEntry;

class SoundboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sounds = SoundboardSound::orderBy('name', 'asc')->paginate(50);

        return view('protube.soundboard.index', ['sounds' => $sounds]);
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
        $sound = new SoundboardSound();

        $sound->name = $request->name;

        $file = new StorageEntry();
        $file->createFromFile($request->file('sound'));
        $sound->file()->associate($file);

        $sound->save();

        Session::flash('flash_message', 'Sound added.');

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sound = SoundboardSound::findOrFail($id);
        Session::flash('flash_message', 'Sound '.$sound->name.' deleted.');
        $sound->delete();

        return Redirect::back();
    }

    public function toggleHidden($id)
    {
        $sound = SoundboardSound::findOrFail($id);
        $sound->hidden = !$sound->hidden;
        $sound->save();

        return Redirect::back();
    }

    public function apiIndex()
    {
        $sounds = SoundboardSound::all();

        $returnSounds = [];

        foreach ($sounds as $sound) {
            $returnSounds[$sound->id] = new \stdClass();
            $returnSounds[$sound->id]->name = $sound->name;
            $returnSounds[$sound->id]->file = $sound->file->generatePath();
        }

        return $returnSounds;
    }
}
