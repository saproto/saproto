<?php

namespace App\Http\Controllers;

use App\Enums\MembershipTypeEnum;
use App\Models\OrderLine;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\QrAuthRequest;
use App\Models\RfidCard;
use App\Models\User;
use App\Services\ProTubeApiService;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use stdClass;

class OmNomController extends Controller
{
    public function display(Request $request, ?string $store_slug = null): View|RedirectResponse
    {
        if (empty($store_slug) && Auth::user()?->canAny(collect(Config::array('omnomcom.stores'))->pluck('roles')->flatten())) {
            return view('omnomcom.choose');
        }

        if (! array_key_exists($store_slug, Config::array('omnomcom.stores'))) {
            Session::flash('flash_message', 'This store does not exist. Please check the URL.');

            return Redirect::route('homepage');
        }

        $store = Config::array('omnomcom.stores')[$store_slug];

        if (! in_array($request->ip(), $store['addresses']) && (! Auth::check() || ! Auth::user()->hasAnyPermission($store['roles']))) {
            abort(403);
        }

        $categories = ProductCategory::query()->whereIn('id', $store['categories'])->with('sortedProducts.media')->get();
        $minors = collect();

        if ($store_slug === 'tipcie') {
            $minors = User::query()
                ->where('birthdate', '>', Carbon::now()->subYears(18)->format('Y-m-d'))
                ->whereHas('member', static function ($q) {
                    $q->whereNot('membership_type', MembershipTypeEnum::PENDING)->whereNot('membership_type', MembershipTypeEnum::PET);
                })
                ->with('media')
                ->get();
        }

        return view('omnomcom.store.show', ['categories' => $categories, 'store' => $store, 'store_slug' => $store_slug, 'minors' => $minors]);
    }

    /** @return View */
    public function miniSite(): \Illuminate\Contracts\View\View|Factory
    {
        $products = Cache::remember('omnomcom.minisite', 60, fn () => Product::query()->where('is_visible', true)
            ->where(function ($query) {
                $query
                    ->where('is_visible_when_no_stock', true)
                    ->orWhere('stock', '>', 0);
            })
            ->whereHas('categories', function ($query) {
                $query->whereIn(
                    'product_categories.id',
                    Config::array(
                        'omnomcom.stores.protopolis.categories'
                    )
                );
            })
            ->with('media')
            ->with('categories')
            ->get());

        return view('omnomcom.minisite', ['products' => $products]);
    }

    /**
     * @return string
     */
    public function stock(Request $request)
    {
        $stores = Config::array('omnomcom.stores');
        if (! array_key_exists($request->store, $stores)) {
            abort(404);
        }

        $store = $stores[$request->store];

        if (! in_array($request->ip(), $store['addresses']) && (! Auth::check() || ! Auth::user()->hasAnyPermission($store['roles']))) {
            abort(403);
        }

        $categories = ProductCategory::query()->whereIn('id', $store['categories'])->with('sortedProducts.media')->get();

        $products = [];
        foreach ($categories as $category) {
            /** @var Product $product */
            foreach ($category->sortedProducts as $product) {
                if ($product->isVisible()) {
                    $products[] = $product;
                }
            }
        }

        return json_encode($products);
    }

