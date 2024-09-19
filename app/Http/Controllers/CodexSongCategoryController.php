<?php

namespace App\Http\Controllers;

use App\Models\CodexSongCategory;
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
        $category = new CodexSongCategory();
        $category->name = $request->input('name');
        $category->save();

        return Redirect::route('codex.index');
    }

    public function show($id)
    {
    }

    public function edit(CodexSongCategory $codexSongCategory)
    {
        return view('codex.song-category-edit', ['category' => $codexSongCategory]);
    }

    public function update(Request $request, CodexSongCategory $codexSongCategory)
    {
        $codexSongCategory->name = $request->input('name');
        $codexSongCategory->save();

        return Redirect::route('codex.index');
    }

    public function destroy(CodexSongCategory $codexSongCategory)
    {
        $codexSongCategory->songs()->delete();
        $codexSongCategory->delete();

        return Redirect::route('codex.index');
    }
}
