<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Proto\Models\FailedWithdrawal;
use Proto\Models\OrderLine;
use Proto\Models\Product;
use Proto\Models\TicketPurchase;
use Proto\Models\User;

use Redirect;
use DB;

class OrderLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($date = null)
    {

        $user = Auth::user();

        $next_withdrawal = $orderlines = OrderLine::where('user_id', $user->id)->whereNull('payed_with_cash')->whereNull('payed_with_bank_card')->whereNull('payed_with_mollie')->whereNull('payed_with_withdrawal')->sum('total_price');

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

        $total = 0;
        if ($orderlines->has($selected_month)) {
            $selected_orders = $orderlines[Carbon::parse($date)->format('Y-m')];
            foreach ($selected_orders as $orderline) {
                if ($orderline->total_price > 0) {
                    $total += $orderline->total_price;
                }
            }
        }

        return view('omnomcom.orders.myhistory', [
            'user' => $user,
            'available_months' => $available_months,
            'selected_month' => $selected_month,
            'orderlines' => ($orderlines->has($selected_month) ? $orderlines[$selected_month] : []),
            'next_withdrawal' => $next_withdrawal,
            'total' => $total
        ]);

    }

    /**
     * @param Request $request
     * @param null $date
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminindex(Request $request, $date = null)
    {

        if ($request->has('date')) {
            return Redirect::route('omnomcom::orders::adminlist', ['date' => $request->get('date')]);
        }

        $date = ($date ? $date : date('Y-m-d'));

        if (Auth::user()->can('alfred')) {
            $orderlines = OrderLine::whereHas('product', function ($query) {
                $query->where('account_id', '=', config('omnomcom.alfred-account'));
            })->where('created_at', '>=', ($date ? Carbon::parse($date)->format('Y-m-d H:i:s') : Carbon::today()->format('Y-m-d H:i:s')));
        } else {
            $orderlines = OrderLine::where('created_at', '>=', ($date ? Carbon::parse($date)->format('Y-m-d H:i:s') : Carbon::today()->format('Y-m-d H:i:s')));
        }

        if ($date != null) {
            $orderlines = $orderlines->where('created_at', '<=', Carbon::parse($date . ' 23:59:59')->format('Y-m-d H:i:s'));
        }

        $orderlines = $orderlines->orderBy('created_at', 'desc')->paginate(20);

        return view('omnomcom.orders.adminhistory', [
            'date' => $date,
            'orderlines' => ($orderlines ? $orderlines : [])
        ]);

    }

    /**
     * Bulk store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function bulkStore(Request $request)
    {

        for ($i = 0; $i < count($request->input('user')); $i++) {

            $user = User::findOrFail($request->input('user')[$i]);
            $product = Product::findOrFail($request->input('product')[$i]);
            $price = ($request->input('price')[$i] != "" ? floatval(str_replace(",", ".", $request->input('price')[$i])) : $product->price);
            $units = $request->input('units')[$i];

            $product->buyForUser($user, $units, $price * $units, null, null, $request->input('description'), sprintf('bulk_add_by_%u', Auth::user()->id));

        }

        $request->session()->flash('flash_message', 'Your manual orders have been added.');
        return Redirect::back();
    }

    /**
     * Store (a) simple orderline(s).
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        for ($u = 0; $u < count($request->input('user')); $u++) {
            for ($p = 0; $p < count($request->input('product')); $p++) {

                $user = User::findOrFail($request->input('user')[$u]);
                $product = Product::findOrFail($request->input('product')[$p]);

                $product->buyForUser($user, 1, null, null, null, null, sprintf('simple_add_by_%u', Auth::user()->id));

            }
        }

        $request->session()->flash('flash_message', 'Your manual orders have been added.');
        return Redirect::back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $order = OrderLine::findOrFail($id);

        if (!$order->canBeDeleted()) {
            $request->session()->flash('flash_message', 'The orderline cannot be deleted.');
            return Redirect::back();
        }

        $order->product->stock += $order->units;
        $order->product->save();

        TicketPurchase::where('orderline_id', $id)->delete();
        FailedWithdrawal::where('correction_orderline_id', $id)->delete();

        $order->delete();

        $request->session()->flash('flash_message', 'The orderline was deleted.');
        return Redirect::back();
    }


    /**
     * Display aggregated payment totals for cash and card payments to check the financial administration.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showPaymentStatistics(Request $request)
    {
        if ($request->has('start') && $request->has('end')) {
            $start = date('Y-m-d H:i:s', strtotime($request->start));
            $end = date('Y-m-d H:i:s', strtotime($request->end));
            $total_cash = DB::table('orderlines')->where('created_at', '>', $start)->where('created_at', '<', $end)
                ->whereNotNull('payed_with_cash')->select(DB::raw('SUM(total_price) as total'))->get()[0]->total;
            $total_card = DB::table('orderlines')->where('created_at', '>', $start)->where('created_at', '<', $end)
                ->whereNotNull('payed_with_bank_card')->select(DB::raw('SUM(total_price) as total'))->get()[0]->total;
            return view('omnomcom.statistics.payments', [
                'start' => $request->start,
                'end' => $request->end,
                'total_cash' => $total_cash,
                'total_card' => $total_card
            ]);
        } else {
            return view('omnomcom.statistics.date-select', ['select_text' => 'Select a time range over which to calculate payment totals.']);
        }
    }
}
