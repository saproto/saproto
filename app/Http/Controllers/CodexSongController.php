<?php

namespace App\Http\Controllers;

use App\Models\CodexSong;
use App\Models\CodexSongCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class CodexSongController extends Controller
{
    public function index(): void {}

    public function create(): View|RedirectResponse
    {
        if (! CodexSongCategory::query()->count()) {
            Session::flash('flash_message', 'You need to add a song category first!');

            return to_route('codex.index');
        }

        $categories = CodexSongCategory::query()->orderBy('name')->get();

        return view('codex.song-edit', ['song' => null, 'textType' => null, 'categories' => $categories, 'myCategories' => []]);
    }

    public function store(Request $request): RedirectResponse
    {
        $song = new CodexSong;
        $this->saveSong($song, $request);

        return to_route('codex.index');
    }

    public function show(CodexSong $codexSong): void {}

    public function edit(CodexSong $codexSong): View
    {
        $categories = CodexSongCategory::query()->orderBy('name')->get();

        $myCategories = $codexSong->category->id;

        return view('codex.song-edit', ['song' => $codexSong, 'categories' => $categories, 'myCategories' => $myCategories]);
    }

    public function update(Request $request, CodexSong $codexSong): RedirectResponse
    {
        $this->saveSong($codexSong, $request);

        return to_route('codex.index');
    }

    public function destroy(CodexSong $codexSong): RedirectResponse
    {
        $codexSong->delete();

        return to_route('codex.index');
    }

    private function saveSong(CodexSong $song, Request $request): void
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'artist' => ['required', 'string', 'max:255'],
            'lyrics' => ['required', 'string'],
            'youtube' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'integer'],
        ]);
        $song->title = $validated['title'];
        $song->artist = $validated['artist'];
        $song->lyrics = $validated['lyrics'];
        $song->youtube = $validated['youtube'];
        $song->category_id = $validated['category'];
        $song->save();
    }
}
