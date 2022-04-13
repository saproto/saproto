<?php

namespace Proto\Http\Controllers;

use Auth;
use Carbon;
use DB;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Proto\Models\FailedWithdrawal;
use Proto\Models\OrderLine;
use Proto\Models\Product;
use Proto\Models\TicketPurchase;
use Proto\Models\User;
use Redirect;

class OrderLineController extends Controller
{
    /**
     * @param null $date
     * @return View
     */
    public function index($selected_month = null)
    {
        $user = Auth::user();

        $next_withdrawal = OrderLine::where('user_id', $user->id)->whereNull('payed_with_cash')->whereNull('payed_with_bank_card')->whereNull('payed_with_mollie')->whereNull('payed_with_withdrawal')->sum('total_price');

        if ($selected_month == null) {
            $this_month = Carbon::now()->startOfMonth();
            $next_month = Carbon::now()->startOfMonth()->addMonth(1);
        } else {
            $this_month = Carbon::createFromDate($selected_month)->startOfMonth();
            $next_month = Carbon::createFromDate($selected_month)->startOfMonth()->addMonth(1);
        }

        $orderlines = OrderLine::where('user_id', $user->id)->where('created_at', '>=', $this_month)->where('created_at', '<', $next_month)->orderBy('created_at', 'desc')->get();
        $total = $orderlines->sum('total_price');

        $grouped_orderlines = $orderlines->groupBy(function ($orderline_date) {
            return Carbon::parse($orderline_date->created_at)->format('Y-m');
        });

        $available_months_collection = OrderLine::selectRaw('MONTH(created_at) month, YEAR(created_at) year')->where('user_id', $user->id)->groupBy('month')->orderBy('year', 'desc')->orderBy('month', 'desc')->get();

        $available_months = [];

        foreach ($available_months_collection as $month) {
            if (! array_key_exists($month->year, $available_months)) {
                $available_months[$month->year] = [];
            }
            $available_months[$month->year][] = $month->month;
        }

        $current_orderlines = $grouped_orderlines->has($this_month->format('Y-m')) ? $grouped_orderlines[$this_month->format('Y-m')] : null;

        return view('omnomcom.orders.myhistory', [
            'user' => $user,
            'available_months' => $available_months,
            'selected_month' => $this_month,
            'orderlines' => $current_orderlines,
            'next_withdrawal' => $next_withdrawal,
            'total' => $total,
        ]);
    }

    /**
     * @param Request $request
     * @param null $date
     * @return View|RedirectResponse
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
            $orderlines = $orderlines->where('created_at', '<=', Carbon::parse($date.' 23:59:59')->format('Y-m-d H:i:s'));
        }

        $orderlines = $orderlines->orderBy('created_at', 'desc')->paginate(20);

        return view('omnomcom.orders.adminhistory', [
            'date' => $date,
            'orderlines' => ($orderlines ? $orderlines : []),
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function bulkStore(Request $request)
    {
        for ($i = 0; $i < count($request->input('user')); $i++) {
            /** @var Product $product */
            $product = Product::findOrFail($request->input('product')[$i]);
            $user = User::findOrFail($request->input('user')[$i]);
            $price = ($request->input('price')[$i] != '' ? floatval(str_replace(',', '.', $request->input('price')[$i])) : $product->price);
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
     * @return RedirectResponse
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
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Request $request, $id)
    {
        /** @var OrderLine $order */
        $order = OrderLine::findOrFail($id);

        if (! $order->canBeDeleted()) {
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
     * @return View
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
                'total_card' => $total_card,
            ]);
        } else {
            return view('omnomcom.statistics.date-select', ['select_text' => 'Select a time range over which to calculate payment totals.']);
        }
    }
}
