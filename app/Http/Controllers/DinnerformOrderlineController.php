<?php

namespace Proto\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Proto\Models\Dinnerform;
use Proto\Models\DinnerformOrderline;

class DinnerformOrderlineController extends Controller
{
    public function store(Request $request, $id) {
        $dinnerform = Dinnerform::findOrFail($id);
        $order = $request->input('order');
        $amount = $request->input('price');
        $helper = $request->has('helper');
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
        return Redirect::back()->with('flash_message','Your order has been saved!');
    }

    public function delete($id) {
        $dinnerOrderline = DinnerformOrderline::findOrFail($id);
        if($dinnerOrderline->closed){
            return Redirect::back()->with('flash_message', 'You can not delete a closed dinner orderline!');
        }
        if(Auth::user() || Auth::user()->id !== $dinnerOrderline->user_id || ! $dinnerOrderline->dinnerform()->isCurrent() || ! Auth::user()->can('tipcie')){
            Redirect::back()->with('flash_message', 'You are not authorized to delete this order!');
        }
        $dinnerOrderline->delete();
        return Redirect::back()->with('flash_message', 'Your order has been deleted!');
    }

    public function edit($id) {
        $dinnerOrderline = DinnerformOrderline::findOrFail($id);
        if($dinnerOrderline->closed){
            return Redirect::back()->with('flash_message', 'You can not edit a closed dinner orderline!');
        }
        return view('dinnerform.dinnerform-orderline-edit', ['dinnerformOrderline'=>$dinnerOrderline]);
    }

    public function update(Request $request,$id) {
        $dinnerOrderline = DinnerformOrderline::findOrFail($id);
        if($dinnerOrderline->closed){
            return view('dinnerform.admin', ['dinnerform'=>$dinnerOrderline->dinnerform(), 'orderList'=>$dinnerOrderline->dinnerform->orderlines()->get()])->with('flash_message', 'You can not update a closed dinner orderline!');
        }

        $order = $request->input('order');
        $amount = $request->input('price');
        $helper = $request->has('helper');
        $dinnerOrderline->update([
            'description' => $order,
            'price' => $amount,
            'user_id'=>Auth::user()->id,
            'helper'=>$helper,
        ]);
        $dinnerOrderline->save();
        $dinnerform = Dinnerform::findOrFail($dinnerOrderline->dinnerform_id);
        return view('dinnerform.admin', ['dinnerform'=>$dinnerform, 'orderList'=>$dinnerform->orderlines()->get()])->with('flash_message', 'Your order has been updated!');
    }
}