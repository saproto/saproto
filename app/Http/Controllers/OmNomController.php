<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Auth;
use Proto\Models\ProductCategory;

class OmNomController extends Controller
{
    public function display(Request $request, $store = null)
    {
        $stores = config('omnomcom.stores');

        if (array_key_exists($store, $stores)) {

            $store = $stores[$store];

            if (!in_array($request->ip(), $store->addresses) && !Auth::user()->can($store->roles)) {
                abort(403);
            }

            $categories = [];

            foreach ($store->categories as $category) {
                $cat = ProductCategory::find($category);
                if ($cat) {
                    $prods = $cat->products;
                    $categories[] = (object)[
                        'category' => $cat,
                        'products' => $prods
                    ];
                }
            }

            return view('omnomcom.store.show', ['categories' => $categories]);

        } else {
            return view('omnomcom.store.pick', ['stores' => $stores]);
        }
    }
}
