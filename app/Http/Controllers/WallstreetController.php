<?php

namespace Proto\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Proto\Models\WallstreetDrink;
use Proto\Models\WallstreetPrice;
use Response;

class WallstreetController extends Controller
{
    public function admin()
    {
        $allDrinks = WallstreetDrink::query()->orderby('start_time', 'desc')->get();
        return view('wallstreet.admin', ['allDrinks' => $allDrinks, 'currentDrink'=>null]);
    }

    public function statistics($id)
    {
        return view('wallstreet.price-history', ['id'=>$id]);
    }

    public function swiper() {
        $activeDrink = WallstreetController::active();
        $prices = $this->getLatestPrices($activeDrink);
        return view('wallstreet.swiper', ['activeDrink' => $activeDrink, 'prices' => $prices]);
    }

    public function edit($id) {
        $currentDrink = WallstreetDrink::find($id);
        $allDrinks = WallstreetDrink::query()->orderby('start_time', 'desc')->get();
        return view('wallstreet.admin', ['allDrinks' => $allDrinks, 'currentDrink'=>$currentDrink]);
    }

    public function store(Request $request) {
        $drink = new WallstreetDrink();
        $drink->start_time = Carbon::parse($request->input('start_time'))->timestamp;
        $drink->end_time = Carbon::parse($request->input('end_time'))->timestamp;
        $drink->minimum_price = $request->input('minimum_price');
        $drink->price_increase = $request->input('price_increase');
        $drink->price_decrease = $request->input('price_decrease');
        $drink->save();

        $allDrinks = WallstreetDrink::query()->orderby('start_time', 'desc')->get();
        return view('wallstreet.admin', ['allDrinks' => $allDrinks, 'currentDrink'=>$drink]);
    }

    public function update(Request $request, $id) {
        $drink = WallstreetDrink::findOrFail($id);
        $drink->start_time = Carbon::parse($request->input('start_time'))->timestamp;
        $drink->end_time = Carbon::parse($request->input('end_time'))->timestamp;
        $drink->minimum_price = $request->input('minimum_price');
        $drink->price_increase = $request->input('price_increase');
        $drink->price_decrease = $request->input('price_decrease');
        $drink->save();

        $allDrinks = WallstreetDrink::query()->orderby('start_time', 'desc')->get();
        return view('wallstreet.admin', ['allDrinks' => $allDrinks, 'currentDrink'=>$drink]);
    }

    public function destroy($id) {
        $drink = WallstreetDrink::findOrFail($id);
        $drink->delete();

        $prices = WallstreetPrice::query()->where('drink_id', $id)->get();
        foreach ($prices as $price){
            $price->delete();
        }

        Session::flash('flash_message', 'Wallstreet drink and its affiliated price history deleted.');
        return Redirect::back();
    }

    public function close($id): RedirectResponse
    {
        $drink = WallstreetDrink::findOrFail($id);
        $drink->end_time = time();
        $drink->save();
        Session::flash('flash_message', 'Wallstreet drink closed.');
        return Redirect::back();
    }

    public function addProducts($id, Request $request) {
        $drink = WallstreetDrink::findOrFail($id);
        $products = $request->input('product');
        $products = array_unique($products);
        foreach ($products as $product){
            $drink->products()->syncWithoutDetaching($product);
        }
        Session::flash('flash_message', count($products).' Products added to Wallstreet drink.');
        return Redirect::back();
    }

    public function removeProduct($id, $productId) {
        $drink = WallstreetDrink::findOrFail($id);
        $drink->products()->detach($productId);
        Session::flash('flash_message', 'Product removed from Wallstreet drink.');
        return Redirect::back();
    }

    public static function active() {
        return WallstreetDrink::query()->where('start_time', '<=', time())->where('end_time', '>=', time())->first();
    }

    public function getLatestPrices($drink) {
        $products = $drink->products()->select('name','price', 'id', 'image_id')->get();
        foreach($products as $product) {
            $newPrice = WallstreetPrice::where('product_id', $product->id)->orderBy('id', 'desc')->first()->price ?? 0;
            $oldPrice = WallstreetPrice::where('product_id', $product->id)->orderBy('id', 'desc')->skip(1)->first()->price ?? 1;
            $product->price = $newPrice;
            $product->diff = ($newPrice - $oldPrice) / $oldPrice * 100;
            $product->img = is_null($product->image_url) ? '' : $product->image_url;
        }
        return $products;
    }

    public function getUpdatedPricesJSON($drinkID) {
        $drink = WallstreetDrink::findOrFail($drinkID);
        $prices = $this->getLatestPrices($drink);
        $wrapped = ['products' => $prices];
        return Response::json($wrapped);
    }

    public function getAllPrices($drinkID) {
        return WallstreetDrink::find($drinkID)->products()->with('wallstreetPrices', function ($q) use ($drinkID) {
            $q->where('wallstreet_drink_id', $drinkID)->orderBy('id', 'asc');
        })->select('id', 'image_id', 'name')->get();
    }
}
