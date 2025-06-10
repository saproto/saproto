<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\PhotoAlbum;
use App\Models\PhotoLikes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PhotoController extends Controller
{
    /** @return View */
    public function index()
    {
        $albums = PhotoAlbum::query()->orderBy('date_taken', 'desc')
            ->where('published', true)
            ->paginate(24);

        return view('photos.list', ['albums' => $albums]);
    }

    public function show(PhotoAlbum $album): View|RedirectResponse
    {
        $photos = $album->items()
            ->orderBy('date_taken', 'desc')
            ->withCount('likes')
            ->paginate(24);

        return view('photos.album', [
            'album' => $album,
            'photos' => $photos,
        ]);
    }

    /**
     * @return View
     */
    public function photo(Photo $photo)
    {
        $photo->load([
            'album',
        ])->loadCount([
            'likes',
        ])->loadExists([
            'likes as liked_by_me' => function ($query) {
                $query->where('user_id', Auth::id());
            },
        ]);

        return view('photos.photopage', ['photo' => $photo]);
    }

    /**
     * @return RedirectResponse
     */
    public function toggleLike(Photo $photo)
    {
        $user = Auth::user();

        $like = PhotoLikes::query()
            ->where('user_id', $user->id)
            ->where('photo_id', $photo->id)
            ->first();

        if ($like) {
            $like->delete();

            return Redirect::route('photo::view', ['photo' => $photo->id]);
        }

        PhotoLikes::query()->create([
            'photo_id' => $photo->id,
            'user_id' => $user->id,
        ]);

        return Redirect::route('photo::view', ['photo' => $photo->id]);
    }
}
