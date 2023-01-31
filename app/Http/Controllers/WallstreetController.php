<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Proto\Models\Product;
use Proto\Models\WallstreetDrink;
use Proto\Models\WallstreetPrice;

class WallstreetController extends Controller
{
    public function index()
    {
        $allDrinks = WallstreetDrink::query()->orderby('start_time', 'desc')->get();
        return view('wallstreet.admin', ['allDrinks' => $allDrinks, 'currentDrink'=>null]);
    }

    public function store(Request $request){
        $drink = new WallstreetDrink();
        $drink->start_time = $request->input('start_time');
        $drink->end_time = $request->input('end_time');
        $drink->minimum_price = $request->input('minimum_price');
        $drink->price_increase = $request->input('price_increase');
        $drink->price_decrease = $request->input('price_decrease');
        $drink->save();

        $allDrinks = WallstreetDrink::query()->orderby('start_time', 'desc')->get();
        return redirect()->route('wallstreet.admin', ['allDrinks' => $allDrinks, 'currentDrink'=>$drink]);
    }

    public function show($id){
        $currentDrinks = WallstreetDrink::where('start_time', '<=', time())->where('end_time', '>=', time())->get();
        $products = Product::where('does_wallstreet', true)->get();
        $latestPrices = WallstreetPrice::query()->whereIn('product_id', $products->pluck('id'))->orderBy('created_at', 'desc')->get();
        return view('wallstreet.index', ['currentDrinks' => $currentDrinks, 'products' => $products, 'latestPrices' => $latestPrices]);
    }
}
