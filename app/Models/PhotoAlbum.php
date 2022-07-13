<?php

namespace Proto\Models;

use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Proto\Models\PhotoAlbum.
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $name
 * @property int $date_create
 * @property int $date_taken
 * @property int $thumb_id
 * @property int|null $event_id
 * @property int $private
 * @property int $published
 * @property-read Event|null $event
 * @property-read Collection|Photo[] $items
 * @property-read Photo $thumb_photo
 * @method static Builder|PhotoAlbum whereCreatedAt($value)
 * @method static Builder|PhotoAlbum whereDateCreate($value)
 * @method static Builder|PhotoAlbum whereDateTaken($value)
 * @method static Builder|PhotoAlbum whereEventId($value)
 * @method static Builder|PhotoAlbum whereId($value)
 * @method static Builder|PhotoAlbum whereName($value)
 * @method static Builder|PhotoAlbum wherePrivate($value)
 * @method static Builder|PhotoAlbum wherePublished($value)
 * @method static Builder|PhotoAlbum whereThumbId($value)
 * @method static Builder|PhotoAlbum whereUpdatedAt($value)
 * @mixin Eloquent
 */
class PhotoAlbum extends Model
{
    protected $table = 'photo_albums';

    protected $guarded = ['id'];

    /** @return BelongsTo|Event */
    public function event()
    {
        return $this->belongsTo('Proto\Models\Event', 'event_id');
    }

    /** @return HasOne|Photo */
    public function thumbPhoto()
    {
        return $this->hasOne('Proto\Models\Photo', 'id', 'thumb_id');
    }

    /** @return HasMany|Photo[] */
    public function items()
    {
        return $this->hasMany('Proto\Models\Photo', 'album_id');
    }

    /** @return string */
    public function thumb()
    {
        if ($this->thumb_id) {
            return $this->thumbPhoto()->first()->getSmallUrl();
        } else {
            return null;
        }
    }

    public function mayViewAlbum($user){
        if(!$this->private)return True;
        if($user){
            return $user->member() !== null && $this->published||$user->can('protography');
        }
        return false;
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($photoAlbum) {
            $photos = $photoAlbum->items()
                ->each(function($check) {
                    $check->delete();
                });
        });
    }
}
