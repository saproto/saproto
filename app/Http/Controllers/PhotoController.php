<?php

namespace Proto\Http\Controllers;

use Auth;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Proto\Models\Photo;
use Proto\Models\PhotoAlbum;
use Proto\Models\PhotoLikes;
use Redirect;

class PhotoController extends Controller
{
    /** @return View */
    public function index()
    {
        $albums = PhotoAlbum::orderBy('date_taken', 'desc')->paginate(24);
        return view('photos.list', ['albums' => $albums]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function show($id)
    {
        $album = PhotoAlbum::findOrFail($id);
        $photos = $album->items()->orderBy('date_taken', 'asc')->orderBy('id', 'asc')->paginate(24);

        if ($photos) {
            return view('photos.album', ['album' => $album, 'photos' => $photos]);
        }

        abort(404, 'Album not found.');
    }

    /**
     * @param int $id
     * @return View
     */
    public function photo($id)
    {
        $photo = Photo::findOrFail($id);
        if ($photo) {
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
     * @throws Exception
     */
    public function dislikePhoto($photo_id)
    {
        PhotoLikes::where('user_id', Auth::user()->id)->where('photo_id', $photo_id)->delete();
        return Redirect::route('photo::view', ['id' => $photo_id]);
    }

    public static function getAlbums($published = True)
    {
        $albums = PhotoAlbum::orderBy('date_taken', 'desc');
        $albums = $albums->where('published', '=', $published);
        return $albums->get();
    }

    /** @return string JSON */
    public function apiIndex()
    {
        $albums = PhotoAlbum::orderBy('date_taken', 'desc')->where('private', '=', false)->get();
        return json_encode($albums);
    }

    /**
     * @param $id
     * @return string JSON
     */

    //kept for backwards compatibility
    public static function apiShow($album_id)
    {
        $album = PhotoAlbum::findOrFail($album_id);
        $items = $album->items();

        if (!(Auth::check() && Auth::user()->member() !== null)) {
            $items = $items->where('private', '=', false);
        }
        $items = $items->orderBy('date_taken', 'asc')->orderBy('id', 'asc')->get();
        $data = new stdClass();
        $data->album_id = $album_id;

        $album = $album->first();
        $data->album_title = $album->name;
        $data->album_date = $album->date_taken;
        $data->event = ($album->event ? $album->event : null);
        $data->private = $album->private;
        $data->published = $album->published;
        $data->thumb = $album->thumb();
        $data->photos = $items;

        return json_encode($data);
    }
}
