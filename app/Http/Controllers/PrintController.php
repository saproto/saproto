<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;
use Proto\Models\OrderLine;
use Proto\Models\Product;

use Proto\Models\StorageEntry;

use Redirect;
use Auth;

class PrintController extends Controller
{
    public function form()
    {
        $print = Product::findOrFail(config('proto.printproduct'));
        return view('print.form', ['print' => $print]);
    }

    public function doPrint(Request $request)
    {
        $print = Product::findOrFail(config('proto.printproduct'));
        if ($print->stock <= 0) {
            $request->session()->flash('flash_message', 'You cannot print at this time. Either the paper or the toner are empty or something is broken.');
            return Redirect::back();
        }

        $upload = $request->file('file');

        if ($upload->getMimeType() != "application/pdf") {
            $request->session()->flash('flash_message', 'You uploaded an invalid PDF file.');
            return Redirect::back();
        }

        $file = new StorageEntry();
        $file->createFromFile($upload);

        $file->is_print_file = true;
        $file->save();

        $copies = $request->input('copies');

        if ($copies < 1) {
            $request->session()->flash('flash_message', "You cannot print nothing.");
            return Redirect::back();
        }

        $result = FileController::requestPrint('document', $file->generatePath(), $copies);

        if ($result === false) {
            $request->session()->flash('flash_message', "Something went wrong trying to reach the printer service.");
            return Redirect::back();
        } elseif ($result != "OK") {
            $request->session()->flash('flash_message', "The printer server responded something unexpected: " . $result);
            return Redirect::back();
        }

        $pdf = file_get_contents(storage_path('app/' . $file->filename));
        $pages = preg_match_all("/\/Page\W/", $pdf, $dummy);

        $orderline = OrderLine::create([
            'user_id' => Auth::user()->id,
            'product_id' => $print->id,
            'original_unit_price' => $print->price,
            'units' => $copies * $pages,
            'total_price' => ((($request->has('free') && Auth::user()->can('board')) ? 0 : $copies * $pages * $print->price))
        ]);

        $request->session()->flash('flash_message', 'Printed ' . $file->original_filename . ' (' . $pages . ' pages) ' . $copies . ' times. You can collect your printed document in the Protopolis!');
        return Redirect::back();
    }
}
