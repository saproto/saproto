<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Proto\Models\StockMutation;

class StockMutationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mutations = StockMutation::orderBy('created_at', 'desc')->paginate(20);
        return view('omnomcom.products.mutations', ['mutations' => $mutations]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StockMutation $stockMutation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockMutation $stockMutation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockMutation $stockMutation)
    {
        //
    }
}
