<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\OrderLine;
use Proto\Models\RfidCard;
use Proto\Models\Product;

use Auth;
use Proto\Models\ProductCategory;

class OmNomController extends Controller
{
    public function display(Request $request, $store = null)
    {
        $stores = config('omnomcom.stores');

        if (array_key_exists($store, $stores)) {

            $storedata = $stores[$store];

            if (!in_array($request->ip(), $storedata->addresses) && (!Auth::check() || !Auth::user()->can($storedata->roles))) {
                abort(403);
            }

            $categories = [];

            foreach ($storedata->categories as $category) {
                $cat = ProductCategory::find($category);
                if ($cat) {
                    $prods = $cat->products;
                    $categories[] = (object)[
                        'category' => $cat,
                        'products' => $prods
                    ];
                }
            }

            return view('omnomcom.store.show', ['categories' => $categories, 'store' => $storedata, 'storeslug' => $store]);

        } else {
            return view('omnomcom.store.pick', ['stores' => $stores]);
        }
    }

    public function buy(Request $request, $store)
    {

        $stores = config('omnomcom.stores');

        if (array_key_exists($store, $stores)) {
            $storedata = $stores[$store];
            if (!in_array($request->ip(), $storedata->addresses) && !Auth::user()->can($storedata->roles)) {
                return "<span style='color: red;'>You are not authorized to do this.</span>";
            }
        } else {
            return "<span style='color: red;'>This store doesn't exist.</span>";
        }

        switch ($request->input('credentialtype')) {
            case 'account':
                $credentials = $request->input('credentials');
                $user = AuthController::verifyCredentials($credentials['username'], $credentials['password']);
                if (!$user) {
                    return "<span style='color: red;'>Invalid credentials.</span>";
                }
                break;

            case'card':
                $card = RfidCard::where('card_id', $request->input('credentials'))->first();
                if (!$card) {
                    return "<span style='color: red;'>Unknown card.</span>";
                }
                $card->touch();
                $user = $card->user;
                if (!$user) {
                    return "<span style='color: red;'>Unknown user.</span>";
                }
                break;

            default:
                return "<span style='color: red;'>Invalid credential type.</span>";
                break;
        }

        if (!$user->member) {
            return "<span style='color: red;'>Only members can use the OmNomCom.</span>";
        }

        $withCash = $request->input('cash');

        if ($withCash == "true" && !$storedata->cash_allowed) {
            return "<span style='color: red;'>You cannot use cash in this store.</span>";
        }

        $cart = $request->input('cart');

        foreach ($cart as $id => $amount) {
            if ($amount > 0) {
                $product = Product::find($id);
                if (!$product) {
                    return "<span style='color: red;'>You tried to buy a product that didn't exist!</span>";
                }
                if (!$product->isVisible()) {
                    return "<span style='color: red;'>You tried to buy a product that is not available!</span>";
                }
                if ($product->stock < $amount) {
                    return "<span style='color: red;'>You tried to buy more of a product than was in stock!</span>";
                }
                if ($product->is_alcoholic && $user->age() < 18) {
                    return "<span style='color: red;'>You tried to buy alcohol, youngster!</span>";
                }
            }
        }

        foreach ($cart as $id => $amount) {
            if ($amount > 0) {
                $product = Product::find($id);

                $orderline = OrderLine::create([
                    'user_id' => ($withCash == "true" ? null : $user->id),
                    'cashier_id' => ($withCash == "true" ? $user->id : null),
                    'product_id' => $product->id,
                    'original_unit_price' => $product->price,
                    'units' => $amount,
                    'total_price' => $amount * $product->price,
                    'payed_with_cash' => ($withCash == "true" ? date('Y-m-d H:i:s') : null)
                ]);
                $orderline->save();

                $product->stock -= $amount;
                $product->save();
            }
        }

        return "OK";

    }

    public function generateOrder()
    {

        $products = Product::where('is_visible_when_no_stock', true)->whereRaw('stock < preferred_stock')->orderBy('name', 'ASC')->get();
        return view('omnomcom.products.generateorder', ['products' => $products]);
    }

    public function miniSite() {
        return view('omnomcom.minisite');
    }
}
