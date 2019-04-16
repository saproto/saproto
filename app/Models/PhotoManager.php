<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

use Exception;

class PhotoManager extends Model
{
    public static function getAlbums($max = null, $query=null, $unpublished=False, $no_thumb=False)
    {
        $include_private = (Auth::check() && Auth::user()->member() !== null);

        $base = PhotoAlbum::orderBy('date_taken', 'desc');
        if (!$include_private) {
            $base = $base->where('private', '=', false);
        }
        if ($query) {
            $base = $base->where('name', 'LIKE', '%'.$query.'%');
        }
        if ($unpublished) {
            $base = $base->where('published', '=', False);
        } else {
            $base = $base->where('published', '=', True);
        }
        if (!$no_thumb) {
            $base = $base->where('thumb_id', '!=', 'null');
        }
        if ($max != 0) {
            $albums = $base->paginate($max);
        } else {
            $albums = $base->get();
        }
        return $albums;
    }



    public static function getPhotos($albumID)
    {
        $include_private = (Auth::check() && Auth::user()->member() !== null);

        $album = PhotoAlbum::where('id', $albumID);
        if (!$include_private) {
            $album->where('private', '=', false);
        }
        $album = $album->get();

        if ($album->count() == 0) {
            abort(404, "This album does not exist.");
        }

        $items = Photo::where('album_id', $albumID);


        if (!$include_private) {
            $items = $items->where('private', '=', false);
        }
        $items = $items->orderBy('date_taken', 'asc')->get();
        $data = new \stdClass();
        $data->album_id = $albumID;
        $data->album_title = PhotoAlbum::where("id", "=", $albumID)->first()->name;
        $data->album_date = PhotoAlbum::where("id", "=", $albumID)->first()->date_taken;
        $data->event = (PhotoAlbum::where("id", "=", $albumID)->first()->event ? PhotoAlbum::where("id", "=", $albumID)->first()->event : null);
        $data->private = PhotoAlbum::where("id", "=", $albumID)->first()->private;
        $data->published = PhotoAlbum::where("id", "=", $albumID)->first()->published;
        $data->photos = $items;

        return $data;
    }

    public static function getPhoto($photoID)
    {
        $photo = Photo::where('id', $photoID)->first();

        $data = new \stdClass();
        $data->photo_url = $photo->url();
        $data->album_id = $photo->album_id;
        $data->album_name = $photo->album->name;
        $data->private = $photo->private;
        $data->likes = $photo->getLikes();
        $data->liked = Auth::check() ? PhotoLikes::where("photo_id", "=", $photoID)->where('user_id', Auth::user()->id)->count() : 0;

        if ($photo->getNextPhoto() != null) {
            $data->next = $photo->getNextPhoto()->id;
        } else {
            $data->next = null;
        }

        if ($photo->getPreviousPhoto() != null) {
            $data->previous = $photo->getPreviousPhoto()->id;
        } else {
            $data->previous = null;
        }

        $data->id = $photoID;

        return $data;
    }


}
