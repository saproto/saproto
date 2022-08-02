<?php

namespace Proto\Http\Controllers;

use Auth;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Proto\Models\Photo;
use Redirect;
use Session;

class ProfilePictureController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws FileNotFoundException
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $image = $request->file('image');
        if ($image) {
            if (substr($image->getMimeType(), 0, 5) == 'image') {
                $photo = new Photo();
                $img = Image::make($image);
                $smallestSide = $img->width() < $img->height() ? $img->width : $img->height();
                $img->fit($smallestSide);
                $photo->makePhoto($img, $image->getClientOriginalName(), $image->getCTime(), false, 'profile_pictures');
                $photo->save();
                $user->photo()->associate($photo);
                $user->save();
            } else {
                Session::flash('flash_message', 'This is not an image file!');
                return Redirect::back();
            }
        } else {
            Session::flash('flash_message', 'You forgot an image to upload, silly!');
            return Redirect::back();
        }
        Session::flash('flash_message', 'Your profile picture has been updated!');
        return Redirect::back();
    }

    /** @return RedirectResponse */
    public function destroy()
    {
        $user = Auth::user();
        $user->photo()->delete();
        $user->photo()->dissociate();
        $user->save();

        Session::flash('flash_message', 'Your profile picture has been cleared!');
        return Redirect::back();
    }
}
