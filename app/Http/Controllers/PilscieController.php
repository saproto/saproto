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

        foreach($pilscieProducts as $pilscieProduct) {
            $orders = $pilscieProduct->orderlines()
                ->where('created_at', '>=', ($date ? Carbon::parse($date)->addHours(6)->format('Y-m-d H:i:s') : Carbon::today()->format('Y-m-d H:i:s')))
                ->where('created_at', '<', ($date ? Carbon::parse($date)->addHours(30)->format('Y-m-d H:i:s') : Carbon::today()->format('Y-m-d H:i:s')))
                ->get();

            if(count($orders) > 0) {
                $pilscieOrders[$pilscieProduct->name] = 0;

                foreach($orders as $order) {
                    $pilscieOrders[$pilscieProduct->name]++;
                }
            }
        }

        return view('omnomcom.pilscie.orderhistory', ['orders' => $pilscieOrders, 'date' => $date]);
    }
}
