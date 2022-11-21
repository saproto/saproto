<?php

namespace Proto\Http\Controllers;

use DB;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Proto\Models\GoodIdea;
use Proto\Models\GoodIdeaCategory;
use Proto\Models\GoodIdeaVote;
use Illuminate\Support\Facades\Mail;
use Proto\Mail\GoodIdeaReplyEmail;
use Proto\Models\User;
use Session;

class FeedBackController extends Controller
{
    /**
     * @param int $page
     * @return View
     */
    public function index(String $category): View
    {
        $category=GoodIdeaCategory::where('url', $category)->firstOrFail();
        $goodIdeas = $category->ideas()->orderBy('created_at', 'desc');

        $mostVotedID = DB::table('good_idea_votes')
            ->select('good_idea_id', DB::raw('count(*) as votes'))
            ->groupBy('good_idea_id')
            ->orderBy('votes', 'DESC')
            ->pluck('good_idea_id')
            ->first();

        $mostVoted=GoodIdea::find($mostVotedID);

        return view('goodideaboard.index', ['data' => $goodIdeas->orderBy('created_at', 'desc')->paginate(20), 'mostVoted' => $mostVoted, 'category'=>$category]);
    }

    public function archived($category) {
        $category=GoodIdeaCategory::where('url', $category)->firstOrFail();
        if(!Auth::user()->can('board')) {
            Session::flash('flash_message', 'You are not allowed to view archived ideas.');
            return Redirect::back();
        }
        $goodIdeas = GoodIdea::onlyTrashed()->where('idea_category_id', $category->id)->orderBy('created_at', 'desc');
        return view('goodideaboard.archive', ['data' => $goodIdeas->paginate(20), 'category'=>$category]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function add(Request $request, $category)
    {
        $category = GoodIdeaCategory::findOrFail($category);
        $temp = nl2br(trim($request->input('idea')));
        $new = ['idea' => $temp, 'user_id' => Auth::id(), 'idea_category_id'=>$category->id];
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
     * @return RedirectResponse
     * @throws Exception
     */
    public function archiveAll($category) {
        $category = GoodIdeaCategory::findOrFail($category);
        $ideas = $category->ideas();
        foreach($ideas as $idea) {
            $idea->delete();
        }
        return Redirect::route('feedback::category:archived', ['category' => $category]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function vote(Request $request)
    {
        $idea = GoodIdea::findOrFail($request->input('id'));

        /** @var GoodIdeaVote $vote */
        $vote = GoodIdeaVote::firstOrCreate(['user_id' => Auth::id(), 'good_idea_id' => $request->input('id')]);
        if($vote->vote===$request->input('voteValue')){
            $vote->delete();
        }else {
            $vote->vote = $request->input('voteValue') > 0 ? 1 : -1;
            $vote->save();
        }
        return response()->json(['voteScore' => $idea->voteScore(), 'userVote' => $idea->userVote(Auth::user())]);
    }
}
