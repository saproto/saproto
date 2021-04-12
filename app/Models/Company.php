<?php

namespace Proto\Models;

use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\{Builder,
    Collection,
    Model,
    Relations\BelongsTo,
    Relations\BelongsToMany,
    Relations\HasMany};

/**
 * Company Model
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
 * @property-read Collection|Joboffer[] $job_offers
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
 * @mixin Eloquent
 */
class Company extends Model
{

    protected $table = 'companies';

    protected $guarded = ['id'];

    /** @return BelongsTo|StorageEntry */
    public function image()
    {
        return $this->belongsTo('Proto\Models\StorageEntry', 'image_id');
    }

    /** @return HasMany|Joboffer[] */
    public function joboffers()
    {
        return $this->hasMany('Proto\Models\Joboffer', 'company_id');
    }

}
