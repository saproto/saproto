<?php

namespace Proto\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Proto\Mail\GoodIdeaReplyEmail;
use Proto\Models\Feedback;
use Proto\Models\FeedbackCategory;
use Proto\Models\FeedbackVote;
use Proto\Models\User;

class FeedBackController extends Controller
{
    /**
     * @param String $category
     * @return View
     */
    public function index(String $category): View
    {
        $category = FeedbackCategory::where('url', $category)->firstOrFail();
        $feedback = $category->feedback()->orderBy('created_at', 'desc');

        $mostVotedID = DB::table('feedback_votes')
            ->select('feedback_id', DB::raw('count(*) as votes'))
            ->groupBy('feedback_id')
            ->orderBy('votes', 'DESC')
            ->pluck('feedback_id')
            ->first();


        $mostVoted = Feedback::find($mostVotedID);

        return view('feedbackboards.index', ['data' => $feedback->orderBy('created_at', 'desc')->paginate(20), 'mostVoted' => $mostVoted, 'category'=>$category]);
    }

    public function archived($category) {
        $category = FeedbackCategory::where('url', $category)->firstOrFail();
        if(! Auth::user()->can('board')) {
            Session::flash('flash_message', 'You are not allowed to view archived feedback.');
            return Redirect::back();
        }
        $feedback = Feedback::onlyTrashed()->where('feedback_category_id', $category->id)->orderBy('created_at', 'desc');
        return view('feedbackboards.archive', ['data' => $feedback->paginate(20), 'category'=>$category]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function add(Request $request, $category)
    {
        $category = FeedbackCategory::findOrFail($category);
        $temp = nl2br(trim($request->input('idea')));
        $new = ['feedback' => $temp, 'user_id' => Auth::id(), 'feedback_category_id'=>$category->id];
        $feedback = new Feedback($new);
        $feedback->save();

        Session::flash('flash_message', 'Idea added.');
        return Redirect::back();
    }

    /**
     * @param int $id
     * @param Request $request
     * @return mixed
     */
    public function reply(int $id, Request $request) {
        if(! Auth::user()->can('board')) {
            Session::flash('flash_message', 'You are not allowed to reply to this idea.');
            return Redirect::back();
        }

        $feedback = Feedback::findOrFail($id);
        $reply = $request->input('reply');
        $accepted = $request->input('responseBtn')==="accept";

        if($feedback->reply == null && $reply != null) {
            $user = User::findOrFail($feedback->user_id);
            Mail::to($user)->queue((new GoodIdeaReplyEmail($feedback, $user, $reply, $accepted))->onQueue('low'));
        }

        $feedback->reply = $reply;
        $feedback->accepted = $accepted;
        $feedback->save();
        Session::flash('flash_message', 'You have replied to this idea');
        return Redirect::back();
    }

    public function archive(int $id) {
        if(! Auth::user()->can('board')) {
            Session::flash('flash_message', 'You are not allowed to archive this idea.');
            return Redirect::back();
        }

        $feedback = Feedback::findOrFail($id);
        $feedback->delete();
        Session::flash('flash_message', 'Good Idea archived.');
        return Redirect::back();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function restore(int $id) {
        if(! Auth::user()->can('board')) {
            Session::flash('flash_message', 'You are not allowed to restore this idea.');
            return Redirect::back();
        }

        $feedback = Feedback::onlyTrashed()->findOrFail($id);
        $feedback->restore();
        Session::flash('flash_message', 'Good Idea restored.');
        return Redirect::back();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id) {
        $feedback = Feedback::withTrashed()->findOrFail($id);
        if(! (Auth::user()->can('board') || Auth::user()->id == $feedback->user->id)) {
            Session::flash('flash_message', 'You are not allowed to delete this idea.');
            return Redirect::back();
        }

        $feedback->votes()->delete();
        $feedback->forceDelete();
        Session::flash('flash_message', 'Good Idea deleted.');
        return Redirect::back();
    }

    /**
     * @return RedirectResponse
     * @throws Exception
     */
    public function archiveAll($category) {
        $category = FeedbackCategory::where('url', $category)->firstOrFail();
        $feedback = $category->feedback;
        foreach($feedback as $item) {
            $item->delete();
        }
        return Redirect::route('feedback::category::archived', ['category' => $category->url]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function vote(Request $request)
    {
        $feedback = Feedback::findOrFail($request->input('id'));

        /** @var FeedbackVote $vote */
        $vote = FeedbackVote::firstOrCreate(['user_id' => Auth::id(), 'feedback_id' => $request->input('id')]);
        if($vote->vote === $request->input('voteValue')){
            $vote->delete();
        }else {
            $vote->vote = $request->input('voteValue') > 0 ? 1 : -1;
            $vote->save();
        }
        return response()->json(['voteScore' => $feedback->voteScore(), 'userVote' => $feedback->userVote(Auth::user())]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function categoryAdmin(Request $request)
    {
        $category = FeedbackCategory::find($request->id);
        return view('feedbackboards.categories', ['cur_category' => $category]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function categoryStore(Request $request)
    {
        $category = new FeedbackCategory();
        $category->title = $request->input('name');
        $category->url = strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $request->input('name')));
        $category->review = $request->has('reviewed');
        $category->reviewer_id = $request->has('reviewed')?$request->input('user_id'):null;

        $category->save();

        Session::flash('flash_message', 'The category '.$category->title.' has been created.');
        return Redirect::back();
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function categoryUpdate(Request $request, $id)
    {
        $category = FeedbackCategory::findOrFail($id);
        $category->title = $request->input('name');
        $category->url = strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $request->input('name')));
        $category->review = $request->has('reviewed');
        $category->reviewer_id = $request->has('reviewed')?$request->input('user_id'):null;

        $category->save();

        Session::flash('flash_message', 'The category '.$category->name.' has been updated.');
        return Redirect::back();
    }

    /**
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function categoryDestroy($id)
    {
        $category = FeedbackCategory::findOrFail($id);
        $feedback = $category->feedback;
        if ($feedback) {
            foreach ($feedback as $item) {
                $item->category()->dissociate();
            }
        }
        $category->delete();

        Session::flash('flash_message', 'The category '.$category->name.' has been deleted.');
        return Redirect::route('feedback::category::admin', ['category' => null]);
    }
}
