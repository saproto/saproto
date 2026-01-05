<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Laravel\Pennant\Feature;

class FeatureController extends Controller
{
    /**
     * Enable or disable a feature for a specific user.
     */
    public function toggle(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'feature' => ['required', 'string'],
        ]);

        if (Feature::for($user)->active($request->feature)) {
            Feature::for($user)->deactivate($request->feature);
        } else {
            Feature::for($user)->activate($request->feature);
        }
        Session::flash('flash_message', "Feature updated for {$user->name}");

        return back();
    }
}
