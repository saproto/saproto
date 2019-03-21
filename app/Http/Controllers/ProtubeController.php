<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use DB;
use Session;
use Redirect;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;
use Proto\Models\PlayedVideo;
use Proto\Models\SoundboardSound;

class ProtubeController extends Controller
{
    public function admin()
    {
        if (Auth::user()->can('protube') || Auth::user()->isTempadmin()) {
            $sounds = SoundboardSound::where('hidden', '=', false)->get();
            return view('protube.admin', ['sounds' => $sounds]);
        } else {
            abort(403);
        }
    }

    public function screen(Request $request)
    {
        return view('protube.screen', ['showPin' => $request->has('showPin')]);
    }

    public function offline()
    {
        return view('protube.offline');
    }

    public function remote()
    {
        return view('protube.remote');
    }

    public function loginRedirect()
    {
        return redirect(route("protube::remote"));
    }

    public function topVideos()
    {
        $data = (object)[
            'alltime' => $this->getTopVideos(10),
            'month' => $this->getTopVideos(10, '-1 month'),
            'week' => $this->getTopVideos(10, '-1 week'),
        ];
        return view('protube.topvideos', ['data' => $data]);
    }

    public function dashboard()
    {
        $usercount = PlayedVideo::where('user_id', Auth::user()->id)->count();
        return view('protube.dashboard', [
            'history' => $this->getHistory(),
            'usercount' => $usercount,
            'user' => Auth::user(),
            'usertop' => $this->getTopVideos(15, null, Auth::user())
        ]);
    }

    private function getHistory($since = '-1 week', $user = null, $max = 50)
    {
        $query = DB::table('playedvideos')
            ->select(DB::raw('video_id, video_title, spotify_id, spotify_name, created_at as played_at'))
            ->where('created_at', '>', date('Y-m-d', strtotime($since)));

        if ($user) {
            $query = $query->where('user_id', $user->id);
        }

        return $query->orderBy('created_at', 'desc')->limit($max)->get()->all();
    }

    private function getTopVideos($limit = 10, $since = '2011-04-20', $user = null)
    {
        $query = DB::table('playedvideos')
            ->select(DB::raw('video_id, video_title, spotify_id, spotify_name, count(*) as played_count'))
            ->where('created_at', '>', date('Y-m-d', strtotime($since)));

        if ($user) {
            $query = $query->where('user_id', $user->id);
        }

        return $query->groupBy('video_id')
            ->orderBy('played_count', 'desc')
            ->orderBy('created_at', 'asc')
            ->limit($limit)->get()->all();
    }

    public function toggleHistory()
    {
        $user = Auth::user();
        $user->keep_protube_history = !$user->keep_protube_history;
        $user->save();

        Session::flash('flash_message', 'Changes saved.');
        return Redirect::back();
    }

    public function clearHistory()
    {
        $user = Auth::user();
        PlayedVideo::where('user_id', $user->id)->update(['user_id' => null]);

        Session::flash('flash_message', 'History cleared.');
        return Redirect::back();
    }
}
