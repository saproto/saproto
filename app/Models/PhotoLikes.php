<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Photo Likes Model.
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $photo_id
 * @property int $user_id
 * @property-read Photo|null $photo
 *
 * @method static Builder<static>|PhotoLikes newModelQuery()
 * @method static Builder<static>|PhotoLikes newQuery()
 * @method static Builder<static>|PhotoLikes query()
 * @method static Builder<static>|PhotoLikes whereCreatedAt($value)
 * @method static Builder<static>|PhotoLikes whereId($value)
 * @method static Builder<static>|PhotoLikes wherePhotoId($value)
 * @method static Builder<static>|PhotoLikes whereUpdatedAt($value)
 * @method static Builder<static>|PhotoLikes whereUserId($value)
 *
 * @mixin \Eloquent
 */
class PhotoLikes extends Model
{
    protected $table = 'photo_likes';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo<Photo, $this> */
    public function photo(): BelongsTo
    {
        return $this->belongsTo(Photo::class, 'photo_id');
    }
}
