<?php

namespace Proto\Http\Controllers;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Proto\Models\Setting;
use Redirect;

class SettingsController extends Controller
{
    /**
     * @throws Exception
     */
    public function index()
    {
        return view('settings.index', ['settings' => Setting::all()]);
    }

    /**
     * @param Request $request
     * @param string $key
     * @return RedirectResponse
     */
    public function update(Request $request, $key)
    {
        foreach($request->except('_token') as $subkey => $value) {
            Setting::update($key, $subkey, $value);
        }

        $key = ucwords(str_replace('_', ' ', $key));
        $request->session()->flash('flash_message', "Updated $key settings");
        return Redirect::back();
    }
}