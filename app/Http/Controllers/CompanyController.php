<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\StorageEntry;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return RedirectResponse|View
     */
    public function index()
    {
        $companies = Company::query()->with('media')->where('on_carreer_page', true)->inRandomOrder()->get();
        if (count($companies) > 0) {
            return view('companies.list', ['companies' => $companies]);
        }

        Session::flash('flash_message', 'There is currently nothing to see on the companies page, but please check back real soon!');

        return Redirect::back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return RedirectResponse|View
     */
    public function indexMembercard()
    {
        $companies = Company::query()->where('on_membercard', true)->inRandomOrder()->get();
        if (count($companies) > 0) {
            return view('companies.listmembercard', ['companies' => $companies]);
        }

        Session::flash('flash_message', 'There are currently no promotions for Proto members, please check back real soon!');

        return Redirect::back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function adminIndex(): \Illuminate\Contracts\View\View|Factory
    {
        return view('companies.adminlist', ['companies' => Company::query()->orderBy('sort')->paginate(20)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): \Illuminate\Contracts\View\View|Factory
    {
        return view('companies.edit', ['company' => null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     *
     * @throws FileNotFoundException
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|max:5120|mimes:jpeg,png,jpg', // max 5MB
        ]);

        $company = new Company;
        $company->name = $request->name;
        $company->url = $request->url;
        $company->excerpt = $request->excerpt;
        $company->description = $request->description;
        $company->on_carreer_page = $request->has('on_carreer_page');
        $company->in_logo_bar = $request->has('in_logo_bar');
        $company->membercard_excerpt = $request->membercard_excerpt;
        $company->membercard_long = $request->membercard_long;
        $company->on_membercard = $request->has('on_membercard');
        $company->sort = Company::query()->max('sort') + 1;

        $company->save();

        if ($request->has('image')) {
            try {
                $company->addMediaFromRequest('image')
                    ->usingFileName('company_'.$company->id)
                    ->toMediaCollection();
            } catch (FileDoesNotExist|FileIsTooBig $e) {
                Session::flash('flash_message', $e->getMessage());

                return Redirect::back();
            }
        }

        Session::flash('flash_message', "Your company '".$company->name."' has been added.");

        return Redirect::route('companies::admin');
    }

    /**
     * Display the specified resource.
     *
     * @return View
     */
    public function show(int $id): \Illuminate\Contracts\View\View|Factory
    {
        return view('companies.show', ['company' => Company::query()->findOrFail($id)]);
    }

    /**
     * Display the specified resource.
     *
     * @return View
     */
    public function showMembercard(int $id): \Illuminate\Contracts\View\View|Factory
    {
        return view('companies.showmembercard', ['company' => Company::query()->findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return View
     */
    public function edit(int $id): \Illuminate\Contracts\View\View|Factory
    {
        $company = Company::query()->findOrFail($id);

        return view('companies.edit', ['company' => $company]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return RedirectResponse
     *
     * @throws FileNotFoundException
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'image' => 'nullable|image|max:5120|mimes:jpeg,png,jpg', // max 5MB
        ]);

        $company = Company::query()->findOrFail($id);
        $company->name = $request->name;
        $company->url = $request->url;
        $company->excerpt = $request->excerpt;
        $company->description = $request->description;
        $company->on_carreer_page = $request->has('on_carreer_page');
        $company->in_logo_bar = $request->has('in_logo_bar');
        $company->membercard_excerpt = $request->membercard_excerpt;
        $company->membercard_long = $request->membercard_long;
        $company->on_membercard = $request->has('on_membercard');

        $company->save();


        if ($request->has('image')) {
            try {
                $company->addMediaFromRequest('image')
                    ->usingFileName('company_'.$company->id)
                    ->toMediaCollection();
            } catch (FileDoesNotExist|FileIsTooBig $e) {
                Session::flash('flash_message', $e->getMessage());

                return Redirect::back();
            }
        }

        Session::flash('flash_message', "Your company '".$company->name."' has been edited.");

        return Redirect::route('companies::admin');
    }

    /**
     * @return RedirectResponse
     */
    public function orderUp(int $id)
    {
        $company = Company::query()->findOrFail($id);

        if ($company->sort <= 0) {
            abort(500);
        }

        $companyAbove = Company::query()->where('sort', $company->sort - 1)->first();

        $companyAbove->sort++;
        $companyAbove->save();

        $company->sort--;
        $company->save();

        return Redirect::route('companies::admin');
    }

    /**
     * @return RedirectResponse
     */
    public function orderDown(int $id)
    {
        $company = Company::query()->findOrFail($id);

        if ($company->sort >= Company::query()->count() - 1) {
            abort(500);
        }

        $companyAbove = Company::query()->where('sort', $company->sort + 1)->first();

        $companyAbove->sort--;
        $companyAbove->save();

        $company->sort++;
        $company->save();

        return Redirect::route('companies::admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @throws Exception
     */
    public function destroy(int $id): RedirectResponse
    {
        $company = Company::query()->findOrFail($id);

        Session::flash('flash_message', "The company '".$company->name."' has been deleted.");
        $company->delete();

        return Redirect::route('companies::admin');
    }
}
