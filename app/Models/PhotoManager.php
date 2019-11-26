<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

use Exception;

class PhotoManager extends Model
{
    public static function getAlbums($max = null, $query=null, $unpublished=false, $no_thumb=true)
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
            $base = $base->where('published', '=', false);
        } else {
            $base = $base->where('published', '=', true);
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
            return null;
        }

        $items = Photo::where('album_id', $albumID);


        if (!$include_private) {
            $items = $items->where('private', '=', false);
        }
        $items = $items->orderBy('date_taken', 'asc')->get();
        $data = new \stdClass();
        $data->album_id = $albumID;

        $album = $album->first();

        $data->album_title = $album->name;
        $data->album_date = $album->date_taken;
        $data->event = ($album->event ? $album->event : null);
        $data->private = $album->private;
        $data->published = $album->published;
        $data->thumb = $album->thumb();
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

    public static function deleteAlbum($albumID)
    {
        $album = PhotoAlbum::where('id', $albumID)->get()->first();
        $photos = Photo::where('album_id', $albumID)->get();

        foreach($photos as $photo) {
            $photo->delete();
        }
        $album->delete();
    }


}
