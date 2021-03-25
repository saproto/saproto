<?php

namespace Proto\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Proto\Mail\GoodIdeaReplyEmail;
use Proto\Models\GoodIdea;
use Proto\Models\GoodIdeaVote;

use Proto\Models\User;
use Session;

class GoodIdeaController extends Controller
{
    /**
     * @param int $page
     * @return \Illuminate\View\View
     */
    public function index(int $page = 1) {
        $goodIdeas = GoodIdea::orderBy('created_at', 'desc');
        return view('goodideaboard.index', ['data' => $goodIdeas->paginate(20)]);
    }

    /**
     * @param int $page
     * @return \Illuminate\View\View
     */
    public function archived($page = 1) {
        if(!Auth::user()->can('board')) {
            Session::flash('flash_message', 'You are not allowed to view archived ideas.');
            return Redirect::back();
        }
        $goodIdeas = GoodIdea::onlyTrashed()->orderBy('created_at', 'desc');
        return view('goodideaboard.archive', ['data' => $goodIdeas->paginate(20)]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function add(Request $request) {
        $temp = nl2br(trim($request->input('idea')));
        $new = ['idea' => $temp, 'user_id' => Auth::id()];
        $idea = new GoodIdea($new);
        $idea->save();
        Session::flash('flash_message', 'Idea added.');
        return Redirect::back();
    }

    /**
     * @param int $id
     * @param Request $request
     * @return mixed
     */
    public function reply(int $id, Request $request) {
        if(!Auth::user()->can('board')) {
            Session::flash('flash_message', 'You are not allowed to reply to this idea.');
            return Redirect::back();
        }

        $idea = GoodIdea::findOrFail($id);
        $reply = $request->input('reply');
        if($idea->reply == null && $reply != null) {
            $user = User::findOrFail($idea->user_id);
            Mail::to($user)->queue((new GoodIdeaReplyEmail($idea, $user, $reply))->onQueue('low'));
        }
        $idea->reply = $reply;
        $idea->save();
        Session::flash('flash_message', 'You have replied to this idea');
        return Redirect::back();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function archive(int $id) {
        if(!Auth::user()->can('board')) {
            Session::flash('flash_message', 'You are not allowed to archive this idea.');
            return Redirect::back();
        }

        $idea = GoodIdea::findOrFail($id);
        $idea->delete();
        Session::flash('flash_message', 'Good Idea archived.');
        return Redirect::back();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function restore(int $id) {
        if(!Auth::user()->can('board')) {
            Session::flash('flash_message', 'You are not allowed to restore this idea.');
            return Redirect::back();
        }

        $idea = GoodIdea::onlyTrashed()->findOrFail($id);
        $idea->restore();
        Session::flash('flash_message', 'Good Idea restored.');
        return Redirect::back();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id) {
        $idea = GoodIdea::withTrashed()->findOrFail($id);
        if(!(Auth::user()->can('board') || Auth::user()->id == $idea->user->id)) {
            Session::flash('flash_message', 'You are not allowed to delete this idea.');
            return Redirect::back();
        }

        $idea->votes()->delete();
        $idea->forceDelete();
        Session::flash('flash_message', 'Good Idea deleted.');
        return Redirect::back();
    }

    /**
     * @throws \Exception
     * @return mixed
     */
    public function archiveAll() {
        $ideas = GoodIdea::all();
        foreach($ideas as $idea) {
            $idea->delete();
        }
        return Redirect::route('goodideas::archived');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function vote(Request $request) {
        $idea = GoodIdea::findOrFail($request->input('id'));
        $vote = GoodIdeaVote::firstOrCreate(['user_id' => Auth::id(), 'good_idea_id' => $request->input('id')]);
        $value = $request->input('voteValue');
        $vote->vote = in_array($value, [-1, 0, 1]) ? $value : 0;
        $vote->save();
        return response()->json(['voteScore' => $idea->voteScore(), 'userVote' => $idea->userVote(Auth::user())]);
    }
}
