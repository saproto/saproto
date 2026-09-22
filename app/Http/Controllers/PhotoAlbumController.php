<?php

namespace App\Http\Controllers;

use App\Data\PhotoAlbumData;
use App\Models\Photo;
use App\Models\PhotoAlbum;
use App\Models\PhotoLikes;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;

class PhotoAlbumController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View|Factory
    {
        $albums = PhotoAlbum::query()->orderByDesc('date_taken')
            ->where('published', true)
            ->paginate(24);

        return view('photos.list', ['albums' => $albums]);
    }

    public function show(PhotoAlbum $album): View|RedirectResponse
    {
        return view('photos.album', [
            'album' => $album,
            'photos' => $album->items()
                ->withCount('likes')
                ->withExists([
                    'likes as liked_by_me' => function ($query) {
                        $query->where('user_id', Auth::id());
                    },
                ])
                ->paginate(12),
        ]);
    }

    public function photo(HttpRequest $request, PhotoAlbum $album): Response
    {
        $items = Cache::rememberForever("album::{$album->id}::items", fn () => $album->items()->withoutGlobalScopes()->get());

        if (! Auth::user()?->is_member) {
            $items = $items->filter(fn ($item) => ! $item->private)->values();
        }

        $items->loadCount('likes')
            ->loadExists([
                'likes as liked_by_me' => function ($query) {
                    $query->where('user_id', Auth::id());
                },
            ]);

        $album->setRelation('items', $items);

        return Inertia::render('Photos/Photo',
            [
                'photo' => $request->input('photo'),
                'album' => PhotoAlbumData::from($album),
                'emaildomain' => Config::string('proto.emaildomain'),
            ]);
    }

    public function toggleLike(Photo $photo): JsonResponse
    {
        $user = Auth::user();

        $like = PhotoLikes::query()
            ->where('user_id', $user->id)
            ->where('photo_id', $photo->id)
            ->first();

        if ($like) {
            $like->delete();

            return new JsonResponse(['likes_count' => $photo->likes()->count(), 'liked_by_me' => false]);
        }

        PhotoLikes::query()->create([
            'photo_id' => $photo->id,
            'user_id' => $user->id,
        ]);

        return new JsonResponse(['likes_count' => $photo->likes()->count(), 'liked_by_me' => true]);
    }
}
