<?php

namespace Proto\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Proto\Models\Product;
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
        return view('wallstreet.index', ['id'=>$id]);
    }

    public function edit($id){
        $currentDrink = WallstreetDrink::find($id);
        $allDrinks = WallstreetDrink::query()->orderby('start_time', 'desc')->get();
        return view('wallstreet.admin', ['allDrinks' => $allDrinks, 'currentDrink'=>$currentDrink]);
    }

    public function store(Request $request){
        $drink = new WallstreetDrink();
        $drink->start_time = Carbon::parse($request->input('start_time'))->timestamp;
        $drink->end_time = Carbon::parse($request->input('end_time'))->timestamp;
        $drink->minimum_price = $request->input('minimum_price');
        $drink->price_increase = $request->input('price_increase');
        $drink->price_decrease = $request->input('price_decrease');
        $drink->save();

        $allDrinks = WallstreetDrink::query()->orderby('start_time', 'desc')->get();
        return redirect()->route('wallstreet.admin', ['allDrinks' => $allDrinks, 'currentDrink'=>$drink]);
    }

    public function update(Request $request, $id){
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

    public function destroy($id){
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

    public static function active(){
        $activeDrink = WallstreetDrink::query()->where('start_time', '<=', time())->where('end_time', '>=', time())->first();
        if($activeDrink){
            return true;
        }
        return false;
    }

    public function getUpdatedPrices(){
        $products= Product::query()->where('does_wallstreet', true)->select(['id', 'name'])->get();
        foreach($products as $product) {
            $newPrice=WallstreetPrice::where('product_id', $product->id)->orderBy('created_at', 'desc')->first()->price;
            $product->price= $newPrice;
            $product->diff= $newPrice - WallstreetPrice::where('product_id', $product->id)->orderBy('created_at', 'desc')->skip(1)->first()->price;

            if($product->image) {
                /* @phpstan-ignore-next-line  */
                $product->image_url = $product->image->generateImagePath(100, null);
            }
        }
        $json = array('products' => $products);
        return Response::json($json);
    }

    public function getAllPrices($drinkID){
        $prices = WallstreetPrice::query()->where('wallstreet_drink_id', $drinkID)->select(['product_id', 'price', 'created_at'])->get()->groupBy('product_id');
        return $prices;
    }
}
