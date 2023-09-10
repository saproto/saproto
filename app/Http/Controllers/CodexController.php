<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Codex;
use App\Models\CodexSong;
use App\Models\CodexTextType;
use App\Models\SongCategory;
use Illuminate\Support\Facades\Redirect;

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
        return view('codex.codex-edit', ['codex'=>null, 'textTypes' => $textTypes, 'songTypes' => $songTypes, 'mySongs' => [], 'myTexts' => [], 'myShuffles' => [], 'myTextTypes' => []]);
    }
    public function editCodex(int $id){
        $codex=Codex::findOrFail($id);
        $textTypes=CodexTextType::with('texts')->withCount('texts')->get();
        $songTypes=SongCategory::orderBy('name')->with('songs')->withCount('songs')->get();
        $mySongs=$codex->songs->pluck('id')->toArray();
        $myTexts=$codex->texts->pluck('id')->toArray();
        $myShuffles=$codex->shuffles->pluck('id')->toArray();
        return view('codex.codex-edit', ['codex'=>$codex, 'textTypes' => $textTypes, 'songTypes' => $songTypes, 'mySongs' => $mySongs, 'myTextTypes' => $myTexts, 'myShuffles' => $myShuffles]);
    }

    public function storeCodex(Request $request){
        $codex=new Codex();
        $this->saveCodex($codex, $request);
        return Redirect::back();
    }

    public function updateCodex(Request $request, int $id){
        $codex=Codex::findOrFail($id);
        $this->saveCodex($codex, $request);
        return Redirect::back();
    }

    private function saveCodex($codex, $request){
        $codex->name=$request->input('name');
        $codex->export=$request->input('export');
        $codex->description=$request->input('description');
        //todo: add category to the song sync
        $codex->songs()->sync($request->input('songids'));
        $codex->texts()->sync($request->input('textids'));
        $codex->shuffles()->sync($request->input('shuffleids'));
        $codex->save();
    }
    public function addTextType(){
        return view('codex.text-type-edit', ['textType'=>null]);
    }
    public function editTextType(int $id){
        $textType=CodexTextType::findOrFail($id);
        return view('codex.text-type-edit', ['textType'=>$textType]);
    }

    public function storeTextType(Request $request){
        $type = new CodexTextType();
        $type->type = $request->input('type');
        $type->save();
        return Redirect::route('codex::index');
    }

    public function updateTextType(Request $request, int  $id){
        $type = CodexTextType::findOrFail($id);
        $type->type = $request->input('type');
        $type->save();
        return Redirect::route('codex::index');
    }


}
