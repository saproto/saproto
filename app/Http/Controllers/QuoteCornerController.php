<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Models\StorageEntry;
use Proto\Http\Requests;

use Proto\Models\User;
use Proto\Models\Quote;

use Auth;
use Session;
use Redirect;


class QuoteCornerController extends Controller
{

    public function overview()
    {
        return view('quotecorner.list', ['data' => Quote::orderBy('created_at', 'desc')->get()]);
    }

    public function add(Request $request)
    {
        $temp = $request->input('quote');
        $temp = nl2br(trim($temp));

        if (!(strlen($temp) > 0)) return Redirect::route('quotes::list');

        $new = array(
            'quote' => $temp,
            'user_id' => Auth::id()
        );

        $quote = new Quote($new);

        $quote->save();

        Session::flash("flash_message", "Quote added.");

        return Redirect::route('quotes::list');
    }

    public function delete($id)
    {

        $quote = Quote::find($id);
        if ($quote == null) {
            abort(404, "Quote $id not found.");
        }

        $quote->delete();

        Session::flash("flash_message", "Quote deleted.");

        return Redirect::route('quotes::list');
    }
}