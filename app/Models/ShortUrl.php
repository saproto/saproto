<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Short Url Model.
 *
 * @property int $id
 * @property string $description
 * @property string $url
 * @property string $target
 * @property int $clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder<static>|ShortUrl newModelQuery()
 * @method static Builder<static>|ShortUrl newQuery()
 * @method static Builder<static>|ShortUrl query()
 * @method static Builder<static>|ShortUrl whereClicks($value)
 * @method static Builder<static>|ShortUrl whereCreatedAt($value)
 * @method static Builder<static>|ShortUrl whereDescription($value)
 * @method static Builder<static>|ShortUrl whereId($value)
 * @method static Builder<static>|ShortUrl whereTarget($value)
 * @method static Builder<static>|ShortUrl whereUpdatedAt($value)
 * @method static Builder<static>|ShortUrl whereUrl($value)
 *
 * @mixin \Eloquent
 */
class ShortUrl extends Model
{
    use HasFactory;

    protected $table = 'short_url';

    protected $guarded = ['id'];
}
