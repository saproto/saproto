<?php

namespace App\Models;

use Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Config;

/**
 * Alias Model.
 *
 * @property int $id
 * @property string $alias
 * @property int|null $user_id
 * @property string|null $destination
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $user
 *
 * @method static Builder|Alias whereAlias($value)
 * @method static Builder|Alias whereCreatedAt($value)
 * @method static Builder|Alias whereDestination($value)
 * @method static Builder|Alias whereId($value)
 * @method static Builder|Alias whereUpdatedAt($value)
 * @method static Builder|Alias whereUserId($value)
 * @method static Builder|Alias newModelQuery()
 * @method static Builder|Alias newQuery()
 * @method static Builder|Alias query()
 *
 * @mixin Model
 */
class Alias extends Model
{
    protected $table = 'alias';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function email(): Attribute
    {
        return Attribute::make(get: fn (): string => $this->alias.'@'.Config::string('proto.emaildomain'));
    }
}
