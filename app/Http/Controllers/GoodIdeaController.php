<?php

namespace Proto\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Proto\Models\GoodIdea;
use Proto\Models\GoodIdeaVote;

use Session;

class GoodIdeaController extends Controller
{
    public function index($page = 1) {
        $goodIdeas = GoodIdea::where('updated_at', '>', Carbon::now()->subWeeks(4));
        $leastVoted = null;
        $leastVotes = INF;
        foreach($goodIdeas->get() as $idea) {
            $voteCount = $idea->votes()->count();
            if($voteCount < $leastVotes) {
                $leastVotes = $voteCount;
                $leastVoted = $idea;
            }
        }
        return view('goodideaboard.index', ['data' => $goodIdeas->orderBy('created_at', 'desc')->paginate(20), 'leastVoted' => $leastVoted]);
    }

    public function add(Request $request) {
        $temp = nl2br(trim($request->input('idea')));
        $new = ['idea' => $temp, 'user_id' => Auth::id()];
        $idea = new GoodIdea($new);
        $idea->save();
        Session::flash('flash_message', 'Idea added.');
        return Redirect::route('goodideas::index');
    }

    public function delete($id) {
        $idea = GoodIdea::findOrFail($id);
        $idea->votes()->delete();
        $idea->delete();
        Session::flash('flash_message', 'Good Idea deleted.');
        return Redirect::route('goodideas::index');
    }

    public function vote(Request $request) {
        $idea = GoodIdea::findOrFail($request->input('id'));
        $vote = GoodIdeaVote::firstOrCreate(['user_id' => Auth::id(), 'good_idea_id' => $request->input('id')]);
        $vote->vote = $request->input('voteValue');
        $vote->save();
        return response()->json(['voteScore' => $idea->voteScore(), 'userVote' => $idea->userVote()]);
    }
}
