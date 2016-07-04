<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\Page;

use Auth;
use Session;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::all();
        return view("pages.list", ['pages' => $pages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("pages.edit", ['item' => null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $page = new Page($request->all());

        if ($request->has('is_member_only')) {
            $page->is_member_only = true;
        } else {
            $page->is_member_only = false;
        }

        $page->save();

        Session::flash('flash_message', 'Page ' . $page->title . ' has been created.');
        return Redirect::route('page::list');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $page = Page::where('slug', '=', $slug)->first();

        if($page == null) {
            abort(404, "Page not found.");
        }

        if($page->is_member_only && !(Auth::check() && Auth::user()->member != null)) {
            abort(500, "You need to be a member of S.A. Proto to see this page.");
        }

        return view('pages.show', ['page' => $page]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::find($id);

        return view('pages.edit', ['item' => $page]);
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
        $page = Page::find($id);
        $page->fill($request->all());

        if ($request->has('is_member_only')) {
            $page->is_member_only = true;
        } else {
            $page->is_member_only = false;
        }

        $page->save();

        Session::flash('flash_message', 'Page ' . $page->title . ' has been saved.');
        return Redirect::route('page::list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::find($id);

        Session::flash('flash_message', 'Page ' . $page->title . ' has been removed.');

        $page->delete();

        return Redirect::route('page::list');
    }
}
