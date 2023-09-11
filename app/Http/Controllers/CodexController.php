<?php

namespace App\Http\Controllers;

use App\Models\CodexText;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Http\Request;
use App\Models\Codex;
use App\Models\CodexSong;
use App\Models\CodexTextType;
use App\Models\SongCategory;
use Illuminate\Support\Facades\Redirect;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;

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
        $categories=SongCategory::orderBy('name')->get();
        return view('codex.song-edit', ['song'=>null, 'textType'=>null, 'categories' => $categories, 'myCategories' => []]);
    }

    public function editSong(int $id){
        $song=CodexSong::findOrFail($id);
        $categories=SongCategory::orderBy('name')->get();
        $myCategories=$song->categories->pluck('id')->toArray();
        return view('codex.song-edit', ['song'=>$song, 'categories' => $categories, 'myCategories' => $myCategories]);
    }
    public function storeSong(Request $request){
        $song=new CodexSong();
        $this->saveSong($song, $request);
        return Redirect::back();
    }

    public function updateSong(Request $request, int $id){
        $song=CodexSong::findOrFail($id);
        $this->saveSong($song, $request);
        return Redirect::back();
    }

    private function saveSong(CodexSong $song, Request $request){
        $song->title=$request->input('title');
        $song->artist=$request->input('artist');
        $song->lyrics=$request->input('lyrics');
        $song->youtube=$request->input('youtube');
        $song->save();
        $song->categories()->sync($request->input('categoryids'));
    }

    public function addSongCategory(){
        return view('codex.song-category-edit', ['category'=>null]);
    }

    public function editSongCategory(int $id){
        $category=SongCategory::findOrFail($id);
        return view('codex.song-category-edit', ['category'=>$category]);
    }

    public function storeSongCategory(Request $request){
        $category = new SongCategory();
        $category->name = $request->input('name');
        $category->save();
        return Redirect::route('codex::index');
    }

    public function updateSongCategory(Request $request, int $id){
        $category = SongCategory::findOrFail($id);
        $category->name = $request->input('name');
        $category->save();
        return Redirect::route('codex::index');
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

    public function addText(){
        $textTypes=CodexTextType::orderBy('type')->get();
        return view('codex.text-edit', ['text'=>null, 'textTypes' => $textTypes, 'selectedTextType' => null]);
    }

    public function editText(int $id){
        $text=CodexText::findOrFail($id);
        $textTypes=CodexTextType::orderBy('type')->get();
        $selectedTextType=$text->type;
        return view('codex.text-edit', ['text'=>$text, 'textTypes' => $textTypes, 'selectedTextType' => $selectedTextType]);
    }

    public function storeText(Request $request){
//        return $request;
        $text = new CodexText();
        $this->saveText($text, $request);
        return Redirect::route('codex::index');
    }

    public function updateText(Request $request, int $id){
        $text = CodexText::findOrFail($id);
        $this->saveText($text, $request);
        return Redirect::route('codex::index');
    }

    private function saveText(CodexText $text, Request $request){
        $text->name = $request->input('name');
        $text->type_id = $request->input('category');
        $text->text = $request->input('text');
        $text->save();
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

    private function shuffle_assoc(&$array) {
        $keys = array_keys($array);

        shuffle($keys);
        $new = array();
        foreach($keys as $key) {
            $new[$key] = $array[$key];
        }

        $array = $new;

        return true;
    }

    public function exportCodex(int $id)
    {
        try {
            $codex = Codex::findOrFail($id);
            $html2pdf = new Html2Pdf('P', 'A6', 'en', false, 'UTF-8', array(10, 10, 10, 10));

            $categories = SongCategory::whereHas('songs', function ($q) use ($id) {
                $q->whereHas('codices', function ($q) use ($id) {
                    $q->where('codex', $id);
                });
            })->with(['songs' => function ($query) use ($id) {
                $query->whereHas('codices', function ($query) use ($id) {
                    $query->where('codex_codices.id', $id);
                });
            }])->orderBy('id')->get();

            $textCategories = CodexTextType::whereHas('texts', function ($q) use ($id) {
                $q->whereHas('codices', function ($q) use ($id) {
                    $q->where('codex_codices.id', $id);
                });
            })->with(['texts' => function ($query) use ($id) {
                $query->whereHas('codices', function ($query) use ($id) {
                    $query->where('codex_codices.id', $id);
                });
            }])->orderBy('type')->get();


            $output = view('codex.codex', ['codex' => $codex, 'songCategories' => $categories, 'textCategories' => $textCategories])->render();

            $html2pdf->writeHTML($output);
            $html2pdf->createIndex("Table of Contents", 10, 4, true, true, 2, null, 0 );
            $html2pdf->output();
        } catch (Html2PdfException $e) {
            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
        }
    }
}
