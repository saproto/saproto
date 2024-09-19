<?php

namespace App\Http\Controllers;

use App\Models\CodexSong;
use App\Models\CodexSongCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;

class CodexSongController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        if (!CodexSongCategory::count()) {
            Session::flash('flash_message', 'You need to add a song category first!');

            return Redirect::route('codex.index');
        }
        $categories = CodexSongCategory::orderBy('name')->get();

        return view('codex.song-edit', ['song' => null, 'textType' => null, 'categories' => $categories, 'myCategories' => []]);
    }

    public function store(Request $request)
    {
        $song = new CodexSong();
        $this->saveSong($song, $request);

        return Redirect::route('codex.index');
    }

    public function show(CodexSong $codexSong)
    {
    }

    public function edit(CodexSong $codexSong)
    {
        $categories = CodexSongCategory::orderBy('name')->get();

        $myCategories = $codexSong->category->id;

        return view('codex.song-edit', ['song' => $codexSong, 'categories' => $categories, 'myCategories' => $myCategories]);
    }

    public function update(Request $request, CodexSong $codexSong)
    {
        $this->saveSong($codexSong, $request);

        return Redirect::route('codex.index');
    }

    public function destroy(CodexSong $codexSong)
    {
        $codexSong->delete();

        return Redirect::route('codex.index');
    }

    private function saveSong(CodexSong $song, Request $request)
    {
        $song->title = $request->input('title');
        $song->artist = $request->input('artist');
        $song->lyrics = $request->input('lyrics');
        $song->youtube = $request->input('youtube');
        $song->category_id = $request->input('category');
        $song->save();
    }
}
