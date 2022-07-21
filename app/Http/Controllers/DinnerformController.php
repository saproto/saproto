<?php

namespace Proto\Http\Controllers;
use Auth;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use Proto\Models\Dinnerform;
use Proto\Models\DinnerformOrderline;
use Proto\Models\Product;
use Session;
use Carbon;

class DinnerformController extends Controller
{
    /**
     * @param  int $id
     * @return View|RedirectResponse
     */
    public function show($id)
    {

        /** @var Dinnerform $dinnerform */
        $dinnerform = Dinnerform::findOrFail($id);
        $previousOrders=DinnerformOrderline::where('user_id',Auth::user()->id)->where('dinnerform_id', $dinnerform->id)->get();
        return view('dinnerform.order', ['dinnerform'=>$dinnerform, 'previousOrders'=>$previousOrders]);

    }

    public function admin($id){
        $dinnerform = Dinnerform::findOrFail($id);
        return view('dinnerform.admin', ['dinnerform'=>$dinnerform, 'orderList'=>$dinnerform->orderlines()->get()]);
    }

    /** @return View */
    public function create()
    {
        $dinnerformList = Dinnerform::all()->sortByDesc('end');
        return view('dinnerform.list', ['dinnerformCurrent' => null, 'dinnerformList' => $dinnerformList]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->end < $request->start) {
            Session::flash('flash_message', 'You cannot let the dinner form close before it opens.');
            return Redirect::back();
        }

        $dinnerform = Dinnerform::create([
            'restaurant' => $request->restaurant,
            'description' => $request->description,
            'url' => $request->url,
            'start' => strtotime($request->start),
            'end' => strtotime($request->end),
            'discount'=>$request->discount,
            'event_id'=>$request->eventSelect!=''?$request->eventSelect:null
        ]);

        Session::flash('flash_message', "Your dinner form at '".$dinnerform->restaurant."' has been added.");
        return Redirect::route('dinnerform::add');
    }

    /**
     * @param  int $id
     * @return View|RedirectResponse
     */
    public function edit($id)
    {
        $dinnerformCurrent = Dinnerform::findOrFail($id);
        if ($dinnerformCurrent->closed) {
            return Redirect::back()->with('flash_message', 'You can not update a closed dinnerform!');
        }
        $dinnerformList = Dinnerform::all()->sortByDesc('end');
        return view('dinnerform.list', ['dinnerformCurrent' => $dinnerformCurrent, 'dinnerformList' => $dinnerformList]);
    }

    /**
     * @param Request $request
     * @param  int $id
     * @return RedirectResponse|View
     */
    public function update(Request $request, $id)
    {

        if ($request->end < $request->start) {
            return Redirect::back()->with('flash_message', 'You cannot let the dinnerform close before it opens.');
        }

        /** @var Dinnerform $dinnerform */
        $dinnerform = Dinnerform::findOrFail($id);

        if ($dinnerform->closed) {
            return Redirect::back()->with('flash_message', 'You can not update a closed dinnerform!');
        }

        $changed_important_details = $dinnerform->start->timestamp != strtotime($request->start) || $dinnerform->end->timestamp != strtotime($request->end) || $dinnerform->restaurant != $request->restaurant;

        $dinnerform->update([
            'restaurant' => $request->restaurant,
            'description' => $request->description,
            'url' => $request->url,
            'start' => strtotime($request->start),
            'end' => strtotime($request->end),
            'discount'=>$request->discount,
            'event_id'=>$request->eventSelect!=''?$request->eventSelect:null
        ]);

        if ($changed_important_details) {
            Session::flash('flash_message', "Your dinner form for '".$dinnerform->restaurant."' has been saved. You updated some important information. Don't forget to update your participants with this info!");
        } else {
            Session::flash('flash_message', "Your dinner form for '".$dinnerform->restaurant."' has been saved.");
        }

        return $this->edit($id);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        $dinnerform = Dinnerform::findOrFail($id);
        if(!$dinnerform->closed){
            Session::flash('flash_message', "The dinner form for '".$dinnerform->restaurant."' has been deleted.");
            $dinnerform->delete();
        }else{
            Session::flash('flash_message', "The dinner form is already closed and can not be deleted!");
        }
            return Redirect::route('dinnerform::add');
    }

    /**
     * Close the dinnerform by changing the end time to the current time.
     *
     * @param int $id
     * @return View
     */
    public function close($id)
    {
        /** @var Dinnerform $dinnerform */
        $dinnerform = Dinnerform::findOrFail($id);
        $dinnerform->end = Carbon::now();
        $dinnerform->save();
        return view('dinnerform.admin', ['dinnerform'=>$dinnerform, 'orderList'=>$dinnerform->orderlines()->get()]);
    }

    public function process($id){
        $dinnerform=Dinnerform::findOrFail($id);
        $dinnerformOrderlines=$dinnerform->orderlines()->get();
        $product = Product::findOrFail(config('omnomcom.dinnerform-product'));

        foreach($dinnerformOrderlines as $dinnerformOrderline){
            $product->buyForUser(
                $dinnerformOrderline->user(),
                1,
                $dinnerformOrderline->price(),
                null,
                null,
                sprintf('Dinnerform from %s, ordered at '.$dinnerform->restaurant, date('d-m-Y', strtotime($dinnerform->end))),
                sprintf('dinnerform_orderline_processed_by_%u', Auth::user()->id)
            );
            $dinnerformOrderline->closed=true;
            $dinnerformOrderline->save();
        }
        $dinnerform->closed=true;
        $dinnerform->save();
        return Redirect::route('dinnerform::add')->with('flash_message', 'All orderlines of '.$dinnerform->restaurant.' have been processed!');
    }
}
