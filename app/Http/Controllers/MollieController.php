<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;
use Proto\Models\OrderLine;
use Proto\Models\MollieTransaction;

use Auth;
use Mollie;
use Redirect;
use Session;

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

        $fee_orderline = OrderLine::create([
            'user_id' => Auth::id(),
            'product_id' => config('omnomcom.mollie')['fee_id'],
            'original_unit_price' => 0,
            'units' => 1,
            'total_price' => $fee,
            'payed_with_mollie' => $transaction->id
        ]);

        $fee_orderline->save();

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
        if ($transaction->user->id != Auth::id() && Auth::user()->can('board')) {
            abort(403, "You are unauthorized to view this transcation.");
        }
        $transaction = $transaction->updateFromWebhook();
        return view('omnomcom.mollie.status', ['transaction' => $transaction, 'mollie' => Mollie::api()->payments()->get($transaction->mollie_id)]);
    }

    public function index()
    {
        return view('omnomcom.mollie.list', ['transactions' => MollieTransaction::orderBy('updated_at', 'desc')->get()]);
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
