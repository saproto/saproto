<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;
use Proto\Models\Newsitem;
use Proto\Models\StorageEntry;

use Auth;
use Redirect;
use Session;
use GrahamCampbell\Markdown\Facades\Markdown;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $newsitems = Newsitem::all();

        return view('news.list', ['newsitems' => $newsitems]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("news.edit", ['item' => null, 'new' => true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newsitem = new Newsitem();

        $newsitem->fill($request->all());
        $newsitem->published_at = date("Y-m-d H:i:s", strtotime($request->published_at));
        $newsitem->user_id = Auth::user()->id;

        $newsitem->save();

        return redirect(route('news::list'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $newsitem = Newsitem::findOrFail($id);

        return view('news.show', ['newsitem' => $newsitem, 'parsedContent' => Markdown::convertToHtml($newsitem->content)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $newsitem = Newsitem::findOrFail($id);

        return view("news.edit", ['item' => $newsitem, 'new' => false]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $newsitem = Newsitem::findOrFail($id);

        $newsitem->fill($request->all());
        $newsitem->published_at = date("Y-m-d H:i:s", strtotime($request->published_at));

        $newsitem->save();

        return redirect(route('news::list'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $newsitem = Newsitem::findOrFail($id);

        Session::flash('flash_message', 'Newsitem ' . $newsitem->title . ' has been removed.');

        $newsitem->delete();

        return Redirect::route('news::list');
    }

    /**
     * Change the featured image of the page.
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function featuredImage(Request $request, $id) {
        $newsitem = Newsitem::findOrFail($id);

        $image = $request->file('image');
        if ($image) {
            $file = new StorageEntry();
            $file->createFromFile($image);

            $newsitem->featuredImage()->associate($file);
            $newsitem->save();
        } else {
            $newsitem->featuredImage()->dissociate();
            $newsitem->save();
        }

        return Redirect::route('news::edit', ['id' => $id]);
    }
}
