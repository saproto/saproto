<?php

namespace App\Http\Controllers;

use App\Data\PhotoAlbumData;
use App\Models\Photo;
use Illuminate\Database\Eloquent\Builder;
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
        return view('photos.album', [
            'album' => null,
            'photos' => $this->getLikedPhotosQuery()->paginate(24),
        ]);
    }

    public function photo(HttpRequest $request): Response
    {

        return Inertia::render('Photos/Photo',
            [
                'photo' => $request->get('photo'),
                'album' => PhotoAlbumData::from([
                    'id' => 'liked',
                    'name' => 'My liked photos',
                    'private' => false,
                    'items' => $this->getLikedPhotosQuery()->get(),
                ]),
                'emaildomain' => Config::string('proto.emaildomain'),
            ]);
    }

    /**
     * @return Builder<Photo>
     */
    private function getLikedPhotosQuery(): Builder
    {
        return Photo::query()
            ->whereHas('likes', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->with('album')
            ->withCount('likes')
            ->withExists([
                'likes as liked_by_me' => function ($query) {
                    $query->where('user_id', Auth::id());
                },
            ])->orderBy('date_taken');
    }
}
