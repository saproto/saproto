<?php

namespace App\Http\Controllers;

use App\Models\CodexTextType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class CodexTextTypeController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        return view('codex.text-type-edit', ['textType' => null]);
    }

    public function store(Request $request)
    {
        $type = new CodexTextType();
        $type->type = $request->input('type');
        $type->save();

        return Redirect::route('codex.index');
    }

    public function show($id)
    {
    }

    public function edit(CodexTextType $textType)
    {
        return view('codex.text-type-edit', ['textType' => $textType]);
    }

    public function update(Request $request, CodexTextType $textType)
    {
        $textType->type = $request->input('type');
        $textType->save();

        return Redirect::route('codex.index');
    }

    public function destroy(CodexTextType $textType)
    {
        $textType->texts()->delete();
        $textType->delete();

        return Redirect::route('codex.index');
    }
}
