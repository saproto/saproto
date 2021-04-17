<?php

namespace Proto\Models;

use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
 * @method static Builder|ShortUrl whereClicks($value)
 * @method static Builder|ShortUrl whereCreatedAt($value)
 * @method static Builder|ShortUrl whereDescription($value)
 * @method static Builder|ShortUrl whereId($value)
 * @method static Builder|ShortUrl whereTarget($value)
 * @method static Builder|ShortUrl whereUpdatedAt($value)
 * @method static Builder|ShortUrl whereUrl($value)
 * @mixin Eloquent
 */
class ShortUrl extends Model
{
    protected $table = 'short_url';

    protected $guarded = ['id'];
}
