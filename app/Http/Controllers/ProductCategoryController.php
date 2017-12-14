<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;
use Proto\Models\Product;
use Proto\Models\ProductCategory;

use Redirect;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('omnomcom.categories.index', ['categories' => ProductCategory::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("omnomcom.categories.edit", ['category' => null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = ProductCategory::create($request->all());
        $category->save();

        $request->session()->flash('flash_message', 'Category ' . $category->name . ' created.');

        return Redirect::route('omnomcom::categories::list');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = ProductCategory::findOrFail($id);
        return view('omnomcom.categories.show', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = ProductCategory::findOrFail($id);

        return view("omnomcom.categories.edit", ['category' => $category]);
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
        $category = ProductCategory::findOrFail($id);
        $category->fill($request->all());
        $category->save();

        $request->session()->flash('flash_message', 'Category ' . $category->name . ' saved.');

        return Redirect::route('omnomcom::categories::list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $category = ProductCategory::findOrFail($id);

        $request->session()->flash('flash_message', 'Category ' . $category->name . ' deleted.');
        $category->delete();

        return Redirect::route('omnomcom::categories::list');
    }
}
