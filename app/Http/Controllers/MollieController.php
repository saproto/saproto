<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;
use Proto\Models\OrderLine;
use Proto\Models\MollieTransaction;

use Auth;
use Mollie;
use Proto\Models\Product;
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

        $transaction = MollieTransaction::create([
            'user_id' => Auth::id(),
            'mollie_id' => 'temp',
            'status' => 'draft'
        ]);

        $orderlines = [];

        foreach (OrderLine::where('user_id', Auth::id())->whereNull('payed_with_cash')->whereNull('payed_with_mollie')->whereNull('payed_with_withdrawal')->orderBy('created_at', 'asc')->get() as $orderline) {
            if ($total + $orderline->total_price > $cap) {
                break;
            }
            $orderlines[] = $orderline->id;
            $total += $orderline->total_price;
        }

        if ($total <= 0) {
            $transaction->delete();
            Session::flash("flash_message", "You cannot complete a purchase using this cap. Please try to increase the maximum amount you wish to pay!");
            return Redirect::back();
        }

        OrderLine::whereIn('id', $orderlines)->update(['payed_with_mollie' => $transaction->id]);

        $fee = config('omnomcom.mollie')['fixed_fee'] + $total * config('omnomcom.mollie')['variable_fee'];

        $orderline = OrderLine::findOrFail(Product::findOrFail(config('omnomcom.mollie')['fee_id'])->buyForUser(Auth::user(), 1, $fee));
        $orderline->payed_with_mollie = $transaction->id;
        $orderline->save();

        $mollie = Mollie::api()->payments()->create([
            "amount" => $total + $fee,
            "description" => "Balance (€" . number_format($total, 2) . ") + Fee (€" . number_format($fee, 2) . ")",
            "redirectUrl" => route('omnomcom::mollie::receive', ['id' => $transaction->id]),
            "webhookUrl" => route('webhook::mollie', ['id' => $transaction->id])
        ]);

        $transaction->mollie_id = $mollie->id;
        $transaction->amount = $mollie->amount;
        $transaction->save();

        return Redirect::to($mollie->getPaymentUrl());

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
            ->where('mollie_transactions.status', '=', 'paid')
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

        if ($transaction->user->id == Auth::id()) {
            if (MollieTransaction::translateStatus($transaction->status) == 'failed') {
                Session::flash("flash_message", "Your payment was cancelled.");
            } elseif (MollieTransaction::translateStatus($transaction->status) == 'paid') {
                Session::flash("flash_message", "Your payment was completed successfully!");
            }
        }

        return Redirect::route('omnomcom::orders::list');
    }

    public function webhook($id)
    {
        $transaction = MollieTransaction::findOrFail($id);
        $transaction->updateFromWebhook();
        abort(200, "Mollie webhook processed correctly!");
    }
}
