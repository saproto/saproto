<?php

namespace App\Http\Controllers;

use App\Enums\PhotoEnum;
use App\Models\AchievementOwnership;
use App\Models\ActivityParticipation;
use App\Models\EmailListSubscription;
use App\Models\Feedback;
use App\Models\FeedbackCategory;
use App\Models\FeedbackVote;
use App\Models\OrderLine;
use App\Models\Photo;
use App\Models\PhotoAlbum;
use App\Models\PhotoLikes;
use App\Models\PlayedVideo;
use App\Models\RfidCard;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Random\RandomException;

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
        if ($request->secret != Config::string('protube.protube_to_laravel_secret')) {
            abort(403);
        }

        $user = User::query()->findOrFail($request->user_id);
        $youtubeId = $request->video_id;
        $duration_played = $request->duration_played;
        $earlierSpotifyMatch = PlayedVideo::query()->where('video_id', $youtubeId)->whereNotNull('spotify_id')->orderBy('created_at', 'desc')->first();
        $title = urldecode($request->video_title);
        PlayedVideo::query()->create([
            'video_id' => $request->video_id,
            'video_title' => $title,
            'user_id' => $user->keep_protube_history ? $user->id : null,
            'spotify_id' => $earlierSpotifyMatch?->spotify_id,
            'spotify_name' => $earlierSpotifyMatch?->spotify_name,
            'duration_played' => $duration_played,
        ]);
        PlayedVideo::query()->where('video_id', $youtubeId)->update(['video_title' => $title]);
    }

    /**
     * @throws RandomException
     */
    public function randomAlbum(): JsonResponse
    {
        // 30% chance the normal photo album is from the last year
        // 55-30 = 25% chance the album is from one year ago
        // 70-55 = 15% chance the album is from two years ago
        // 80-70 = 10% chance the album is from three years ago
        // 100-80 = 20% chance the album is older than 4 years
        $normal_distribution = [30, 55, 70, 80];

        // 10% chance the old photo is from the last year
        // 30-10 = 20% chance the album is from one year ago
        // 50-30 = 20% chance the album is from two years ago
        // 70-50 = 20% chance the album is from three years ago
        // 100-70 = 30% chance the album is older than 4 years
        $old_distribution = [10, 30, 50, 70];

        $photosData = $this->randomDistributedAlbum($normal_distribution);
        $oldPhotosData = $this->randomDistributedAlbum($old_distribution);
        if (isset($photosData['error'])) {
            return response()->json(['error' => 'Failed to retrieve "photos": '.$photosData['error']], 500);
        }

        if (isset($oldPhotosData['error'])) {
            return response()->json(['error' => 'Failed to retrieve "old_photos": '.$oldPhotosData['error']], 500);
        }

        return response()->json([
            'photos' => $photosData,
            'old_photos' => $oldPhotosData,
        ]);
    }

    /**
     * @param  array{0: int, 1: int, 2: int, 3: int}  $numbers
     * @return array{photos: Collection<int, string>, album_name: string, date_taken: non-falsy-string}|array{error: string}
     *
     * @throws RandomException
     */
    private function randomDistributedAlbum(array $numbers): array
    {
        $privateQuery = PhotoAlbum::query()->where('private', false)->where('published', true)->whereHas('items', static function ($query) {
            $query->where('private', false);
        })->with(['items' => function ($q) {
            $q->reorder()->inRandomOrder()->take(6);
        }])->without('thumbPhoto');

        $random = random_int(1, 100);
        if ($random <= $numbers[0]) { // $numbers[0]% chance the album is from within the last year
            $query = (clone $privateQuery)->whereBetween('date_taken', [Carbon::now()->subYear()->timestamp, Carbon::now()->timestamp]);
        } elseif ($random <= $numbers[1]) { // $numbers[1] - $numbers[0]% chance the album is from one year ago
            $query = (clone $privateQuery)->whereBetween('date_taken', [Carbon::now()->subYears(2)->timestamp, Carbon::now()->subYear()->timestamp]);
        } elseif ($random <= $numbers[2]) {// $numbers[2] - $numbers[1]% chance the album is from two years ago
            $query = (clone $privateQuery)->whereBetween('date_taken', [Carbon::now()->subYears(3)->timestamp, Carbon::now()->subYears(2)->timestamp]);
        } elseif ($random <= $numbers[3]) {// $numbers[3] - $numbers[2]% chance the album is from three years ago
            $query = (clone $privateQuery)->whereBetween('date_taken', [Carbon::now()->subYears(4)->timestamp, Carbon::now()->subYears(3)->timestamp]);
        } else {// 100 - $numbers[3]% chance the album is older than 4 years
            $query = (clone $privateQuery)->where('date_taken', '<=', Carbon::now()->subYears(4)->timestamp);
        }

        $album = $query->inRandomOrder()->first();

        //        if we picked a year and therefore a query where no albums exist, pick a random public album as fallback
        if (! $album) {
            $album = $privateQuery->inRandomOrder()->first();
        }

        //
        // if we still do not have an album, there are no public albums
        if (! $album) {
            return ['error' => 'No public photo albums found.'];
        }

        return [
            'photos' => $album->items->map(fn (Photo $item): string => $item->getUrl(PhotoEnum::LARGE)),
            'album_name' => $album->name,
            'date_taken' => Carbon::createFromTimestamp($album->date_taken, date_default_timezone_get())->format('d-m-Y'),
        ];
    }

    /** @return array<string, mixed> */
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

        $activityParticipations = ActivityParticipation::query()
            ->with('activity.event')
            ->with('help.committee')
            ->where('user_id', $user->id)
            ->get();
        foreach ($activityParticipations as $activity_participation) {
            $data['activities'][] = [
                'name' => $activity_participation->activity?->event?->title,
                'date' => $activity_participation->activity?->event ? Carbon::createFromTimestamp($activity_participation->activity->event->start, date_default_timezone_get())->format('Y-m-d') : null,
                'was_present' => $activity_participation->is_present,
                'helped_as' => $activity_participation->help ? $activity_participation->help->committee->name : null,
                'backup' => $activity_participation->backup,
                'created_at' => $activity_participation->created_at,
                'updated_at' => $activity_participation->updated_at,
                'deleted_at' => $activity_participation->deleted_at,

            ];
        }

        $orderlines = OrderLine::query()
            ->with('molliePayment')
            ->with('withdrawal')
            ->with('product')
            ->where('user_id', $user->id)
            ->get();

        foreach ($orderlines as $orderline) {
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
            $data['liked_photos'][] = $photo_like->photo->getUrl();
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

    public function discordVerifyMember(string $userId): JsonResponse
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
