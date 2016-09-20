<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Proto\Http\Requests;

use Proto\Models\User;
use Proto\Models\Pastry;

use Session;
use Auth;
use Redirect;

class PastriesController extends Controller
{

    public function overview()
    {
        $pastries = Pastry::orderBy('created_at', 'desc')->get();
        foreach ($pastries as $pastry) {
            $pastry->user_id_a = User::find($pastry->user_id_a);
            $pastry->user_id_b = User::find($pastry->user_id_b);
            switch ($pastry->pastry) {
                default:
                    $pastry->pastry = "Cookies";
                    break;
                case 1:
                    $pastry->pastry = "Cake";
                    break;
                case 2:
                    $pastry->pastry = "Pie";
                    break;
            }
        }
        return view('pastries.list', ['pastries' => $pastries]);
    }

    public function store(Request $request)
    {
//        dd($request);
        $pastry = new Pastry();
        $pastry->user_id_a = $request->user_a;
        if ($request->user_b != "") {
            $pastry->user_id_b = $request->user_b;
        } else {
            $pastry->person_b = $request->person_b;
        }

        $pastry->pastry = $request->pastry;

        $pastry->save();
        Session::flash('flash_message', "Pastry has been baked.");
        return Redirect::route("pastries::list");
    }

    public function destroy($id)
    {
        $pastry = Pastry::find($id);
        if (!$pastry) abort(404);
        $pastry->delete();
        Session::flash('flash_message', "Pastry has been eaten.");
        return Redirect::route("pastries::list");
    }

}