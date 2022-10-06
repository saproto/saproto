<?php

namespace Proto\Http\Controllers;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Proto\Models\ProductCategory;
use Redirect;

class ProductCategoryController extends Controller
{
    /** @return View */
    public function index()
    {
        return view('omnomcom.categories.index', ['categories' => ProductCategory::all()]);
    }

    /** @return View */
    public function create()
    {
        return view('omnomcom.categories.edit', ['category' => null]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $category = ProductCategory::create($request->all());
        $category->save();

        $request->session()->flash('flash_message', 'Category '.$category->name.' created.');
        return Redirect::route('omnomcom::categories::list');
    }

    /**
     * @param int $id
     * @return View
     */
    public function show($id)
    {
        $category = ProductCategory::findOrFail($id);
        return view('omnomcom.categories.edit', ['category' => $category]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        /** @var ProductCategory $category */
        $category = ProductCategory::findOrFail($id);
        $category->fill($request->all());
        $category->save();

        $request->session()->flash('flash_message', 'Category '.$category->name.' saved.');
        return Redirect::route('omnomcom::categories::list');
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Request $request, $id)
    {
        /** @var ProductCategory $category */
        $category = ProductCategory::findOrFail($id);

        $request->session()->flash('flash_message', 'Category '.$category->name.' deleted.');
        $category->delete();

        return Redirect::route('omnomcom::categories::list');
    }
}
