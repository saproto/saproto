<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use Redirect;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\Company;
use Proto\Models\StorageEntry;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     $companies = Company::where('on_carreer_page', true)->get();
        if (count($companies) > 0) {
            return view('companies.list', ['companies' => $companies]);
        } else {
            Session::flash("flash_message", "There is currently nothing to see on the companies page, but please check back real soon!");
            return Redirect::back();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexMembercard()
    {
        $companies = Company::where('on_membercard', true)->get();
        if (count($companies) > 0) {
            return view('companies.listmembercard', ['companies' => $companies]);
        } else {
            Session::flash("flash_message", "There are currently no companies on our membercard, but please check back real soon!");
            return Redirect::back();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminIndex()
    {
        return view('companies.adminlist', ['companies' => Company::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.edit', ['company' => null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $company = new Company();
        $company->name = $request->name;
        $company->url = $request->url;
        $company->excerpt = $request->excerpt;
        $company->description = $request->description;
        $company->on_carreer_page = $request->has('on_carreer_page');
        $company->in_logo_bar = $request->has('in_logo_bar');
        $company->membercard_excerpt = $request->membercard_excerpt;
        $company->membercard_long = $request->membercard_long;
        $company->on_membercard = $request->has('membercard_excerpt');

        if ($request->file('image')) {
            $file = new StorageEntry();
            $file->createFromFile($request->file('image'));
            $company->image()->associate($file);
        }

        $company->save();

        Session::flash("flash_message", "Your company '" . $company->name . "' has been added.");
        return Redirect::route('companies::admin');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('companies.show', ['company' => Company::findOrFail($id)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function showMembercard($id)
    {
        return view('companies.showmembercard', ['company' => Company::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('companies.edit', ['company' => $company]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $company = Company::findOrFail($id);
        $company->name = $request->name;
        $company->url = $request->url;
        $company->excerpt = $request->excerpt;
        $company->description = $request->description;
        $company->on_carreer_page = $request->has('on_carreer_page');
        $company->in_logo_bar = $request->has('in_logo_bar');
        $company->membercard_excerpt = $request->membercard_excerpt;
        $company->membercard_long = $request->membercard_long;
        $company->on_membercard = $request->has('membercard_excerpt');

        if ($request->file('image')) {
            $file = new StorageEntry();
            $file->createFromFile($request->file('image'));
            $company->image()->associate($file);
        }

        $company->save();

        Session::flash("flash_message", "Your company '" . $company->name . "' has been edited.");
        return Redirect::route('companies::admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);

        Session::flash("flash_message", "The company '" . $company->name . "' has been deleted.");
        $company->delete();
        return Redirect::route('companies::admin');
    }
}
