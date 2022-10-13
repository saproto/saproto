<?php

namespace Proto\Http\Controllers;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Proto\Models\Photo;
use Proto\Models\PhotoAlbum;
use Proto\Models\User;

class LikedPicturesController extends Controller
{
    /**
     * @param int $id
     * @return View
     */
    public function show()
    {
        $likedPhotos = Photo::whereHas('likes', function (Builder $query) {
            $query->where('user_id', Auth::user()->id);
        })->orderBy('date_taken', 'asc')->orderBy('id', 'asc')->paginate(24);

        $album=new \stdClass();
        $album->title='my liked photos!';
        $album->name='my liked photos!';
        $album->date_taken=\Carbon::today()->timestamp;
        $album->event=null;

        if ($likedPhotos->count()) {
            return view('photos.album', ['album' => $album, 'photos' => $likedPhotos, 'liked'=>true]);
        }

        abort(404, 'No liked photos!');
    }

    /**
     * @param int $id
     * @return View
     */
    public function photo($id)
    {
        $photo = Photo::findOrFail($id);
        return view('photos.photopage', ['photo' => $photo, 'liked'=>true]);
    }

    public function getNextPhoto($id) {
        return $this->getAdjacentPhoto($id, true);
    }

    public function getPreviousPhoto($id) {
        return $this->getAdjacentPhoto($id, false);
    }

    /**
     * @param bool $next
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAdjacentPhoto($next = true, $user = null)
    {
        if ($next) {
            $ord = 'ASC';
            $comp = '>';
        } else {
            $ord = 'DESC';
            $comp = '<';
        }

        $adjacent = Photo::whereHas('likes', function (Builder $query) {
            $query->where('user_id', Auth::user()->id);
        })->orderBy('date_taken', 'asc')->orderBy('id', 'asc')->first();

        $result = self::where('album_id', $this->album_id)->where('date_taken', $comp.'=', $this->date_taken);

        if($user == null || $user->member() == null) $result = $result->where('private', false);

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


}
