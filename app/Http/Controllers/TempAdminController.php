<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Models\User;
use Proto\Models\Tempadmin;

use Auth;
use Carbon;
use DB;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

class TempAdminController extends Controller
{


    public function make($id)
    {
        $user = User::findOrFail($id);

        $tempAdmin = new Tempadmin;

        $tempAdmin->created_by = Auth::user()->id;
        $tempAdmin->start_at = Carbon::today();
        $tempAdmin->end_at = Carbon::tomorrow();
        $tempAdmin->user()->associate($user);

        $tempAdmin->save();

        return redirect()->back();
    }

    public function end($id)
    {
        $user = User::findOrFail($id);

        foreach ($user->tempadmin as $tempadmin) {
            if (Carbon::now()->between(Carbon::parse($tempadmin->start_at), Carbon::parse($tempadmin->end_at))) {
                $tempadmin->end_at = Carbon::now()->subSeconds(1);
                $tempadmin->save();
            }
        }

        // Call Herbert webhook to run check through all connected admins. Will result in kick for users whose
        // temporary adminpowers were removed.
        file_get_contents(config('herbert.server') . "/adminCheck");

        return redirect()->back();
    }

    public function endId($id)
    {
        $tempadmin = Tempadmin::findOrFail($id);

        if(Carbon::parse($tempadmin->start_at)->isFuture()) {
            $tempadmin->delete();
        }else{
            $tempadmin->end_at = Carbon::now()->subSeconds(1);
            $tempadmin->save();

            // Call Herbert webhook to run check through all connected admins. Will result in kick for users whose
            // temporary adminpowers were removed.
            file_get_contents(config('herbert.server') . "/adminCheck");
        }

        return redirect()->back();
    }

    public function index()
    {
        $tempadmins = Tempadmin::where('end_at', '>', DB::raw("NOW()"))->orderBy('end_at', 'desc')->get();
        $pastTempadmins = Tempadmin::where('end_at', '<=', DB::raw("NOW()"))->orderBy('end_at', 'desc')->take(10)->get();

        return view("tempadmin.list", ['tempadmins' => $tempadmins, 'pastTempadmins' => $pastTempadmins]);
    }

    public function create()
    {
        return view("tempadmin.edit", ['tempadmin' => null, 'new' => true]);
    }

    public function store(Request $request)
    {
        $tempadmin = new Tempadmin();

        $tempadmin->user()->associate(User::findOrFail($request->user_id));
        $tempadmin->creator()->associate(Auth::user());
        $tempadmin->start_at = date('Y-m-d H:i:s', strtotime($request->start_at));
        $tempadmin->end_at = date('Y-m-d H:i:s', strtotime($request->end_at));

        $tempadmin->save();

        return redirect(route("tempadmin::index"));
    }

    public function edit($id)
    {
        $tempadmin = Tempadmin::findOrFail($id);

        return view("tempadmin.edit", ['item' => $tempadmin, 'new' => false]);
    }

    public function update($id, Request $request)
    {
        $tempadmin = Tempadmin::findOrFail($id);

        $tempadmin->start_at = date('Y-m-d H:i:s', strtotime($request->start_at));
        $tempadmin->end_at = date('Y-m-d H:i:s', strtotime($request->end_at));

        $tempadmin->save();

        return redirect(route("tempadmin::index"));
    }

}
