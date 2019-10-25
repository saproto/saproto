<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Carbon;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\Account;
use Proto\Models\OrderLine;

class TIPCieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderIndex(Request $request)
    {
        $date = $request->has('date') ? $request->date : null;

        $tipcieProducts = Account::find(config('omnomcom.tipcie-account'))->products;

        $tipcieOrders = [];

        $dailyAmount = 0;
        $dailyTotal = 0;

        foreach($tipcieProducts as $tipcieProduct) {
            $orders = $tipcieProduct->orderlines()
                ->where('created_at', '>=', ($date ? Carbon::parse($date)->addHours(6)->format('Y-m-d H:i:s') : Carbon::today()->format('Y-m-d H:i:s')))
                ->where('created_at', '<', ($date ? Carbon::parse($date)->addHours(30)->format('Y-m-d H:i:s') : Carbon::today()->format('Y-m-d H:i:s')))
                ->get();

            if(count($orders) > 0) {
                $productInfo = new \stdClass();

                $productInfo->name = $tipcieProduct->name;
                $productInfo->amount = 0;
                $productInfo->totalPrice = 0;

                foreach($orders as $order) {
                    $productInfo->amount += $order->units;
                    $productInfo->totalPrice += $order->total_price;
                }

                $dailyAmount += $productInfo->amount;
                $dailyTotal += $productInfo->totalPrice;
                $tipcieOrders[] = $productInfo;
            }
        }

        $pinOrders = [];
        $pinTotal = 0;

        $orders = OrderLine::where('created_at', '>=', ($date ? Carbon::parse($date)->addHours(6)->format('Y-m-d H:i:s') : Carbon::today()->format('Y-m-d H:i:s')))
            ->where('created_at', '<', ($date ? Carbon::parse($date)->addHours(30)->format('Y-m-d H:i:s') : Carbon::today()->format('Y-m-d H:i:s')))
            ->get();

        foreach ($orders as $order) {
            if ($order->payed_with_bank_card) {
                $time = (string) $order->created_at;
                if (!array_key_exists($time, $pinOrders)) {
                    $pinOrders[$time] = 0;
                }
                $pinOrders[$time] += $order->total_price;
                $pinTotal += $order->total_price;
            }
        }

        return view('omnomcom.tipcie.orderhistory', ['orders' => $tipcieOrders, 'date' => $date, 'dailyTotal' => $dailyTotal, 'dailyAmount' => $dailyAmount, 'pinOrders' => $pinOrders, 'pinTotal' => $pinTotal]);
    }
}
