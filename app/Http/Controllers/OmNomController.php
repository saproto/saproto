<?php

namespace Proto\Http\Controllers;

use Auth;
use DB;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Proto\App\Services\ProTubeApiService;
use Proto\Models\OrderLine;
use Proto\Models\Product;
use Proto\Models\ProductCategory;
use Proto\Models\QrAuthRequest;
use Proto\Models\RfidCard;
use Proto\Models\User;
use stdClass;

class OmNomController extends Controller
{
    /**
     * @param Request $request
     * @param string|null $store_slug
     * @return RedirectResponse|View
     */
    public function display(Request $request, $store_slug = null)
    {
        if (! array_key_exists($store_slug, config('omnomcom.stores'))) {
            Session::flash('flash_message', 'This store does not exist. Please check the URL.');
            return Redirect::route('homepage');
        }

        $store = config('omnomcom.stores')[$store_slug];

        if (! in_array($request->ip(), $store->addresses) && (! Auth::check() || ! Auth::user()->hasAnyPermission($store->roles))) {
            abort(403);
        }

        $categories = $this->getCategories($store);

        if ($store_slug == 'tipcie') {
            $minors = User::query()
                ->where('birthdate', '>', date('Y-m-d', strtotime('-18 years')))
                ->has('member')
                ->get()
                ->reject(function (User $user, int $index) {
                    return $user->member->is_pending || $user->member->is_pet;
                });
        } else {
            $minors = collect([]);
        }

        return view('omnomcom.store.show', ['categories' => $categories, 'store' => $store, 'store_slug' => $store_slug, 'minors' => $minors]);
    }

    /** @return View */
    public function choose()
    {
        return view('omnomcom.choose');
    }

    /** @return View */
    public function miniSite()
    {
        return view('omnomcom.minisite');
    }

    /**
     * @param Request $request
     * @return string
     */
    public function stock(Request $request)
    {
        if (! array_key_exists($request->store, config('omnomcom.stores'))) {
            abort(404);
        }

        $store = config('omnomcom.stores')[$request->store];

        if (! in_array($request->ip(), $store->addresses) && (! Auth::check() || ! Auth::user()->hasAnyPermission($store->roles))) {
            abort(403);
        }

        $categories = $this->getCategories($store);

        $products = [];
        foreach($categories as $category) {
            /** @var Product $product */
            foreach($category->products as $product) {
                if ($product->isVisible()) {
                    if($product->image) {
                        /* @phpstan-ignore-next-line  */
                        $product->image_url = $product->image->generateImagePath(100, null);
                    }
                    $products[] = $product;
                }
            }
        }
        return json_encode($products);
    }

