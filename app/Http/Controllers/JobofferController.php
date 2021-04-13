<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Proto\Models\Company;
use Proto\Models\Joboffer;
use Redirect;
use Session;

class JobofferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::has('joboffers')->get();

        return view('companies.joboffers.list', ['companies' => $companies]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminIndex()
    {
        $joboffers = Joboffer::all();

        return view('companies.joboffers.adminlist', ['joboffers' => $joboffers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all();

        return view('companies.joboffers.edit', ['joboffer' => null, 'companies' => $companies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $description = $request->description;
        if ($description == '') {
            $description = null;
        }

        $redirect_url = $request->redirect_url;
        if ($redirect_url == '') {
            $redirect_url = null;
        }

        if ($description == null && $redirect_url == null) {
            Session::flash('flash_message', 'Please enter a description or redirect url.');

            return Redirect::back();
        }

        $joboffer = Joboffer::create($request->all());
        $joboffer->save();

        return redirect(route('joboffers::admin'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $joboffer = Joboffer::findOrFail($id);

        return view('companies.joboffers.show', ['joboffer' => $joboffer]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $joboffer = Joboffer::findOrFail($id);
        $companies = Company::all();

        return view('companies.joboffers.edit', ['joboffer' => $joboffer, 'companies' => $companies]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $joboffer = Joboffer::findOrFail($id);

        $joboffer->title = $request->title;
        $joboffer->description = $request->description;
        $joboffer->redirect_url = $request->redirect_url;
        $joboffer->save();

        Session::flash('flash_message', 'Job offer has been updated.');

        return redirect(route('joboffers::admin'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $joboffer = Joboffer::findOrFail($id);
        $joboffer->delete();

        Session::flash('flash_message', 'The job offer has been deleted.');

        return Redirect::back();
    }
}
