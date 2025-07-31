<?php

namespace App\Http\Controllers;

use App\Data\PhotoAlbumData;
use App\Models\Photo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;

class LikedPhotosController extends Controller
{
    public function show(): View|RedirectResponse
    {
        $myLikedPhotos = Photo::query()
            ->whereHas('likes', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->with('album')
            ->withCount('likes')
            ->withExists([
                'likes as liked_by_me' => function ($query) {
                    $query->where('user_id', Auth::id());
                },
            ]);

        return view('photos.album', [
            'album' => null,
            'photos' => $myLikedPhotos->paginate(24),
        ]);
    }

    public function photo(HttpRequest $request): Response
    {
        $myLikedPhotos = Photo::query()
            ->whereHas('likes', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->with('album')
            ->withCount('likes')
            ->withExists([
                'likes as liked_by_me' => function ($query) {
                    $query->where('user_id', Auth::id());
                },
            ])->get();

        return Inertia::render('Photos/Photo',
            [
                'photo' => $request->get('photo'),
                'album' => PhotoAlbumData::from([
                    'id' => 'liked',
                    'name' => 'My liked photos',
                    'private' => false,
                    'items' => $myLikedPhotos,
                ]),
                'emaildomain' => Config::string('proto.emaildomain'),
            ]);
    }
}
