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

class MollieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pay(Request $request)
    {
        $cap = floatval($request->cap);
        $total = 0;

        $transaction = MollieTransaction::create([
            'user_id' => Auth::id(),
            'mollie_id' => 'temp',
            'status' => 'draft'
        ]);

        foreach (OrderLine::where('user_id', Auth::id())->whereNull('payed_with_cash')->whereNull('payed_with_mollie')->whereNull('payed_with_withdrawal')->orderBy('created_at', 'asc')->get() as $orderline) {
            if ($orderline->total_price < 0) {
                continue;
            }
            if ($total + $orderline->total_price > $cap) {
                break;
            }
            $total += $orderline->total_price;
            $orderline->payed_with_mollie = $transaction->id;
            $orderline->save();
        }

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
            "description" => "Outstanding Balance (€" . number_format($total, 2) . ") + Fee (€" . number_format($fee, 2) . ")",
            "redirectUrl" => route('omnomcom::mollie::status', ['id' => $transaction->id]),
        ]);

        $transaction->mollie_id = $mollie->id;
        $transaction->save();

        return Redirect::to($mollie->getPaymentUrl());

    }
}
