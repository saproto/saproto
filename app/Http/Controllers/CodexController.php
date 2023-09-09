<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Codex;
use App\Models\CodexSong;
use App\Models\CodexTextType;
use App\Models\SongCategory;

class CodexController extends Controller
{
    public function index()
    {
        $codices=Codex::orderBy('name')->get();
        $textTypes=CodexTextType::with('texts')->withCount('texts')->get();
        $songTypes=SongCategory::orderBy('name')->with('songs')->withCount('songs')->get();
        return view('codex.index', ['codices' => $codices, 'textTypes' => $textTypes, 'songTypes' => $songTypes]);
    }

    public function addSong(){
        return view('codex.codex-edit', ['song'=>null]);
    }

    public function editSong(CodexSong $song){
        return view('codex.codex-edit', ['song'=>$song]);
    }
    public function storeSong(Request $request){
        return $request;
    }

    public function updateSong(Request $request, CodexSong $song){
        return $request;
    }
    public function addCodex(){
        $textTypes=CodexTextType::with('texts')->withCount('texts')->get();
        $songTypes=SongCategory::orderBy('name')->with('songs')->withCount('songs')->get();
        return view('codex.codex-edit', ['codex'=>null, 'textTypes' => $textTypes, 'songTypes' => $songTypes]);
    }
    public function editCodex(int $id){
        $codex=Codex::findOrFail($id);
        return $codex;
        $textTypes=CodexTextType::with('texts')->withCount('texts')->get();
        $songTypes=SongCategory::orderBy('name')->with('songs')->withCount('songs')->get();
        return view('codex.codex-edit', ['codex'=>$codex, 'textTypes' => $textTypes, 'songTypes' => $songTypes]);
    }

    public function storeCodex(Request $request){
        return $request;
    }

    public function updateCodex(Request $request, Codex $codex){
        return $request;
    }
    public function addTextType(){
        return view('codex.codex-edit', ['textType'=>null]);
    }
    public function editTextType(CodexTextType $textType){
        return view('codex.codex-edit', ['textType'=>$textType]);
    }

    public function storeTextType(Request $request){
        return $request;
    }

    public function updateTextType(Request $request, CodexTextType $textType){
        return $request;
    }


}
