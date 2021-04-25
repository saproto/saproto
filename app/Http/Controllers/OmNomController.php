<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\OrderLine;
use Proto\Models\RfidCard;
use Proto\Models\Product;
use Proto\Models\User;
use Proto\Models\QrAuthRequest;

use Auth;
use Proto\Models\ProductCategory;
use DB;


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
                    $prods = $cat->products();
                    $categories[] = (object)[
                        'category' => $cat,
                        'products' => $prods
                    ];
                }
            }

            if ($store == 'tipcie') {
                $minors = User::where('birthdate', '>', date('Y-m-d', strtotime('-18 years')))->has('member')->get()->reject(function($user, $index) { return $user->member->is_pending == true; });
            } else {
                $minors = collect([]);
            }

            return view('omnomcom.store.show', ['categories' => $categories, 'store' => $storedata, 'storeslug' => $store, 'minors' => $minors]);

        } else {
            Session::flash('flash_message', 'This store does not exist. Please check the URL.');
            return Redirect::route('homepage');
        }
    }

    public function buy(Request $request, $store)
    {

        $stores = config('omnomcom.stores');

        $result = new \stdClass();
        $result->status = "ERROR";

        if (array_key_exists($store, $stores)) {
            $storedata = $stores[$store];
            if (!in_array($request->ip(), $storedata->addresses) && !Auth::user()->can($storedata->roles)) {
                $result->message = "<span style='color: red;'>You are not authorized to do this.</span>";
            }
        } else {
            $result->message = "<span style='color: red;'>This store doesn't exist.</span>";
        }

        switch ($request->input('credentialtype')) {
            case 'card':
                $auth_method = sprintf('omnomcom_rfid_%s', $request->input('credentials'));
                $card = RfidCard::where('card_id', $request->input('credentials'))->first();
                if (!$card) {
                    $result->message = "<span style='color: red;'>Unknown card.</span>";
                    return json_encode($result);
                }
                $card->touch();
                $user = $card->user;
                if (!$user) {
                    $result->message = "<span style='color: red;'>Unknown user.</span>";
                    return json_encode($result);
                }
                break;

            case 'qr':
                $qrAuthRequest = QrAuthRequest::where('auth_token', $request->input('credentials'))->first();
                $auth_method = sprintf('omnomcom_qr_%u', $qrAuthRequest->id);
                if (!$qrAuthRequest) {
                    $result->message = "<span style='color: red;'>Invalid authentication token.</span>";
                    return json_encode($result);
                }

                $user = $qrAuthRequest->authUser();
                if (!$user) {
                    $result->message = "<span style='color: red;'>QR authentication hasn't been completed.</span>";
                    return json_encode($result);
                }
                break;

            default:
                $result->message = "<span style='color: red;'>Invalid credential type.</span>";
                break;
        }

        if (!$user->is_member) {
            $result->message = "<span style='color: red;'>Only members can use the OmNomCom.</span>";
            return json_encode($result);
        }

        if ($user->disable_omnomcom) {
            $result->message = "<span style='color: orange;'>You've disabled the OmNomCom for yourself. Contact the board to enable it again.</span>";
            return json_encode($result);
        }

        $withCash = $request->input('cash');
        $withBankCard = $request->input('bank_card');

        if ($withCash == "true" && !$storedata->cash_allowed) {
            $result->message = "<span style='color: red;'>You cannot use cash in this store.</span>";
            return json_encode($result);
        }

        if ($withBankCard == "true" && !$storedata->bank_card_allowed) {
            $result->message = "<span style='color: red;'>You cannot use a bank card in this store.</span>";
            return json_encode($result);
        }

        $cart = $request->input('cart');

        foreach ($cart as $id => $amount) {
            if ($amount > 0) {
                $product = Product::find($id);
                if (!$product) {
                    $result->message = "<span style='color: red;'>You tried to buy a product that didn't exist!</span>";
                    return json_encode($result);
                }
                if (!$product->isVisible()) {
                    $result->message = "<span style='color: red;'>You tried to buy a product that is not available!</span>";
                    return json_encode($result);
                }
                if ($product->stock < $amount) {
                    $result->message = "<span style='color: red;'>You tried to buy more of a product than was in stock!</span>";
                    return json_encode($result);
                }
                if ($product->is_alcoholic && $user->age() < 18) {
                    $result->message = "<span style='color: red;'>You tried to buy alcohol, youngster!</span>";
                    return json_encode($result);
                }

                if ($product->is_alcoholic && $stores[$store]->alcohol_time_constraint && !(date('Hi') > str_replace(':', '', config('omnomcom.alcohol-start')) || date('Hi') < str_replace(':', '', config('omnomcom.alcohol-end')))) {
                    $result->message = "<span style='color: red;'>You can't buy alcohol at the moment; alcohol can only be bought between " . config('omnomcom.alcohol-start') . " and " . config('omnomcom.alcohol-end') . ".</span>";
                    return json_encode($result);
                }
            }
        }

        foreach ($cart as $id => $amount) {
            if ($amount > 0) {
                $product = Product::find($id);
                $product->buyForUser($user, $amount, $amount * $product->price, ($withCash == "true" ? true : false), ($withBankCard == "true" ? true : false), null, $auth_method);
                if ($product->id == config('omnomcom.protube-skip')) {
                    file_get_contents(config('herbert.server') . "/skip?secret=" . config('herbert.secret'));
                }
            }
        }

        if (!isset($result->message)) {


            $result->status = "OK";

            if ($user->show_omnomcom_total) {
                if (!isset($result->message)) $result->message = "";
                $result->message .= sprintf("You have spent a total of <strong>€%0.2f</strong>", OrderLine::where('user_id', $user->id)->where('created_at', 'LIKE', sprintf("%s %%", date('Y-m-d')))->sum('total_price'));
            }

            if ($user->show_omnomcom_calories) {
                if (!isset($result->message)) $result->message = "";
                if ($user->show_omnomcom_total) {
                    $result->message .= "<br>and ";
                } else {
                    $result->message .= "You have ";
                }
                $result->message .= sprintf("bought a total of <strong>%s calories</strong>", Orderline::where('orderlines.user_id', $user->id)->where('orderlines.created_at', 'LIKE', sprintf("%s %%", date('Y-m-d')))->join('products', 'products.id', '=', 'orderlines.product_id')->sum(DB::raw('orderlines.units * products.calories')));
            }

            if (isset($result->message)) $result->message .= sprintf(" today, %s.", $user->calling_name);
        }

        return json_encode($result);

    }

    public function generateOrder(Request $request)
    {

        $products = Product::where('is_visible_when_no_stock', true)->whereRaw('stock < preferred_stock')->orderBy('name', 'ASC')->get();
        $orders = [];
        foreach ($products as $product) {
            $order_collo = ($product->supplier_collo > 0 ? ceil(($product->preferred_stock - $product->stock) / $product->supplier_collo) : 0);
            $order_products = $order_collo * $product->supplier_collo;
            $new_stock = $product->stock + $order_products;
            $new_surplus = $new_stock - $product->preferred_stock;

            $orders[] = (object)[
                'product' => $product,
                'order_collo' => $order_collo,
                'order_products' => $order_products,
                'new_stock' => $new_stock,
                'new_surplus' => $new_surplus
            ];
        }

        if ($request->has('csv')) {
            return view('omnomcom.products.generateorder_csv', ['orders' => $orders]);
        } else {
            return view('omnomcom.products.generateorder', ['orders' => $orders]);
        }
    }

    public function choose()
    {
        return view('omnomcom.choose');
    }

    public function miniSite()
    {
        return view('omnomcom.minisite');
    }
}
