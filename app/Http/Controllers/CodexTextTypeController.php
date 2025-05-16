<?php

namespace App\Http\Controllers;

use App\Models\CodexTextType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CodexTextTypeController extends Controller
{
    public function index(): void {}

    public function create(): View
    {
        return view('codex.text-type-edit', ['textType' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
        ]);
        $type = new CodexTextType;
        $type->type = $validated['type'];
        $type->save();

        return Redirect::route('codex.index');
    }

    public function show(CodexTextType $codexTextType): void {}

    public function edit(CodexTextType $codexTextType): View
    {
        return view('codex.text-type-edit', ['textType' => $codexTextType]);
    }

    public function update(Request $request, CodexTextType $codexTextType): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
        ]);
        $codexTextType->type = $validated['type'];
        $codexTextType->save();

        return Redirect::route('codex.index');
    }

    public function destroy(CodexTextType $codexTextType): RedirectResponse
    {
        $codexTextType->texts()->delete();
        $codexTextType->delete();

        return Redirect::route('codex.index');
    }
}
