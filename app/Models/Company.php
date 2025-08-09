<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Company Model.
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property string $excerpt
 * @property string $description
 * @property int $image_id
 * @property bool $on_carreer_page
 * @property bool $in_logo_bar
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $on_membercard
 * @property string|null $membercard_excerpt
 * @property string|null $membercard_long
 * @property int $sort
 * @property-read StorageEntry|null $image
 * @property-read Collection<int, Joboffer> $joboffers
 * @property-read int|null $joboffers_count
 *
 * @method static Builder<static>|Company newModelQuery()
 * @method static Builder<static>|Company newQuery()
 * @method static Builder<static>|Company query()
 * @method static Builder<static>|Company whereCreatedAt($value)
 * @method static Builder<static>|Company whereDescription($value)
 * @method static Builder<static>|Company whereExcerpt($value)
 * @method static Builder<static>|Company whereId($value)
 * @method static Builder<static>|Company whereImageId($value)
 * @method static Builder<static>|Company whereInLogoBar($value)
 * @method static Builder<static>|Company whereMembercardExcerpt($value)
 * @method static Builder<static>|Company whereMembercardLong($value)
 * @method static Builder<static>|Company whereName($value)
 * @method static Builder<static>|Company whereOnCarreerPage($value)
 * @method static Builder<static>|Company whereOnMembercard($value)
 * @method static Builder<static>|Company whereSort($value)
 * @method static Builder<static>|Company whereUpdatedAt($value)
 * @method static Builder<static>|Company whereUrl($value)
 *
 * @mixin \Eloquent
 */
class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo<StorageEntry, $this>
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(StorageEntry::class, 'image_id');
    }

    /**
     * @return HasMany<Joboffer, $this>
     */
    public function joboffers(): HasMany
    {
        return $this->hasMany(Joboffer::class, 'company_id');
    }

    protected function casts(): array
    {
        return [
            'on_carreer_page' => 'boolean',
            'in_logo_bar' => 'boolean',
            'on_membercard' => 'boolean',
        ];
    }
}