    /**
     * @return string
     *
     * @throws Exception
     */
    public function buy(Request $request, string $store_slug)
    {
        $stores = Config::array('omnomcom.stores');
        $result = new stdClass;
        $result->status = 'ERROR';

        if (array_key_exists($store_slug, $stores)) {
            $store = $stores[$store_slug];
            if (! in_array($request->ip(), $store['addresses']) && ! Auth::user()->hasAnyPermission($store['roles'])) {
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
                $card = RfidCard::query()->where('card_id', $request->input('credentials'))->first();
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
                $qrAuthRequest = QrAuthRequest::query()->where('auth_token', $request->input('credentials'))->first();
                if (! $qrAuthRequest) {
                    $result->message = 'Invalid authentication token.';

                    return json_encode($result);
                }

                $auth_method = sprintf('omnomcom_qr_%u', $qrAuthRequest->id);

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

        if ($user->member->hasMedia('omnomcom_sound')) {
            $result->sound = $user->member->getFirstMediaUrl('omnomcom_sound');
        }

        if ($user->disable_omnomcom) {
            $result->message = "You've disabled the OmNomCom for yourself. Contact the board to enable it again.";

            return json_encode($result);
        }

        $payedCash = $request->input('cash');
        $payedCard = $request->input('bank_card');

        if ($payedCash && ! $store['cash_allowed']) {
            $result->message = 'You cannot use cash in this store.';

            return json_encode($result);
        }

        if ($payedCard && ! $store['bank_card_allowed']) {
            $result->message = 'You cannot use a bank card in this store.';

            return json_encode($result);
        }

        $cart = $request->input('cart');

        foreach ($cart as $id => $amount) {
            if ($amount > 0) {
                $product = Product::query()->find($id);
                if (! $product) {
                    $result->message = "You tried to buy a product that didn't exist!";

                    return json_encode($result);
                }

                /** @var Product $product */
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

                if ($product->is_alcoholic && $store['alcohol_time_constraint']) {
                    $alcoholStart = Carbon::today()->setTime(Config::integer('omnomcom.alcohol-start-hour'), 0);
                    $alcoholEnd = Carbon::today()->setTime(Config::integer('omnomcom.alcohol-end-hour'), 0)->addDay(); // add a day to fix the slot going over 00:00
                    if (! Carbon::now()->between($alcoholStart, $alcoholEnd)) {
                        $result->message = "You can't buy alcohol at the moment! Come back between {$alcoholStart->format('H:i')} and {$alcoholEnd->format('H:i')}.";

                        return json_encode($result);
                    }
                }
            }
        }

        foreach ($cart as $id => $amount) {
            if ($amount > 0) {
                $product = Product::query()->find($id);

                if ($product->id == Config::integer('omnomcom.protube-skip')) {
                    $skipped = ProTubeApiService::skipSong();
                    if (! $skipped) {
                        continue;
                    }
                }

                $product->buyForUser($user, $amount, $amount * $product->omnomcomPrice(), $payedCash == 'true', $payedCard == 'true', null, $auth_method);
            }
        }

        if (! isset($result->message)) {
            $result->status = 'OK';
            $result->message = '';

            if ($user->show_omnomcom_total) {
                $categories = collect($stores)->pluck('categories')->flatten()->unique();

                $totalSpent = OrderLine::query()
                    ->where('user_id', $user->id)
                    ->where('created_at', 'LIKE', sprintf('%s %%', Carbon::now()->format('Y-m-d')))
                    ->whereHas('product.categories', function ($query) use ($categories) {
                        $query->whereIn('product_categories.id', $categories);
                    })
                    ->sum('total_price');

                $result->message = sprintf(
                    'You have spent a total of <strong>€%0.2f</strong>',
                    $totalSpent
                );
            }

            if ($user->show_omnomcom_calories) {
                $result->message .= $user->show_omnomcom_total ? '<br>and ' : 'You have ';
                $result->message .= sprintf('bought a total of <strong>%s calories</strong>', OrderLine::query()->where('orderlines.user_id', $user->id)->where('orderlines.created_at', 'LIKE', sprintf('%s %%', Carbon::now()->format('Y-m-d')))->join('products', 'products.id', '=', 'orderlines.product_id')->sum(DB::raw('orderlines.units * products.calories')));
            }

            if (strlen($result->message) > 0) {
                $result->message .= sprintf(' today, %s.', $user->calling_name);
            }
        }

        return json_encode($result);
    }

    /**
     * @return View
     */
    public function generateOrder(Request $request): \Illuminate\Contracts\View\View|Factory
    {
        $products = Product::query()->where('is_visible_when_no_stock', true)->whereRaw('stock < preferred_stock')->orderBy('name', 'ASC')->get();
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
        }

        return view('omnomcom.products.generateorder', ['orders' => $orders]);
    }
}
