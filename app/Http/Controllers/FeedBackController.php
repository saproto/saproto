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
use Proto\Mail\FeedbackReply;
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

        //find the most voted idea
        $mostVotedID=FeedbackVote::query()
                                    ->selectRaw('feedback_id, sum(vote) as votes')
                                    ->groupBy('feedback_id')
                                    ->having('votes', '>=', 0)
                                    ->orderBy('votes')
                                    ->first();
        $mostVoted=Feedback::where('id',$mostVotedID?$mostVotedID->feedback_id:null)->first();

        $unreviewed=Feedback::where('reviewed', false);

        //only get the reviewed ideas if they require it
        if($category->review && Auth::user()->id!==$category->reviewer_id){
            $feedback=$feedback->where('reviewed', true);
            $unreviewed=Feedback::where('user_id', Auth::user()->id);
        }

        return view('feedbackboards.index', ['data' => $feedback->paginate(20), 'mostVoted' => $mostVoted??null, 'category'=>$category, 'unreviewed'=>$unreviewed->get()]);
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

        if($category->review){
            Session::flash('flash_message', 'Idea added. This first needs to be reviewed by the board so it might take some time to show up!');
        }else{
            Session::flash('flash_message', 'Idea added.');
        }

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
            Mail::to($user)->queue((new FeedbackReply($feedback, $user, $reply, $accepted))->onQueue('low'));
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

        $feedback = Feedback::withTrashed()->findOrFail($id);
            if($feedback->trashed()){
                $feedback->restore();
                Session::flash('flash_message', 'Good Idea restored.');
            }else {
                $feedback->delete();
                Session::flash('flash_message', 'Good Idea archived.');
            }
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
        return Redirect::route('feedback::archived', ['category' => $category->url]);
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
     * @param int $id
     * @return RedirectResponse
     */
    public function approve(int $id): RedirectResponse
    {
        $feedback = Feedback::findOrFail($id);
        if($feedback->category->reviewer_id!==Auth::user()->id){
            Session::flash('flash_message', "Feedback may only be approved by the dedicated reviewer!");
            return Redirect::back();
        }
        $feedback->reviewed=true;
        $feedback->save();
        Session::flash('flash_message', "Feedback Approved to be public!");
        return Redirect::back();
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
        if($request->has('reviewed')&&!$request->input('user_id')){
            Session::flash('flash_message', 'You need to enter a reviewer to have this as a reviewed category!');
            return Redirect::back();
        }
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
