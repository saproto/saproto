<?php

namespace Proto\Models;

use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Header Image Model.
 *
 * @property int $id
 * @property string $title
 * @property int|null $credit_id
 * @property int $image_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read StorageEntry $image
 * @property-read User|null $user
 * @method static Builder|HeaderImage whereCreatedAt($value)
 * @method static Builder|HeaderImage whereCreditId($value)
 * @method static Builder|HeaderImage whereId($value)
 * @method static Builder|HeaderImage whereImageId($value)
 * @method static Builder|HeaderImage whereTitle($value)
 * @method static Builder|HeaderImage whereUpdatedAt($value)
 * @mixin Eloquent
 */
class HeaderImage extends Model
{
    protected $table = 'headerimages';

    protected $guarded = ['id'];

    /** @return BelongsTo|User */
    public function user()
    {
        return $this->belongsTo('Proto\Models\User', 'credit_id');
    }

    /** @return BelongsTo|StorageEntry */
    public function image()
    {
        return $this->belongsTo('Proto\Models\StorageEntry', 'image_id', 'id');
    }
}
