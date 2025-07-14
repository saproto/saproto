<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ProfilePictureController extends Controller
{
    /**
     * @return RedirectResponse|string
     */
    public function update(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120', // max 5MB
        ]);

        $user = Auth::user();
        try {
            $user->addMediaFromRequest('image')->toMediaCollection('profile_picture');
        } catch (FileDoesNotExist|FileIsTooBig $e) {
            Session::flash('flash_message', $e->getMessage());
            Redirect::back();
        }

        Session::flash('flash_message', 'Your profile picture has been updated!');

        return Redirect::back();
    }

    /** @return RedirectResponse */
    public function destroy()
    {
        foreach (Auth::user()->getMedia('profile_picture') as $media) {
            $media->delete();
        }

        Session::flash('flash_message', 'Your profile picture has been cleared!');

        return Redirect::back();
    }
}