    /**
     * @param Request $request
     * @param string $store_slug
     * @return string
     * @throws Exception
     */
    public function buy(Request $request, $store_slug)
    {
        $stores = config('omnomcom.stores');
        $result = new stdClass();
        $result->status = 'ERROR';

        if (array_key_exists($store_slug, $stores)) {
            $store = $stores[$store_slug];
            if (! in_array($request->ip(), $store->addresses) && ! Auth::user()->hasAnyPermission($store->roles)) {
                $result->message = 'You are not authorized to do this.';
                return json_encode($result);
            }
        } else {
            $result->message = "This store doesn't exist.";
            return json_encode($result);
        }

        switch ($request->input('credential_type')) {
            case 'card':
                $auth_method = sprintf('omnomcom_rfid_%s', $request->input('credentials'));
                $card = RfidCard::where('card_id', $request->input('credentials'))->first();
                if (! $card) {
                    $result->message = 'Unknown card.';
                    return json_encode($result);
                }
                $card->touch();
                $user = $card->user;
                if (! $user) {
                    $result->message = 'Unknown user.';
                    return json_encode($result);
                }
                break;

            case 'qr':
                $qrAuthRequest = QrAuthRequest::where('auth_token', $request->input('credentials'))->first();
                $auth_method = sprintf('omnomcom_qr_%u', $qrAuthRequest->id);
                if (! $qrAuthRequest) {
                    $result->message = 'Invalid authentication token.';
                    return json_encode($result);
                }

                $user = $qrAuthRequest->authUser();
                if (! $user) {
                    $result->message = "QR authentication hasn't been completed.";
                    return json_encode($result);
                }
                break;

            default:
                $result->message = 'Invalid credential type.';
                return json_encode($result);
        }

        if (! $user->is_member) {
            $result->message = 'Only members can use the OmNomCom.';
            return json_encode($result);
        }

        if($user->member->customOmnomcomSound) {
            $result->sound = $user->member->customOmnomcomSound->generatePath();
        }

        if ($user->disable_omnomcom) {
            $result->message = "You've disabled the OmNomCom for yourself. Contact the board to enable it again.";
            return json_encode($result);
        }

        $payedCash = $request->input('cash');
        $payedCard = $request->input('bank_card');

        if ($payedCash && ! $store->cash_allowed) {
            $result->message = 'You cannot use cash in this store.';
            return json_encode($result);
        }

        if ($payedCard && ! $store->bank_card_allowed) {
            $result->message = 'You cannot use a bank card in this store.';
            return json_encode($result);
        }

        $cart = $request->input('cart');

        foreach ($cart as $id => $amount) {
            if ($amount > 0) {
                $product = Product::find($id);
                if (! $product) {
                    $result->message = "You tried to buy a product that didn't exist!";
                    return json_encode($result);
                }
                if (! $product->isVisible()) {
                    $result->message = 'You tried to buy a product that is not available!';
                    return json_encode($result);
                }
                if ($product->stock < $amount) {
                    $result->message = 'You tried to buy more of a product than was in stock!';
                    return json_encode($result);
                }
                if ($product->is_alcoholic && $user->age() < 18) {
                    $result->message = 'You tried to buy alcohol, youngster!';
                    return json_encode($result);
                }
                if ($product->is_alcoholic && $store->alcohol_time_constraint && ! (date('Hi') > str_replace(':', '', config('omnomcom.alcohol-start')) || date('Hi') < str_replace(':', '', config('omnomcom.alcohol-end')))) {
                    $result->message = "You can't buy alcohol at the moment; alcohol can only be bought between ".config('omnomcom.alcohol-start').' and '.config('omnomcom.alcohol-end').'.';
                    return json_encode($result);
                }
            }
        }

        foreach ($cart as $id => $amount) {
            if ($amount > 0) {
                $product = Product::find($id);
                // ProTube skip song
                if ($product->id == config('omnomcom.protube-skip')) {
                    $skipped = ProTubeApiService::skipSong();
                    if (!$skipped) continue;
                }

                $product->buyForUser($user, $amount, $amount * $product->omnomcomPrice(), $payedCash == 'true', $payedCard == 'true', null, $auth_method);
            }
        }

        if (! isset($result->message)) {
            $result->status = 'OK';
            $result->message = '';

            if ($user->show_omnomcom_total) {
                $result->message = sprintf('You have spent a total of <strong>€%0.2f</strong>', OrderLine::where('user_id', $user->id)->where('created_at', 'LIKE', sprintf('%s %%', date('Y-m-d')))->sum('total_price'));
            }

            if ($user->show_omnomcom_calories) {
                $result->message .= $user->show_omnomcom_total ? '<br>and ' : 'You have ';
                $result->message .= sprintf('bought a total of <strong>%s calories</strong>', Orderline::where('orderlines.user_id', $user->id)->where('orderlines.created_at', 'LIKE', sprintf('%s %%', date('Y-m-d')))->join('products', 'products.id', '=', 'orderlines.product_id')->sum(DB::raw('orderlines.units * products.calories')));
            }

            if(strlen($result->message) > 0) {
                $result->message .= sprintf(' today, %s.', $user->calling_name);
            }
            
            $cartTotal = 0;
            foreach ($cart as $id => $amount) {
                $product = Product::find($id);
                if($product) {
                    $cartTotal += $product->price * $amount;
                }
            }
            $soccerCards = floor($cartTotal / 0.5);
            if($soccerCards > 0) {
                if($soccerCards > 12) {
                    $soccerCards = 12;
                }
                $result->message .= sprintf('<br><br> You may take <strong>%s</strong> soccer card%s!', $soccerCards, $soccerCards > 1 ? 's' : '');
            }
        }

        return json_encode($result);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function generateOrder(Request $request)
    {
        $products = Product::where('is_visible_when_no_stock', true)->whereRaw('stock < preferred_stock')->orderBy('name', 'ASC')->get();
        $orders = [];
        foreach ($products as $product) {
            $order_collo = ($product->supplier_collo > 0 ? ceil(($product->preferred_stock - $product->stock) / $product->supplier_collo) : 0);
            $order_products = $order_collo * $product->supplier_collo;
            $new_stock = $product->stock + $order_products;
            $new_surplus = $new_stock - $product->preferred_stock;

            $orders[] = (object) [
                'product' => $product,
                'order_collo' => $order_collo,
                'order_products' => $order_products,
                'new_stock' => $new_stock,
                'new_surplus' => $new_surplus,
            ];
        }

        if ($request->has('csv')) {
            return view('omnomcom.products.generateorder_csv', ['orders' => $orders]);
        } else {
            return view('omnomcom.products.generateorder', ['orders' => $orders]);
        }
    }

    private function getCategories($store)
    {
        $categories = [];
        foreach ($store->categories as $category) {
            $cat = ProductCategory::find($category);
            if ($cat) {
                $prods = $cat->products();
                $categories[] = (object) [
                    'category' => $cat,
                    'products' => $prods,
                ];
            }
        }
        return $categories;
    }
}
