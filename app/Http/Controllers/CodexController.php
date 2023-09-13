<?php

namespace App\Http\Controllers;

use App\Libraries\PDF_TOC;
use App\Models\CodexText;
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

    public function deleteSong(int $id){
        $song=CodexSong::findOrFail($id);
        $song->delete();
        return Redirect::back();
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

    public function deleteSongCategory(int $id){
        $category=SongCategory::findOrFail($id);
        $category->delete();
        return Redirect::back();
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
//        return $request;
        $codex=new Codex();
        $codex->save();
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

    public function deleteCodex(int $id){
        $codex=Codex::findOrFail($id);
        $codex->delete();
        return Redirect::back();
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

    public function deleteText(int $id){
        $text=CodexText::findOrFail($id);
        $text->delete();
        return Redirect::back();
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

    public function deleteTextType(int $id){
        $type=CodexTextType::findOrFail($id);
        $type->delete();
        return Redirect::back();
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
            $codex = Codex::findOrFail($id);

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

        $A6 = array(105,148);
        $pdf = new PDF_TOC('P','mm',$A6);

        $pdf->setMargins(10,10,10);//left, top and right margins, 1cm
        $pdf->setAutoPageBreak(true,10);//bottom margin, 1cm

        $pdf->AddFont('minion','');
        $pdf->AddFont('minion','B');
        $pdf->AddFont('minion','I');
        $pdf->AddFont('old');

        $textSize = 8;
        $headingSize = 12;
        $textHeight = 9*0.352778;
        $bulletListIndent = 7;
        $tocPage = 0;


        $pdf->AddPage(); //frontPage
        $pdf->SetFont('old','',52);
        $pdf->Image(public_path('images/logo/codex_logo.png'),10,10,85,48); $pdf->Ln(50);
        $codex_name = str_replace("’", "'", $codex->name);
        $codex_name = str_replace("‘", "'", $codex_name);
        $pdf->MultiCell(0,22,$codex_name,0,'C');
        $pdf->SetAlpha(0.1);
        $pdf->Image(public_path('images/logo/codex_logo.png'),-100,47,210);
        $pdf->SetAlpha(1);
        $pdf->AddPage(); //empty page

        foreach ($textCategories as $category){
            foreach ($category->texts as $text) {
                $pdf->AddPage();
                $pdf->startPageNums();

                $pdf->SetFont('minion', 'B', $textSize);

                $pdf->TOC_Entry($category->type, 0);
                $pdf->MultiCell(0, $textHeight, $category->type, 0, 'L');
                $pdf->SetFont('minion', '', $textSize);

                $pdf->AddFont('minion');
                $pdf->SetFont('minion', '', $textSize);
                $textArray = explode(PHP_EOL, $text->text);
                $list = false;
                $count = 0;

                foreach ($textArray as $textValue) {
                    if ($list || preg_match('/(\d+)\./', $textValue)) {
                        $textValue = str_replace("1.", "", $textValue);
                        $list = true;
                        if(!preg_match('/(\d+)\./', $textValue)) {
                            $list = false;
                        }
                        $count += 1;
                        $pdf->Cell($bulletListIndent,$textHeight,$count.".");
                    } else {
                        $count=0;
                    }
                    if (str_contains($textValue, "**")){
                        $textValue = str_replace("**", "", $textValue);
                        $pdf->SetFont('minion','B',$textSize);
                        $toc_text = substr($textValue,0,-1);
                        $pdf->TOC_Entry($toc_text,1);
                    } elseif (str_contains($textValue, "_")||str_contains($textValue, "*")) {
                        $textValue = str_replace("_", "", $textValue);
                        $textValue = str_replace("*", "", $textValue);
                        $pdf->SetFont('minion','I',$textSize);
                    }
                    $pdf->MultiCell(0,$textHeight,$textValue,0,'L');
                    $pdf->SetFont('minion','',$textSize);
                }

            $tocPage = $pdf->PageNo()+1;
            }
        }

        foreach ($categories as $category){
            $pdf->AddPage();
            $pdf->SetFont('minion','B',$headingSize);
            $pdf->MultiCell(0,$textHeight,$category->name,0,'L');
            $pdf->SetFont('minion','',$headingSize);
            $pdf->TOC_Entry($category->name,0);

            foreach ($category->songs as $song) {
                $pdf->SetFont('minion','B',$textSize);
                $pdf->MultiCell(0,$textHeight,$song->title,0,'L');
                $pdf->SetFont('minion','',$textSize);
                $link = $pdf->AddLink();
                $pdf->SetLink($link,-1,-1);
                $pdf->TOC_Entry($song->title, 1, $link);
                $lyricsArray = explode(PHP_EOL,$song->lyrics);
                $print=true;
                for ($index = 0; $index < count($lyricsArray); $index++) {
                    $text = $lyricsArray[$index];
                    if (str_contains($text, "**")){
                        $text = str_replace("**", "", $text);
                        $pdf->SetFont('minion','B',$textSize);
                    } elseif (str_contains($text, "*") || str_contains($text, "_")) {
                        $text = str_replace("*", "", $text);
                        $text = str_replace("_", "", $text);
                        $pdf->SetFont('minion','I',$textSize);
                    }  elseif (str_contains($text, ":")) {
                        $subString1 = substr($text, 0, strpos($text, ":"));
                        $subString2 = substr($text, strpos($text, ":"));
                        $pdf->SetFont('minion','I',$textSize);
                        $pdf->Cell($pdf->GetStringWidth($subString1),$textHeight,$subString1);
                        $pdf->SetFont('minion','',$textSize);
                        $pdf->Cell($pdf->GetStringWidth($subString2),$textHeight,$subString2,0,1);
                        $print=false;
                    }
                    if ($print) {
                        $pdf->MultiCell(0,$textHeight,$text,0,'L');
                        $pdf->SetFont('minion','',$textSize);
                    }
                    $print=true;
                }
                $pdf->Ln($textHeight);
            }
        }


        $pdf->AddPage(); //TOC, possibly empty pages, and notes page
        $pdf->stopPageNums();
        $pdf->insertTOC($tocPage,9,5,'minion' );

        $pagesNeeded = (4-(($pdf->PageNo()+1) % 4))%4;
        if ($pagesNeeded>0){
            for ($index = $pagesNeeded ; $index>0;$index--){
                $pdf->AddPage();
            }
        }

        $pdf->setY(10);
        $pdf->SetFont('minion','B',$textSize);
        $pdf->MultiCell(0,$textHeight,"Notes:",0,'C');

        $pdf->AddPage(); //backcover page
        $pdf->SetAlpha(0.1);
        $pdf->Image(public_path('images/logo/codex_logo.png'),-5,47,210);
        $pdf->SetAlpha(1);

        $pdf->Output();
    }
}


