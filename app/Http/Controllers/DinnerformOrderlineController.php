<?php

namespace Proto\Http\Controllers;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Proto\Models\Dinnerform;
use Proto\Models\DinnerformOrderline;
use Session;

class DinnerformOrderlineController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function store(Request $request, $id) {
        $dinnerform = Dinnerform::findOrFail($id);
        $order = $request->input('order');
        $amount = $request->input('price');
        $helper = $request->has('helper');

        if($dinnerform->orderlines()->where('user_id', Auth::user()->id)->exists()){
            Session::flash('flash_message','You can only add one order per dinnerform!');
            return Redirect::back();
        }

        if($dinnerform->event && $dinnerform->event->activity && $dinnerform->event->activity->isHelping(Auth::user())){
            $helper = true;
        }
        $dinnerOrderline = DinnerformOrderline::create([
            'description' => $order,
            'price' => $amount,
            'user_id'=>Auth::user()->id,
            'dinnerform_id'=>$id,
            'helper'=>$helper,
        ]);
        Session::flash('flash_message','Your order has been saved!');
        return Redirect::back();
    }

    /**
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function delete($id) {
        $dinnerOrderline = DinnerformOrderline::findOrFail($id);
        if($dinnerOrderline->closed){
            Session::flash('flash_message', 'You can not delete a closed dinnerform orderline!');
            return Redirect::back();
        }
        if(! Auth::user() || Auth::user()->id !== $dinnerOrderline->user_id || ! $dinnerOrderline->dinnerform->isCurrent() || ! Auth::user()->can('tipcie')){
            Session::flash('flash_message', 'You are not authorized to delete this order!');
            Redirect::back();
        }

        $dinnerOrderline->delete();
        Session::flash('flash_message', 'Your order has been deleted!');
        return Redirect::back();
    }

    /**
     * @param int $id
     * @return View|RedirectResponse
     */
    public function edit($id) {
        $dinnerOrderline = DinnerformOrderline::findOrFail($id);
        if($dinnerOrderline->closed){
            Session::flash('flash_message', 'You can not edit a closed dinner orderline!');
            return Redirect::back();
        }
        return view('dinnerform.dinnerform-orderline-edit', ['dinnerformOrderline'=>$dinnerOrderline]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return View
     */
    public function update(Request $request,$id) {
        $dinnerOrderline = DinnerformOrderline::findOrFail($id);
        if($dinnerOrderline->closed){
            $dinnerform = $dinnerOrderline->dinnerform;
            Session::flash('flash_message', 'You can not update a closed dinner orderline!');
            return view('dinnerform.admin', ['dinnerform'=>$dinnerform, 'orderList'=>$dinnerform->orderlines()->get()]);
        }

        $order = $request->input('order');
        $amount = $request->input('price');
        $helper = $request->has('helper');
        $dinnerOrderline->update([
            'description' => $order,
            'price' => $amount,
            'user_id'=>$dinnerOrderline->user_id,
            'helper'=>$helper,
        ]);
        $dinnerOrderline->save();
        $dinnerform = Dinnerform::findOrFail($dinnerOrderline->dinnerform_id);
        Session::flash('flash_message', 'Your order has been updated!');
        return view('dinnerform.admin', ['dinnerform'=>$dinnerform, 'orderList'=>$dinnerform->orderlines()->get()]);
    }
}