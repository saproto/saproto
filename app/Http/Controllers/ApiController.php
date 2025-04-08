<?php

namespace App\Http\Controllers;

use App\Models\AchievementOwnership;
use App\Models\ActivityParticipation;
use App\Models\EmailListSubscription;
use App\Models\Feedback;
use App\Models\FeedbackCategory;
use App\Models\FeedbackVote;
use App\Models\OrderLine;
use App\Models\PhotoAlbum;
use App\Models\PhotoLikes;
use App\Models\PlayedVideo;
use App\Models\RfidCard;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Random\RandomException;
use stdClass;

class ApiController extends Controller
{
    /** @return JsonResponse */
    public function protubeUserDetails()
    {
        $user = Auth::user();

        if ($user) {
            return response()->json([
                'authenticated' => true,
                'name' => $user->calling_name,
                'admin' => $user->hasPermissionTo('protube', 'web') || $user->isTempadmin() || $user->isTempadminLaterToday(),
                'id' => $user->id,
            ]);
        }

        return response()->json(['authenticated' => false]);
    }

    public function protubePlayed(Request $request): void
    {
        abort_if($request->secret != Config::string('protube.protube_to_laravel_secret'), 403);

        $playedVideo = new PlayedVideo;
        $user = User::query()->findOrFail($request->user_id);

        if ($user->keep_protube_history) {
            $playedVideo->user()->associate($user);
        }

        $playedVideo->video_id = $request->video_id;
        $playedVideo->video_title = urldecode($request->video_title);

        $playedVideo->save();

        PlayedVideo::query()->where('video_id', $playedVideo->video_id)->update(['video_title' => $playedVideo->video_title]);
    }

    /**
     * @return JsonResponse
     */
    public function getToken(Request $request)
    {
        $response = new stdClass;

        if (Auth::check()) {
            $response->name = Auth::user()->name;
            $response->photo = Auth::user()->generatePhotoPath(250, 250);
            $response->token = Auth::user()->getToken()->token;
        } else {
            $response->token = 0;
        }

        if ($request->has('callback')) {
            return response()->json($response)->setCallback($request->input('callback'));
        }

        return response()->json($response);
    }

    /**
     * @throws RandomException
     */
    public function randomAlbum(): JsonResponse
    {
        $privateQuery = PhotoAlbum::query()->where('private', false)->where('published', true)->whereHas('items', static function ($query) {
            $query->where('private', false);
        })->with(['items' => function ($q) {
            $q->inRandomOrder()->take(6);
        }])->without('thumbPhoto');

        $random = random_int(1, 100);
        if ($random <= 30) { // 30% chance the album is from within the last year
            $query = (clone $privateQuery)->whereBetween('date_taken', [Carbon::now()->subYear()->timestamp, Carbon::now()->timestamp]);
        } elseif ($random <= 55) { // 25% chance the album is from one year ago
            $query = (clone $privateQuery)->whereBetween('date_taken', [Carbon::now()->subYears(2)->timestamp, Carbon::now()->subYear()->timestamp]);
        } elseif ($random <= 70) {// 15% chance the album is from two years ago
            $query = (clone $privateQuery)->whereBetween('date_taken', [Carbon::now()->subYears(3)->timestamp, Carbon::now()->subYears(2)->timestamp]);
        } elseif ($random <= 80) {// 10% chance the album is from three years ago
            $query = (clone $privateQuery)->whereBetween('date_taken', [Carbon::now()->subYears(4)->timestamp, Carbon::now()->subYears(3)->timestamp]);
        } else {// 20% chance the album is older than 4 years
            $query = (clone $privateQuery)->where('date_taken', '<=', Carbon::now()->subYears(4)->timestamp);
        }

        $album = $query->inRandomOrder()->first();

        //        if we picked a year and therefore a query where no albums exist, pick a random public album as fallback
        if (! $album) {
            $album = $privateQuery->inRandomOrder()->first();
        }

        // if we still do not have an album, there are no public albums
        if (! $album) {
            return response()->json(['error' => 'No public photos found!.'], 404);
        }

        return response()->JSON([
            'photos' => $album->items->pluck('url'),
            'album_name' => $album->name,
            'date_taken' => Carbon::createFromTimestamp($album->date_taken, CarbonTimeZone::create(config('app.timezone')))->format('d-m-Y'),
        ]);
    }

