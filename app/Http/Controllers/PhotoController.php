<?php

namespace Proto\Http\Controllers;

use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Proto\Models\Photo;
use Proto\Models\PhotoAlbum;
use Proto\Models\PhotoLikes;
use stdClass;

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

        if ($photos->count()) {
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
        return view('photos.photopage', ['photo' => $photo]);
    }

    /**
     * @param int $id
     * @param bool $next
     * @return JsonResponse
     */
    private function getAdjacentPhoto($id, $next) {
        $photo = Photo::findOrFail($id);
        $adjacent = $photo->getAdjacentPhoto($next, Auth::user());
        if($adjacent) {
            return response()->JSON([
                'id' => $adjacent->id,
                'originalUrl' => $adjacent->getOriginalUrl(),
                'largeUrl' => $adjacent->getLargeUrl(),
                'tinyUrl' => $adjacent->getTinyUrl(),
                'albumUrl' => route('photo::album::list', ['id' => $photo->album_id]).'?page='.$photo->getAlbumPageNumber(24),
                'likes'=>$adjacent->getLikes(),
                'likedByUser'=>$adjacent->likedByUser(Auth::user()),
                'private' => $adjacent->private,
                'hasNextPhoto'=>$adjacent->getAdjacentPhoto(true, Auth::user()) !== null,
                'hasPreviousPhoto'=>$adjacent->getAdjacentPhoto(false, Auth::user()) !== null,
            ]);
        }
        return response()->json(['error' => 'adjacent photo not found.'], 404);
    }

    public function getNextPhoto($id) {
        return $this->getAdjacentPhoto($id, true);
    }

    public function getPreviousPhoto($id) {
        return $this->getAdjacentPhoto($id, false);
    }

    /** @return View */
    public function slideshow()
    {
        return view('photos.slideshow');
    }

    /**
     * @return JsonResponse
     * @param int $photo_id
     **/
    public function toggleLike($photo_id)
    {
        $photoLike = PhotoLikes::where('photo_id', $photo_id)->where('user_id', Auth::user()->id)->first();
        if ($photoLike) {
            $photoLike->delete();
        } else {
            $photoLike = new PhotoLikes([
                'user_id' => Auth::user()->id,
                'photo_id' => $photo_id,
            ]);
            $photoLike->save();
        }
        $photo = Photo::findOrFail($photo_id);
        return response()->json([
                'likes' => $photo->getLikes(),
                'likedByUser' => $photo->likedByUser(Auth::user()),
            ]
        );
    }

    /**
     * @param bool $published
     **@return Collection
     */
    public static function getAlbums($published = true)
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
     * @param int $album_id
     * @return string JSON
     */

    //kept for backwards compatibility
    public static function apiShow($album_id)
    {
        $album = PhotoAlbum::findOrFail($album_id);
        $items = $album->items();

        if (! (Auth::check() && Auth::user()->member() !== null)) {
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
