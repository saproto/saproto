<?php

namespace App\Http\Controllers;

use App\Models\CodexSongCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CodexSongCategoryController extends Controller
{
    public function index(): void {}

    public function create(): View
    {
        return view('codex.song-category-edit', ['category' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $category = new CodexSongCategory;
        $category->name = $validated['name'];
        $category->save();

        return to_route('codex.index');
    }

    public function show(CodexSongCategory $codexSongCategory): void {}

    public function edit(CodexSongCategory $codexSongCategory): View
    {
        return view('codex.song-category-edit', ['category' => $codexSongCategory]);
    }

    public function update(Request $request, CodexSongCategory $codexSongCategory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $codexSongCategory->name = $validated['name'];
        $codexSongCategory->save();

        return to_route('codex.index');
    }

    public function destroy(CodexSongCategory $codexSongCategory): RedirectResponse
    {
        $codexSongCategory->songs()->delete();
        $codexSongCategory->delete();

        return to_route('codex.index');
    }
}
