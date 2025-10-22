<?php

namespace App\Http\Controllers;

use App\Models\PlayedVideo;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ProtubeController extends Controller
{
    public function topVideos(): View
    {
        $data = (object) [
            'alltime' => $this->getTopVideos(),
            'month' => $this->getTopVideos(since: '-1 month'),
            'week' => $this->getTopVideos(since: '-1 week'),
        ];

        return view('protube.topvideos', ['data' => $data]);
    }

    public function dashboard(): View
    {
        $user_count = PlayedVideo::query()->where('user_id', Auth::user()->id)->count();
        $history = PlayedVideo::query()
            ->where('created_at', '>', Date::now()->subWeek()->format('Y-m-d'))
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        return view('protube.dashboard', [
            'history' => $history,
            'usercount' => $user_count,
            'usertop' => $this->getTopVideos(15, user: Auth::user()),
        ]);
    }

    /**
     * @return Collection<int, PlayedVideo>
     */
    private function getTopVideos(int $limit = 10, ?string $since = null, ?User $user = null): Collection
    {
        return PlayedVideo::query()
            ->select([
                'video_id',
                'video_title',
                'spotify_id',
                'spotify_name',
                DB::raw('count(*) as played_count'),
            ])
            ->when($since, function ($query) use ($since) {
                $query->where('created_at', '>', Date::parse($since)->format('Y-m-d'));
            })
            ->when($user, function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->groupBy('video_id')
            ->orderBy('played_count', 'desc')
            ->orderBy('created_at')
            ->limit($limit)->get();
    }

    public function toggleHistory(): RedirectResponse
    {
        Auth::user()->update([
            'keep_protube_history' => ! Auth::user()->keep_protube_history,
        ]);

        Session::flash('flash_message', 'Changes saved.');

        return back();
    }

    public function clearHistory(): RedirectResponse
    {
        Auth::user()->playedVideos()->update([
            'user_id' => null,
        ]);

        Session::flash('flash_message', 'History cleared.');

        return back();
    }
}
