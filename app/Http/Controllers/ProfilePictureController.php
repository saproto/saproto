<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ProfilePictureController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'max:5120', 'mimes:jpeg,png,jpg'], // max 5MB
        ]);

        $user = Auth::user();
        try {
            $user->addMediaFromRequest('image')->toMediaCollection('profile_picture');
        } catch (FileDoesNotExist|FileIsTooBig $e) {
            Session::flash('flash_message', $e->getMessage());

            return back();
        }

        Session::flash('flash_message', 'Your profile picture has been updated!');

        return back();
    }

    public function destroy(): RedirectResponse
    {
        foreach (Auth::user()->getMedia('profile_picture') as $media) {
            $media->delete();
        }

        Session::flash('flash_message', 'Your profile picture has been cleared!');

        return back();
    }
}
