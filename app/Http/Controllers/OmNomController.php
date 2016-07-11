<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\RfidCard;

use Auth;
use Proto\Models\ProductCategory;

class OmNomController extends Controller
{
    public function display(Request $request, $store = null)
    {
        $stores = config('omnomcom.stores');

        if (array_key_exists($store, $stores)) {

            $storedata = $stores[$store];

            if (!in_array($request->ip(), $storedata->addresses) && !Auth::user()->can($storedata->roles)) {
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

            return view('omnomcom.store.show', ['categories' => $categories, 'store' => $store]);

        } else {
            return view('omnomcom.store.pick', ['stores' => $stores]);
        }
    }

    public function buy(Request $request, $store)
    {

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
            return "<span style='color: red;'>You must be a member to use the OmNomCom.</span>";
        }

        return "<span style='color: orange;'>Work in progress...</span>";

    }
}
