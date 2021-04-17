<?php

namespace Proto\Models;

use Auth;
use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Model;
use stdClass;

/**
 * Photo Manager Model.
 *
 * @mixin Eloquent
 */
class PhotoManager extends Model
{
    /**
     * @param int|null $max
     * @param string|null $query
     * @param bool $unpublished
     * @param bool $no_thumb
     * @return PhotoAlbum[]
     */
    public static function getAlbums($max = null, $query = null, $unpublished = false, $no_thumb = true)
    {
        $include_private = (Auth::check() && Auth::user()->member() !== null);
        $base = PhotoAlbum::orderBy('date_taken', 'desc');

        if (! $include_private) {
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
        if (! $no_thumb) {
            $base = $base->where('thumb_id', '!=', 'null');
        }
        if ($max != 0) {
            $albums = $base->paginate($max);
        } else {
            $albums = $base->get();
        }

        return $albums;
    }

    /**
     * @param int $albumId
     * @param int|null $max
     * @return stdClass|null
     */
    public static function getPhotos($albumId, $max = null)
    {
        $include_private = (Auth::check() && Auth::user()->member() !== null);

        $album = PhotoAlbum::where('id', $albumId);
        if (! $include_private) {
            $album->where('private', '=', false);
        }
        $album = $album->get();

        if ($album->count() == 0) {
            return null;
        }

        $items = Photo::where('album_id', $albumId);

        if (! $include_private) {
            $items = $items->where('private', '=', false);
        }
        $items = $items->orderBy('date_taken', 'asc')->orderBy('id', 'asc');
        if ($max != 0) {
            $items = $items->paginate($max);
        } else {
            $items = $items->get();
        }

        $data = new stdClass();
        $data->album_id = $albumId;

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

    /**
     * @param int $photoId
     * @return stdClass
     */
    public static function getPhoto($photoId)
    {
        $photo = Photo::where('id', $photoId)->first();

        $data = new stdClass();
        $data->photo_url = $photo->url;
        $data->album_id = $photo->album_id;
        $data->album_name = $photo->album->name;
        $data->private = $photo->private;
        $data->likes = $photo->getLikes();
        $data->liked = Auth::check() ? PhotoLikes::where('photo_id', '=', $photoId)->where('user_id', Auth::user()->id)->count() : 0;

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

        $data->id = $photoId;

        return $data;
    }

    /**
     * @param int $albumId
     * @throws Exception
     */
    public static function deleteAlbum($albumId)
    {
        $album = PhotoAlbum::where('id', $albumId)->get()->first();
        $photos = Photo::where('album_id', $albumId)->get();

        foreach ($photos as $photo) {
            $photo->delete();
        }
        $album->delete();
    }
}
