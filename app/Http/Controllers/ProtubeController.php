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
     * @return \Illuminate\Support\Collection
     */
    private function getTopVideos(int $limit = 10, ?string $since = null, ?User $user = null): \Illuminate\Support\Collection
    {
        $top = PlayedVideo::query()
            ->select([
                'video_id',
                DB::raw('COUNT(*) as played_count'),
            ])
            ->when($user, fn ($q) => $q->where('user_id', $user->id))
            ->when($since, fn ($q) => $q->where('created_at', '>', Date::parse($since)->format('Y-m-d')))
            ->groupBy('video_id')
            ->orderByDesc('played_count')
            ->limit($limit)
            ->get()
            ->keyBy('video_id');

        $videos = PlayedVideo::query()
            ->whereIn('video_id', $top->keys())
            ->select(['video_id', 'video_title', 'spotify_id', 'spotify_name'])
            ->distinct()
            ->get();

        $videos = $videos->map(function ($video) use ($top) {
            $stats = $top[$video->video_id];
            $video->played_count = $stats->played_count;
            $video->first_played = $stats->first_played;
            return $video;
        });

        return $videos
            ->sortByDesc(fn ($v) => $top[$v->video_id]->played_count)
            ->values();
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
