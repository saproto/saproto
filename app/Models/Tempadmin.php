<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Temporary Admin Model.
 *
 * @property int $id
 * @property int $user_id
 * @property int $created_by
 * @property string $start_at
 * @property string $end_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $creator
 * @property-read User $user
 *
 * @method static Builder|Tempadmin whereCreatedAt($value)
 * @method static Builder|Tempadmin whereCreatedBy($value)
 * @method static Builder|Tempadmin whereEndAt($value)
 * @method static Builder|Tempadmin whereId($value)
 * @method static Builder|Tempadmin whereStartAt($value)
 * @method static Builder|Tempadmin whereUpdatedAt($value)
 * @method static Builder|Tempadmin whereUserId($value)
 * @method static Builder|Tempadmin newModelQuery()
 * @method static Builder|Tempadmin newQuery()
 * @method static Builder|Tempadmin query()
 *
 * @mixin Model
 * @mixin \Eloquent
 */
class Tempadmin extends Model
{
    protected $table = 'tempadmins';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<User, $this> */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
