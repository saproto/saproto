<?php

namespace Proto\Models;

use Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Alias Model.
 *
 * @mixin Model
 * @property int $id
 * @property string $alias
 * @property int|null $user_id
 * @property string|null $destination
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $user
 * @method static Builder|Alias whereAlias($value)
 * @method static Builder|Alias whereCreatedAt($value)
 * @method static Builder|Alias whereDestination($value)
 * @method static Builder|Alias whereId($value)
 * @method static Builder|Alias whereUpdatedAt($value)
 * @method static Builder|Alias whereUserId($value)
 */
class Alias extends Model
{
    protected $table = 'alias';

    protected $guarded = ['id'];

    /** @return BelongsTo|User */
    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }
}
