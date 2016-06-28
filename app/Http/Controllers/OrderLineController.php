<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Auth;
use Proto\Models\OrderLine;
use Proto\Models\User;

class OrderLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $user_id = null, $date = null)
    {

        if ($user_id == null) {
            $user = Auth::user();
        } else {
            $user = User::findOrFail($user_id);
        }

        if ($user->id != Auth::id() && !Auth::user()->can('board')) {
            abort(403);
        }

        $all_time_total = $orderlines = OrderLine::where('user_id', $user->id)->sum('total_price');
        $next_withdrawal = $orderlines = OrderLine::where('user_id', $user->id)->whereNull('payed_with_cash')->whereNull('payed_with_mollie')->whereNull('payed_with_withdrawal')->sum('total_price');

        $orderlines = OrderLine::where('user_id', $user->id)->orderBy('created_at', 'desc')->get()->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('Y-m');
        });

        if ($date != null) {
            $selected_month = $date;
        } else {
            $selected_month = date('Y-m');
        }

        $available_months = $orderlines->keys()->groupBy(function ($date) {
            return Carbon::parse($date)->format('Y');
        });

        return view('omnomcom.orders.myhistory', [
            'user' => $user,
            'available_months' => $available_months,
            'selected_month' => $selected_month,
            'orderlines' => ($orderlines->has($selected_month) ? $orderlines[$selected_month] : []),
            'all_time_total' => $all_time_total,
            'next_withdrawal' => $next_withdrawal
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
