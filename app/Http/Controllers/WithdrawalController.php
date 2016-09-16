<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;
use Proto\Models\OrderLine;
use Proto\Models\Withdrawal;

use Redirect;

class WithdrawalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("omnomcom.withdrawals.index", ['withdrawals' => Withdrawal::orderBy('id', 'desc')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("omnomcom.withdrawals.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $max = ($request->has('max') ? $request->input('max') : null);
        if ($max <= 0) {
            $max = null;
        }

        $date = strtotime($request->input('date'));
        if ($date === false) {
            $request->session()->flash('flash_message', 'Invalid date.');
            return Redirect::back();
        }

        $withdrawal = Withdrawal::create([
            'date' => date('Y-m-d', $date)
        ]);

        $totalPerUser = [];
        foreach (OrderLine::whereNull('payed_with_withdrawal')->get() as $orderline) {

            if ($orderline->isPayed()) continue;
            if ($orderline->user->bank == null) continue;

            if ($max != null) {
                if (!array_key_exists($orderline->user->id, $totalPerUser)) {
                    $totalPerUser[$orderline->user->id] = 0;
                }

                if ($totalPerUser[$orderline->user->id] + $orderline->total_price > $max) continue;
            }

            $orderline->withdrawal()->associate($withdrawal);
            $orderline->save();

            if ($max != null) {
                $totalPerUser[$orderline->user->id] += $orderline->total_price;
            }

        }

        return Redirect::route('omnomcom::withdrawal::show', ['id' => $withdrawal->id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view("omnomcom.withdrawals.show", ['withdrawal' => Withdrawal::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->closed) {
            $request->session()->flash('flash_message', 'This withdrawal is already closed and cannot be deleted.');
            return Redirect::back();
        }

        foreach ($withdrawal->orderlines as $orderline) {
            $orderline->withdrawal()->dissociate();
            $orderline->save();
        }

        $withdrawal->delete();

        $request->session()->flash('flash_message', 'Withdrawal deleted.');
        return Redirect::back();
    }

    public static function openOrderlinesSum()
    {
        $sum = 0;
        foreach (OrderLine::whereNull('payed_with_withdrawal')->get() as $orderline) {
            if ($orderline->isPayed()) continue;
            $sum += $orderline->total_price;
        }
        return $sum;
    }

    public static function openOrderlinesTotal()
    {
        $total = 0;
        foreach (OrderLine::whereNull('payed_with_withdrawal')->get() as $orderline) {
            if ($orderline->isPayed()) continue;
            $total++;
        }
        return $total;
    }
}
