<?php

namespace Proto\Http\Controllers;

use Auth;
use Proto\Models\PhotoLikes;
use Proto\Models\PhotoManager;
use Redirect;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $albums = PhotoManager::getAlbums(24);

        return view('photos.list', ['albums' => $albums]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $photos = PhotoManager::getPhotos($id, 24);

        if ($photos) {
            return view('photos.album', ['photos' => $photos]);
        }

        abort(404, 'Album not found.');
    }

    public function photo($id)
    {
        $photo = PhotoManager::getPhoto($id);
        if ($photo) {
            return view('photos.photopage', ['photo' => $photo]);
        }
    }

    public function likePhoto($photoID)
    {
        $exist = PhotoLikes::where('user_id', Auth::user()->id)->where('photo_id', $photoID)->count();

        if ($exist == null) {
            PhotoLikes::create([
                'photo_id' => $photoID,
                'user_id'  => Auth::user()->id,
            ]);
        }

        return Redirect::route('photo::view', ['id' => $photoID]);
    }

    public function dislikePhoto($photoID)
    {
        PhotoLikes::where('user_id', Auth::user()->id)->where('photo_id', $photoID)->delete();

        return Redirect::route('photo::view', ['id' => $photoID]);
    }

    /**
     * Return JSON for a listing of the resource.
     *
     * @return string
     */
    public function apiIndex()
    {
        $albums = PhotoManager::getAlbums();

        return json_encode($albums);
    }

    /**
     * Return JSON for the specified resource.
     *
     * @param $id
     *
     * @return string
     */
    public function apiShow($id)
    {
        $photos = PhotoManager::getPhotos($id);

        return json_encode($photos);
    }

    public function slideshow()
    {
        return view('photos.slideshow');
    }
}
