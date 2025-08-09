<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property float $lat
 * @property float $lng
 * @property string|null $city
 * @property string|null $country
 * @property string|null $country_code
 * @property int $user_id
 * @property int $file_id
 * @property int|null $reporter_id
 * @property string|null $report_reason
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read StorageEntry $image
 * @property-read User|null $reporter
 * @property-read User $user
 *
 * @method static Builder<static>|Sticker newModelQuery()
 * @method static Builder<static>|Sticker newQuery()
 * @method static Builder<static>|Sticker query()
 * @method static Builder<static>|Sticker whereCity($value)
 * @method static Builder<static>|Sticker whereCountry($value)
 * @method static Builder<static>|Sticker whereCountryCode($value)
 * @method static Builder<static>|Sticker whereCreatedAt($value)
 * @method static Builder<static>|Sticker whereFileId($value)
 * @method static Builder<static>|Sticker whereId($value)
 * @method static Builder<static>|Sticker whereLat($value)
 * @method static Builder<static>|Sticker whereLng($value)
 * @method static Builder<static>|Sticker whereReportReason($value)
 * @method static Builder<static>|Sticker whereReporterId($value)
 * @method static Builder<static>|Sticker whereUpdatedAt($value)
 * @method static Builder<static>|Sticker whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Sticker extends Model
{
    use HasFactory;

    protected $fillable = ['lat', 'lng', 'city', 'country', 'country_code', 'reporter_id', 'report_reason', 'user_id', 'created_at'];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**
     * @return BelongsTo<StorageEntry, $this>
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(StorageEntry::class, 'file_id');
    }
}
