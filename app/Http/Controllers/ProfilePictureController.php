<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\User;
use Proto\Models\StorageEntry;

use Session;
use Redirect;

use Auth;

class ProfilePictureController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $image = $request->file('image');
        if ($image) {
            if (substr($image->getMimeType(), 0, 5) == 'image') {
                $file = new StorageEntry();
                $file->createFromFile($image);

                $user->photo()->associate($file);
                $user->save();
            } else {
                Session::flash("flash_message", "This is not an image file!");
                return Redirect::back();
            }
        } else {
            Session::flash("flash_message", "You forget an image to upload, silly!");
            return Redirect::back();
        }
        Session::flash("flash_message", "Your profile picture has been updated!");
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $user = Auth::user();

        $user->photo()->dissociate();
        $user->save();

        Session::flash("flash_message", "Your profile picture has been cleared!");
        return Redirect::back();
    }
}
