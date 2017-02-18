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

        $uploads = $request->file('file');

        $errors = 0;
        $successes = 0;

        foreach ($uploads as $i => $upload) {

            if (!file_exists($upload->__toString())) {
                $errors++;
                continue;
            }

            if ($upload->getMimeType() != "application/pdf") {
                $errors++;
                continue;
            }

            $copies = $request->input('copies')[$i];

            if ($copies < 1) {
                continue;
            }

            $file = new StorageEntry();
            $file->createFromFile($upload);

            $file->is_print_file = true;
            $file->save();

            $result = FileController::requestPrint('document', $file->generatePath(), $copies);

            if ($result === false) {
                $errors++;
                continue;
            } elseif ($result != "OK") {
                $errors++;
                continue;
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

            $successes++;

        }

        if ($errors > 0) {
            $request->session()->flash('flash_message', "An error occured trying to print $errors documents. $successes documents successfully printed.");
        } else {
            $request->session()->flash('flash_message', "$successes documents successfully printed.");
        }
        return Redirect::back();
    }
}
