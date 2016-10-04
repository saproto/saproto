<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Auth;
use Proto\Models\OrderLine;
use Proto\Models\Product;
use Proto\Models\User;

use Redirect;

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
            'next_withdrawal' => $next_withdrawal
        ]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminindex(Request $request)
    {

        $date = ($request->has('date') ? $request->input('date') : null);

        $orderlines = OrderLine::where('created_at', '>=', ($date ? Carbon::parse($date)->format('Y-m-d H:i:s') : Carbon::today()->format('Y-m-d H:i:s')));

        if ($date != null) {
            $orderlines = $orderlines->where('created_at', '<=', Carbon::parse($date . ' 23:59:59')->format('Y-m-d H:i:s'));
        }

        $orderlines = $orderlines->orderBy('created_at', 'desc')->get();

        return view('omnomcom.orders.adminhistory', [
            'date' => $date,
            'orderlines' => ($orderlines ? $orderlines : [])
        ]);

    }

    /**
     * Bulk store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function bulkStore(Request $request)
    {
        for ($i = 0; $i < count($request->input('user')); $i++) {

            //dd($request);

            $user = User::findOrFail($request->input('user')[$i]);
            $product = Product::findOrFail($request->input('product')[$i]);
            $price = ($request->input('price')[$i] != "" ? $request->input('price')[$i] : $product->price);
            $units = $request->input('units')[$i];

            $order = OrderLine::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'original_unit_price' => $product->price,
                'units' => $units,
                'total_price' => $price * $units
            ]);

            $order->save();

            $product->stock -= $units;
            $product->save();

        }

        $request->session()->flash('flash_message', 'Your manual orders have been added.');
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $order = OrderLine::findOrFail($id);

        if ($order->isPayed()) {
            $request->session()->flash('flash_message', 'The orderline cannot be deleted, as it has already been paid for.');
            return Redirect::back();
        }

        $order->product->stock += $order->units;
        $order->product->save();

        $order->delete();

        $request->session()->flash('flash_message', 'The orderline was deleted.');
        return Redirect::back();
    }
}