    public function gdprExport(): array
    {
        $user = Auth::user();
        $data = [];

        $data['user'] = $user->makeHidden(['id', 'member', 'photo', 'address', 'bank']);

        $data['member'] = $user->is_member ? $user->member->makeHidden(['id', 'user_id']) : null;

        $data['address'] = $user->address ? $user->address->makeHidden(['user_id']) : null;

        $data['bank_account'] = $user->bank ? $user->bank->makeHidden(['id', 'user_id']) : null;

        foreach (RfidCard::query()->where('user_id', $user->id)->get() as $rfid_card) {
            $data['rfid_cards'][] = [
                'card_id' => $rfid_card->card_id,
                'name' => $rfid_card->name,
                'added_at' => $rfid_card->created_at,
            ];
        }

        foreach (ActivityParticipation::query()->with(['activity.event', 'help.committee'])->where('user_id', $user->id)->get() as $activity_participation) {
            $data['activities'][] = [
                'name' => $activity_participation->activity?->event?->title,
                'date' => $activity_participation->activity?->event ? date('Y-m-d', $activity_participation->activity->event->start) : null,
                'was_present' => $activity_participation->is_present,
                'helped_as' => $activity_participation->help ? $activity_participation->help->committee->name : null,
                'backup' => $activity_participation->backup,
                'created_at' => $activity_participation->created_at,
                'updated_at' => $activity_participation->updated_at,
                'deleted_at' => $activity_participation->deleted_at,

            ];
        }

        foreach (OrderLine::query()->with(['molliePayment', 'withdrawal', 'product'])->where('user_id', $user->id)->get() as $orderline) {
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

        foreach (PlayedVideo::query()->where('user_id', $user->id)->get() as $playedvideo) {
            $data['played_videos'][] = [
                'youtube_id' => $playedvideo->video_id,
                'youtube_name' => $playedvideo->video_title,
                'spotify_id' => $playedvideo->spotify_id != '' ? $playedvideo->spotify_id : null,
                'spotify_name' => $playedvideo->spotify_id != '' ? $playedvideo->spotify_name : null,
                'played_at' => $playedvideo->created_at,
            ];
        }

        foreach (EmailListSubscription::query()->with('emaillist')->where('user_id', $user->id)->get() as $list_subscription) {
            $data['list_subscription'][] = $list_subscription->emaillist ? $list_subscription->emaillist->name : null;
        }

        foreach (AchievementOwnership::query()->with('achievement')->where('user_id', $user->id)->get() as $achievement_granted) {
            $data['achievements'][] = [
                'name' => $achievement_granted->achievement->name,
                'description' => $achievement_granted->achievement->desc,
                'granted_on' => $achievement_granted->created_at,
            ];
        }

        foreach (PhotoLikes::query()->with('photo')->where('user_id', $user->id)->get() as $photo_like) {
            $data['liked_photos'][] = $photo_like->photo->url;
        }

        foreach ($user->stickers()->get() as $sticker) {
            $data['stickers'][] = [
                'lat' => $sticker->lat,
                'lng' => $sticker->lng,
                'city' => $sticker->city,
                'country' => $sticker->country,
                'country_code' => $sticker->country_code,
            ];
        }

        foreach (FeedbackCategory::all() as $category) {
            foreach (Feedback::query()->where('user_id', $user->id)->where('feedback_category_id', $category->id)->get() as $feedback) {
                $data["placed_$category->url"][] = [
                    'feedback' => $feedback->feedback,
                    'created_at' => $feedback->created_at,
                    'accepted' => $feedback->accepted,
                    'reply' => $feedback->reply,
                ];
            }

            foreach (FeedbackVote::query()->with('feedback')->where('user_id', $user->id)->whereHas('feedback', static function ($q) use ($category) {
                $q->where('feedback_category_id', $category->id);
            })->get() as $feedbackVote) {
                $data["liked_$category->url"][] = [
                    'feedback' => $feedbackVote->feedback->feedback,
                    'liked_at' => $feedbackVote->created_at,
                ];
            }
        }

        return $data;
    }

    public function discordVerifyMember($userId): JsonResponse
    {
        $user = User::query()->firstWhere('discord_id', $userId);

        if (! $user) {
            return response()->json(['error' => 'No Proto user found with this Discord account linked.'], 404);
        }

        if (! $user->is_member) {
            return response()->json(['error' => 'Failed to verify Proto membership. Please visit the Proto website to confirm your membership is approved.'], 403);
        }

        return response()->json(['name' => $user->calling_name]);
    }
}
