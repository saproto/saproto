<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Carbon;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\ProductCategory;

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

        $pilscieCategories = ProductCategory::whereIn('id', config('omnomcom.pilscie-categories'))->get();

        $pilscieProducts = [];

        foreach($pilscieCategories as $pilscieCategory) {
            foreach($pilscieCategory->products as $pilscieProduct) {
                array_push($pilscieProducts, $pilscieProduct);
            }
        }

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
