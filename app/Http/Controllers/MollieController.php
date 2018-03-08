<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;
use Proto\Models\Account;
use Proto\Models\OrderLine;
use Proto\Models\MollieTransaction;

use Auth;
use Mollie;
use Proto\Models\Product;
use Proto\Models\Event;
use Redirect;
use Session;

use DB;
use Carbon;

class MollieController extends Controller
{

    public function pay(Request $request)
    {
        $cap = floatval($request->cap);
        $total = 0;

        $orderlines = [];

        foreach (OrderLine::where('user_id', Auth::id())->whereNull('payed_with_cash')->whereNull('payed_with_mollie')->whereNull('payed_with_withdrawal')->orderBy('created_at', 'asc')->get() as $orderline) {
            if ($total + $orderline->total_price > $cap) {
                break;
            }
            $orderlines[] = $orderline->id;
            $total += $orderline->total_price;
        }

        if ($total <= 0) {
            Session::flash("flash_message", "You cannot complete a purchase using this cap. Please try to increase the maximum amount you wish to pay!");
            return Redirect::back();
        }

        $fee = config('omnomcom.mollie')['fixed_fee'] + $total * config('omnomcom.mollie')['variable_fee'];

        $orderline = OrderLine::findOrFail(Product::findOrFail(config('omnomcom.mollie')['fee_id'])->buyForUser(Auth::user(), 1, $fee));
        $orderline->save();

        $orderlines[] = $orderline->id;

        $transaction = MollieController::createPaymentForOrderlines($orderlines);

        OrderLine::whereIn('id', $orderlines)->update(['payed_with_mollie' => $transaction->id]);

        return Redirect::to($transaction->payment_url);

    }

    public function status($id)
    {
        $transaction = MollieTransaction::findOrFail($id);
        if ($transaction->user->id != Auth::id() && !Auth::user()->can('board')) {
            abort(403, "You are unauthorized to view this transcation.");
        }
        $transaction = $transaction->updateFromWebhook();
        return view('omnomcom.mollie.status', ['transaction' => $transaction, 'mollie' => Mollie::api()->payments()->get($transaction->mollie_id)]);
    }

    public function index()
    {
        return view('omnomcom.mollie.list', [
            'transactions' => MollieTransaction::orderBy('updated_at', 'desc')->get(),
            'accounts' => MollieController::getAccounts()
        ]);
    }

    public function monthly(Request $request, $month)
    {

        if (strtotime($month) === false) {
            $request->session()->flash('flash_message', 'Invalid date: ' . $month);
            return Redirect::back();
        }

        // We do one massive query to reduce the number of queries.
        $orderlines = DB::table('orderlines')
            ->join('products', 'orderlines.product_id', '=', 'products.id')
            ->join('accounts', 'products.account_id', '=', 'accounts.id')
            ->select('orderlines.*', 'accounts.account_number', 'accounts.name')
            ->whereNotNull('orderlines.payed_with_mollie')
            ->where('orderlines.created_at', 'like', $month . '-%')
            ->get();


        return view("omnomcom.accounts.orderlines-breakdown", [
            'accounts' => Account::generateAccountOverviewFromOrderlines($orderlines),
            'title' => "Account breakdown for Mollie transactions in " . date('F Y', strtotime($month))
        ]);

    }

    /**
     * Display the accounts associated with mollie payments.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public static function getAccounts()
    {

        // We do one massive query to reduce the number of queries.
        $orderlines = DB::table('orderlines')
            ->join('products', 'orderlines.product_id', '=', 'products.id')
            ->join('accounts', 'products.account_id', '=', 'accounts.id')
            ->join('mollie_transactions', 'orderlines.payed_with_mollie', '=', 'mollie_transactions.id')
            ->select('orderlines.*', 'accounts.account_number', 'accounts.name')
            ->whereNotNull('orderlines.payed_with_mollie')
            ->where(function ($query) {
                $query->where('mollie_transactions.status', '=', 'paid')->orWhere('mollie_transactions.status', '=', 'paidout');
            })
            ->get();

        $accounts = [];

        foreach ($orderlines as $orderline) {
            // We sort by date, where a date goes from 6am - 6am.
            $month = Carbon::parse($orderline->created_at)->format('m-Y');

            // Shorthand variable names.
            $accnr = $orderline->account_number;

            // Add account to dataset if not existing yet.
            if (!isset($accounts[$month])) {
                $accounts[$month] = (object)[
                    'byAccounts' => [],
                    'name' => Carbon::parse($orderline->created_at)->format('F Y'),
                    'total' => 0
                ];
            }

            // Add orderline to total account price.
            $accounts[$month]->total += $orderline->total_price;

            // Add date to account data if not existing yet.
            if (!isset($accounts[$month]->byAccounts[$accnr])) {
                $accounts[$month]->byAccounts[$accnr] = (object)[
                    'name' => $orderline->account_number . " " . $orderline->name,
                    'total' => 0
                ];
            }

            // Add orderline to account-on-date total.
            $accounts[$month]->byAccounts[$accnr]->total += $orderline->total_price;
        }

        ksort($accounts);
        foreach ($accounts as $month) {
            ksort($month->byAccounts);
        }

        return $accounts;
    }

    public function receive($id)
    {
        $transaction = MollieTransaction::findOrFail($id);
        $transaction = $transaction->updateFromWebhook();

        $completed = true;

        if ($transaction->user->id == Auth::id()) {
            if (MollieTransaction::translateStatus($transaction->status) == 'failed') {
                Session::flash("flash_message", "Your payment was cancelled.");
                $completed = false;
            } elseif (MollieTransaction::translateStatus($transaction->status) == 'paid') {
                Session::flash("flash_message", "Your payment was completed successfully!");
            }
        }

        if (Session::has('prepaid_tickets')) {
            $event_id = Session::get('prepaid_tickets');
            Session::remove('prepaid_tickets');
            if ($completed) {
                Session::flash("flash_message", "Order completed succesfully! You can find your tickets on this event page.");
            } else {
                Session::flash("flash_message", "Order failed. Pre-paid tickets where not bought. Please try your purchase again.");
            }
            return Redirect::route('event::show', ['id' => Event::findOrFail($event_id)->getPublicId()]);
        }
        return Redirect::route('omnomcom::orders::list');
    }

    public function webhook($id)
    {
        $transaction = MollieTransaction::findOrFail($id);
        $transaction->updateFromWebhook();
        abort(200, "Mollie webhook processed correctly!");
    }

    public static function createPaymentForOrderlines($orderlines)
    {

        $transaction = MollieTransaction::create([
            'user_id' => Auth::id(),
            'mollie_id' => 'temp',
            'status' => 'draft'
        ]);

        $total = OrderLine::whereIn('id', $orderlines)->sum('total_price');

        $mollie = Mollie::api()->payments()->create([
            "amount" => $total,
            "description" => "OmNomCom Settlement (€" . number_format($total, 2) . ")",
            "redirectUrl" => route('omnomcom::mollie::receive', ['id' => $transaction->id]),
            "webhookUrl" => route('webhook::mollie', ['id' => $transaction->id])
        ]);

        $transaction->mollie_id = $mollie->id;
        $transaction->amount = $mollie->amount;
        $transaction->payment_url = $mollie->getPaymentUrl();
        $transaction->save();

        return $transaction;

    }
}
