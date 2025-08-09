<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
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
 * @property-read string $email
 * @property-read User|null $user
 *
 * @method static Builder<static>|Alias newModelQuery()
 * @method static Builder<static>|Alias newQuery()
 * @method static Builder<static>|Alias query()
 * @method static Builder<static>|Alias whereAlias($value)
 * @method static Builder<static>|Alias whereCreatedAt($value)
 * @method static Builder<static>|Alias whereDestination($value)
 * @method static Builder<static>|Alias whereId($value)
 * @method static Builder<static>|Alias whereUpdatedAt($value)
 * @method static Builder<static>|Alias whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Alias extends Model
{
    use HasFactory;

    protected $table = 'alias';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return Attribute<string, never>
     */
    protected function email(): Attribute
    {
        return Attribute::make(get: fn (): string => $this->alias.'@'.Config::string('proto.emaildomain'));
    }
}
