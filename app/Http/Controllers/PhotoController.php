<?php

namespace App\Http\Controllers;

use App\Models\PhotoAlbum;
use App\Models\PhotoLikes;
use App\Models\PhotoManager;
use Auth;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Redirect;
use Session;

class PhotoController extends Controller
{
    /** @return View */
    public function index()
    {
        $albums = PhotoManager::getAlbums(24);

        return view('photos.list', ['albums' => $albums]);
    }

    /**
     * @param int $id
     * @return RedirectResponse|View
     */
    public function show(int $id): View|RedirectResponse
    {
        $album = PhotoAlbum::findOrFail($id);

        if (!$album->published && ! Auth::user()?->can('protography')) {
            Session::flash('flash_message', 'You do not have the permissions for this.');
            return Redirect::back();
        }
        $photos = PhotoManager::getPhotos($id, 24);

        if ($photos) {
            return view('photos.album', ['photos' => $photos]);
        }

        Session::flash('flash_message', 'Album not found.');
        return Redirect::back();
    }

    /**
     * @param int $id
     * @return View
     */
    public function photo($id)
    {
        $photo = PhotoManager::getPhoto($id);
        if ($photo != null) {
            return view('photos.photopage', ['photo' => $photo]);
        }
        abort(404, 'Photo not found.');
    }

    /** @return View */
    public function slideshow()
    {
        return view('photos.slideshow');
    }

    /**
     * @param int $photo_id
     * @return RedirectResponse
     */
    public function likePhoto($photo_id)
    {
        $exist = PhotoLikes::where('user_id', Auth::user()->id)->where('photo_id', $photo_id)->count();

        if ($exist == null) {
            PhotoLikes::create([
                'photo_id' => $photo_id,
                'user_id' => Auth::user()->id,
            ]);
        }

        return Redirect::route('photo::view', ['id' => $photo_id]);
    }

    /**
     * @param int $photo_id
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function dislikePhoto($photo_id)
    {
        PhotoLikes::where('user_id', Auth::user()->id)->where('photo_id', $photo_id)->delete();

        return Redirect::route('photo::view', ['id' => $photo_id]);
    }

    /** @return string JSON */
    public function apiIndex()
    {
        $albums = PhotoManager::getAlbums();

        return json_encode($albums);
    }

    /**
     * @param int $id
     * @return string JSON
     */
    public function apiShow($id)
    {
        $photos = PhotoManager::getPhotos($id);

        return json_encode($photos);
    }
}
