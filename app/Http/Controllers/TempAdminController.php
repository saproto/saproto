<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Models\User;
use Proto\Models\Tempadmin;

use Auth;
use Carbon;

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
        file_get_contents(env('HERBERT_SERVER') . "/adminCheck");

        return redirect()->back();
    }

}
