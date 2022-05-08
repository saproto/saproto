<?php

namespace Proto\Models;

use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Company Model.
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property string $excerpt
 * @property string $description
 * @property int $image_id
 * @property int $on_carreer_page
 * @property int $in_logo_bar
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $on_membercard
 * @property string|null $membercard_excerpt
 * @property string|null $membercard_long
 * @property int $sort
 * @property-read StorageEntry $image
 * @property-read Collection|Joboffer[] $joboffers
 * @method static Builder|Company whereCreatedAt($value)
 * @method static Builder|Company whereDescription($value)
 * @method static Builder|Company whereExcerpt($value)
 * @method static Builder|Company whereId($value)
 * @method static Builder|Company whereImageId($value)
 * @method static Builder|Company whereInLogoBar($value)
 * @method static Builder|Company whereMembercardExcerpt($value)
 * @method static Builder|Company whereMembercardLong($value)
 * @method static Builder|Company whereName($value)
 * @method static Builder|Company whereOnCarreerPage($value)
 * @method static Builder|Company whereOnMembercard($value)
 * @method static Builder|Company whereSort($value)
 * @method static Builder|Company whereUpdatedAt($value)
 * @method static Builder|Company whereUrl($value)
 * @method static Builder|Company newModelQuery()
 * @method static Builder|Company newQuery()
 * @method static Builder|Company query()
 * @mixin Eloquent
 */
class Company extends Model
{
    protected $table = 'companies';

    protected $guarded = ['id'];

    /** @return BelongsTo */
    public function image()
    {
        return $this->belongsTo('Proto\Models\StorageEntry', 'image_id');
    }

    /** @return HasMany */
    public function joboffers()
    {
        return $this->hasMany('Proto\Models\Joboffer', 'company_id');
    }
}
