<?php

namespace App\Models;

use Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
 *
 * @method static Builder|HeaderImage whereCreatedAt($value)
 * @method static Builder|HeaderImage whereCreditId($value)
 * @method static Builder|HeaderImage whereId($value)
 * @method static Builder|HeaderImage whereImageId($value)
 * @method static Builder|HeaderImage whereTitle($value)
 * @method static Builder|HeaderImage whereUpdatedAt($value)
 * @method static Builder|HeaderImage newModelQuery()
 * @method static Builder|HeaderImage newQuery()
 * @method static Builder|HeaderImage query()
 *
 * @mixin Model
 */
class HeaderImage extends Model
{
    use HasFactory;

    protected $table = 'headerimages';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'credit_id');
    }

    /**
     * @return BelongsTo<StorageEntry, $this>
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(StorageEntry::class, 'image_id', 'id');
    }

    /**
     * @return BelongsTo<StorageEntry, $this>
     */
    public function StorageEntry(): BelongsTo
    {
        return $this->belongsTo(StorageEntry::class, 'image_id', 'id');
    }
}
