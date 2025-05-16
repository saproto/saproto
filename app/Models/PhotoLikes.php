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
 * @property int $photo_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Photo $photo
 *
 * @method static Builder|PhotoLikes whereCreatedAt($value)
 * @method static Builder|PhotoLikes whereId($value)
 * @method static Builder|PhotoLikes wherePhotoId($value)
 * @method static Builder|PhotoLikes whereUpdatedAt($value)
 * @method static Builder|PhotoLikes whereUserId($value)
 * @method static Builder|PhotoLikes newModelQuery()
 * @method static Builder|PhotoLikes newQuery()
 * @method static Builder|PhotoLikes query()
 *
 * @mixin Model
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
