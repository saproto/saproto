<?php

namespace App\Http\Controllers;

use App\Models\Codex;
use App\Models\CodexTextType;
use App\Models\SongCategory;

class CodexController extends Controller
{
    public function index()
    {
        $codices=Codex::orderBy('name')->get();
        $textTypes=CodexTextType::orderBy('type')->with('texts')->withCount('texts')->get();
        $songTypes=SongCategory::orderBy('name')->with('songs')->withCount('songs')->get();
        return view('codex.index', ['codices' => $codices, 'textTypes' => $textTypes, 'songTypes' => $songTypes]);
    }
}
