<?php

namespace Proto\Http\Controllers;

use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Input;
use Proto\Models\AchievementOwnership;
use Proto\Models\ActivityParticipation;
use Proto\Models\EmailListSubscription;
use Proto\Models\OrderLine;
use Proto\Models\PhotoLikes;
use Proto\Models\PlayedVideo;
use Proto\Models\Quote;
use Proto\Models\QuoteLike;
use Proto\Models\RfidCard;
use Proto\Models\Token;
use Proto\Models\User;
use stdClass;

class ApiController extends Controller
{
    /**
     * @param Request $request
     * @return string
     */
    public function train(Request $request)
    {
        return stripslashes(file_get_contents('http://@ews-rpx.ns.nl/mobile-api-avt?station='.$_GET['station']));
    }

    /**
     * @param $token
     * @return false|string
     */
    public function protubeAdmin($token)
    {
        $token = Token::where('token', $token)->first();

        $adminInfo = new stdClass();

        if (! $token) {
            $adminInfo->is_admin = false;
        } else {
            $user = $token->user;
            if (! $user) {
                $adminInfo->is_admin = false;
            } else {
                $adminInfo->user_id = $user->id;
                $adminInfo->user_name = $user->name;
                $adminInfo->calling_name = $user->calling_name;
                $adminInfo->is_admin = $user->can('protube') || $user->isTempadmin();
            }
        }

        return json_encode($adminInfo);
    }

    /** @param Request $request */
    public function protubePlayed(Request $request)
    {
        if ($request->secret != config('herbert.secret')) {
            abort(403);
        }

        $playedVideo = new PlayedVideo();

        $token = Token::where('token', $request->token)->first();

        if ($token) {
            /** @var User $user */
            $user = $token->user()->first();
            if ($user->keep_protube_history) {
                $playedVideo->user()->associate($user);
            }
        }

        $playedVideo->video_id = $request->video_id;
        $playedVideo->video_title = urldecode($request->video_title);

        $playedVideo->save();

        PlayedVideo::where('video_id', $playedVideo->video_id)->update(['video_title' => $playedVideo->video_title]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getToken(Request $request)
    {
        $response = new stdClass();

        if (Auth::check()) {
            $response->name = Auth::user()->name;
            $response->photo = Auth::user()->generatePhotoPath(250, 250);
            $response->token = Auth::user()->getToken()->token;
        } else {
            $response->token = 0;
        }

        if ($request->has('callback')) {
            return response()->json($response)->setCallback(Input::get('callback'));
        } else {
            return response()->json($response);
        }
    }

    public function fishcamStream()
    {
        header('Content-Transfer-Encoding: binary');
        header('Content-Type: multipart/x-mixed-replace; boundary=video-boundary--');
        header('Cache-Control: no-cache');
        $handle = fopen(env('FISHCAM_URL'), 'r');
        while ($data = fread($handle, 8192)) {
            echo $data;
            ob_flush();
            flush();
            set_time_limit(0);
        }
    }

    /** @return array */
    public function gdprExport()
    {
        $user = Auth::user();
        $data = [];

        $data['user'] = $user->makeHidden(['id', 'member', 'photo', 'address', 'bank']);

        $data['member'] = $user->is_member ? $user->member->makeHidden(['id', 'user_id']) : null;

        $data['address'] = $user->address ? $user->address->makeHidden(['user_id']) : null;

        $data['bank_account'] = $user->bank ? $user->bank->makeHidden(['id', 'user_id']) : null;

        foreach (RfidCard::where('user_id', $user->id)->get() as $rfid_card) {
            $data['rfid_cards'][] = [
                'card_id' => $rfid_card->card_id,
                'name' => $rfid_card->name,
                'added_at' => $rfid_card->created_at,
            ];
        }

        foreach (ActivityParticipation::where('user_id', $user->id)->get() as $activity_participation) {
            $data['activities'][] = [
                'name' => $activity_participation->activity && $activity_participation->activity->event ? $activity_participation->activity->event->title : null,
                'date' => $activity_participation->activity && $activity_participation->activity->event ? date('Y-m-d', $activity_participation->activity->event->start) : null,
                'was_present' => $activity_participation->is_present,
                'helped_as' => $activity_participation->help ? $activity_participation->help->committee->name : null,
                'backup' => $activity_participation->backup,
                'created_at' => $activity_participation->created_at,
                'updated_at' => $activity_participation->updated_at,
                'deleted_at' => $activity_participation->deleted_at,

            ];
        }

        foreach (OrderLine::where('user_id', $user->id)->get() as $orderline) {
            $payment_method = null;
            if ($orderline->payed_with_cash) {
                $payment_method = 'cash_cashier';
            } elseif ($orderline->payed_with_bank_card) {
                $payment_method = 'bank_card_cashier';
            } elseif ($orderline->molliePayment) {
                $payment_method = sprintf('mollie_%s', $orderline->molliePayment->mollie_id);
            } elseif ($orderline->withdrawal) {
                $payment_method = sprintf('withdrawal_%s', $orderline->withdrawal->id);
            }
            $data['orders'][] = [
                'product' => $orderline->product->name,
                'units' => $orderline->units,
                'total_price' => $orderline->total_price,
                'payed_with' => $payment_method,
                'order_date' => $orderline->created_at,
            ];
        }

        foreach (PlayedVideo::where('user_id', $user->id)->get() as $playedvideo) {
            $data['played_videos'][] = [
                'youtube_id' => $playedvideo->video_id,
                'youtube_name' => $playedvideo->video_title,
                'spotify_id' => $playedvideo->spotify_id != '' ? $playedvideo->spotify_id : null,
                'spotify_name' => $playedvideo->spotify_id != '' ? $playedvideo->spotify_name : null,
                'played_at' => $playedvideo->created_at,
            ];
        }

        foreach (EmailListSubscription::where('user_id', $user->id)->get() as $list_subscription) {
            $data['list_subscription'][] = $list_subscription->emaillist ? $list_subscription->emaillist->name : null;
        }

        foreach (AchievementOwnership::where('user_id', $user->id)->get() as $achievement_granted) {
            $data['achievements'][] = [
                'name' => $achievement_granted->achievement->name,
                'description' => $achievement_granted->achievement->desc,
                'granted_on' => $achievement_granted->created_at,
            ];
        }

        foreach (PhotoLikes::where('user_id', $user->id)->get() as $photo_like) {
            $data['liked_photos'][] = $photo_like->photo->url;
        }

        foreach (Quote::where('user_id', $user->id)->get() as $quote) {
            $data['placed_quotes'][] = [
                'quote' => $quote->quote,
                'created_at' => $quote->created_at,
            ];
        }

        foreach (QuoteLike::where('user_id', $user->id)->get() as $quote) {
            $data['liked_quotes'][] = [
                'quote' => $quote->quote,
                'liked_at' => $quote->created_at,
            ];
        }

        return $data;
    }
}
