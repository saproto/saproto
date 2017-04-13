<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Carbon;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\Account;

class PilscieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderIndex(Request $request)
    {
        $date = $request->has('date') ? $request->date : null;

        $pilscieProducts = Account::find(config('omnomcom.pilscie-account'))->products;

        $pilscieOrders = [];

        $dailyAmount = 0;
        $dailyTotal = 0;

        foreach($pilscieProducts as $pilscieProduct) {
            $orders = $pilscieProduct->orderlines()
                ->where('created_at', '>=', ($date ? Carbon::parse($date)->addHours(6)->format('Y-m-d H:i:s') : Carbon::today()->format('Y-m-d H:i:s')))
                ->where('created_at', '<', ($date ? Carbon::parse($date)->addHours(30)->format('Y-m-d H:i:s') : Carbon::today()->format('Y-m-d H:i:s')))
                ->get();

            if(count($orders) > 0) {
                $productInfo = new \stdClass();

                $productInfo->name = $pilscieProduct->name;
                $productInfo->amount = 0;
                $productInfo->totalPrice = 0;

                foreach($orders as $order) {
                    $productInfo->amount += $order->units;
                    $productInfo->totalPrice += $order->total_price;
                }

                $dailyAmount += $productInfo->amount;
                $dailyTotal += $productInfo->totalPrice;
                $pilscieOrders[] = $productInfo;
            }
        }

        return view('omnomcom.pilscie.orderhistory', ['orders' => $pilscieOrders, 'date' => $date, 'dailyTotal' => $dailyTotal, 'dailyAmount' => $dailyAmount]);
    }
}
