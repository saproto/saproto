<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Played Video Model.
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $video_id
 * @property string $video_title
 * @property string|null $spotify_id
 * @property string|null $spotify_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $user
 *
 * @method static Builder|PlayedVideo whereCreatedAt($value)
 * @method static Builder|PlayedVideo whereId($value)
 * @method static Builder|PlayedVideo whereSpotifyId($value)
 * @method static Builder|PlayedVideo whereSpotifyName($value)
 * @method static Builder|PlayedVideo whereUpdatedAt($value)
 * @method static Builder|PlayedVideo whereUserId($value)
 * @method static Builder|PlayedVideo whereVideoId($value)
 * @method static Builder|PlayedVideo whereVideoTitle($value)
 * @method static Builder|PlayedVideo newModelQuery()
 * @method static Builder|PlayedVideo newQuery()
 * @method static Builder|PlayedVideo query()
 *
 * @mixin Model
 */
class PlayedVideo extends Model
{
    protected $table = 'playedvideos';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function generateYoutubeThumbnail(string $youtube_id): string
    {
        return "https://img.youtube.com/vi/{$youtube_id}/mqdefault.jpg";
    }

    public function generateSpotifyUri(): string
    {
        $spotify_id = str_replace('spotify:track:', '', $this->spotify_id);

        return "https://open.spotify.com/track/{$spotify_id}";
    }

    public function generateYoutubeUrl(): string
    {
        return "https://www.youtube.com/watch?v={$this->video_id}";
    }
}
