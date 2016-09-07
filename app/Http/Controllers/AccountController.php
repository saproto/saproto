<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Models\Account;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\Product;
use Proto\Models\OrderLine;

use Redirect;
use Carbon\Carbon;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('omnomcom.accounts.index', ['accounts' => Account::orderBy('account_number', 'asc')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('omnomcom.accounts.edit', ['account' => null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $account = Account::create($request->all());
        $account->save();

        $request->session()->flash('flash_message', 'Account ' . $account->account_number . ' (' . $account->name . ') created.');

        return Redirect::route('omnomcom::accounts::list');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $account = Account::findOrFail($id);
        return view('omnomcom.accounts.show', ['account' => $account, 'products' => Product::where('account_id', $account->id)->paginate(30)]);
    }

    /**
     * Display aggregated results of sales. Per product to value that has been sold in the specified period.
     *
     * @param Request $request
     * @param $id
     */
    public function showAggregation(Request $request, $account)
    {
        $account = Account::findOrFail($account);

        $orderlines = OrderLine::where('created_at', '>=', Carbon::parse($request->start)->format('Y-m-d H:i:s'))
            ->where('created_at', '<', Carbon::parse($request->end)->format('Y-m-d H:i:s'))->get();

        $products = [];
        $totals = [];

        foreach ($orderlines as $orderline) {
            if ($orderline->product->account->account_number == $account->account_number) {
                $p = $orderline->product;
                if (!array_key_exists($p->id, $products)) {
                    $products[$p->id] = $p;
                    $totals[$p->id] = 0;
                }
                $totals[$p->id] += $orderline->total_price;
            }
        }

        return view('omnomcom.accounts.aggregation', ['account' => $account, 'products' => $products, 'totals' => $totals, 'start' => $request->start, 'end' => $request->end]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('omnomcom.accounts.edit', ['account' => Account::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $account = Account::findOrFail($id);
        $account->fill($request->all());
        $account->save();

        $request->session()->flash('flash_message', 'Account ' . $account->account_number . ' (' . $account->name . ') saved.');

        return Redirect::route('omnomcom::accounts::list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $account = Account::findOrFail($id);

        if ($account->products->count() > 0) {
            $request->session()->flash('flash_message', 'Could not delete account ' . $account->account_number . ' (' . $account->name . ') since there are products associated with this account.');
            return Redirect::back();
        }

        $request->session()->flash('flash_message', 'Account ' . $account->account_number . ' (' . $account->name . ') deleted.');
        $account->delete();

        return Redirect::route('omnomcom::accounts::list');
    }
}
