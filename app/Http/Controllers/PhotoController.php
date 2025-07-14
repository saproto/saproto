<?php

namespace App\Http\Controllers;

use App\Data\PhotoAlbumData;
use App\Data\PhotoData;
use App\Models\Photo;
use App\Models\PhotoAlbum;
use App\Models\PhotoLikes;
use Config;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;

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

    public function photo(Photo $photo): Response
    {
        $album = PhotoAlbum::query()->whereHas('items', function ($query) use ($photo) {
            $query->where('id', $photo->id);
        })->with(['items' => function ($q) {
            $q->withCount('likes')->withExists([
                'likes as liked_by_me' => function ($query) {
                    $query->where('user_id', Auth::id());
                },
            ])->orderBy('date_taken', 'desc')
                ->orderBy('id');
        }])->first();

        return Inertia::render('Photos/Photo',
            [
                'photo' => PhotoData::from($photo),
                'album' => PhotoAlbumData::from($album),
                'emaildomain' => Config::string('proto.emaildomain'),
            ]);
    }

    public function toggleLike(Photo $photo): RedirectResponse
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
