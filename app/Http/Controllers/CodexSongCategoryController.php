<?php

namespace App\Http\Controllers;

use App\Models\SongCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CodexSongCategoryController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        return view('codex.song-category-edit', ['category' => null]);
    }

    public function store(Request $request)
    {
        $category = new SongCategory();
        $category->name = $request->input('name');
        $category->save();

        return Redirect::route('codex.index');
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $category = SongCategory::findOrFail($id);

        return view('codex.song-category-edit', ['category' => $category]);
    }

    public function update(Request $request, $id)
    {
        $category = SongCategory::findOrFail($id);
        $category->name = $request->input('name');
        $category->save();

        return Redirect::route('codex.index');
    }

    public function destroy($id)
    {
        $category = SongCategory::findOrFail($id);
        $category->songs()->delete();
        $category->delete();

        return Redirect::route('codex.index');
    }
}
