<?php

namespace App\Models;

use Database\Factories\HashMapItemFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * HashMap Item Model.
 *
 * @property int $id
 * @property string $key
 * @property string|null $subkey
 * @property string $value
 *
 * @method static HashMapItemFactory factory($count = null, $state = [])
 * @method static Builder<static>|HashMapItem key(string $key)
 * @method static Builder<static>|HashMapItem newModelQuery()
 * @method static Builder<static>|HashMapItem newQuery()
 * @method static Builder<static>|HashMapItem query()
 * @method static Builder<static>|HashMapItem subkey(string $subkey)
 * @method static Builder<static>|HashMapItem whereId($value)
 * @method static Builder<static>|HashMapItem whereKey($value)
 * @method static Builder<static>|HashMapItem whereSubkey($value)
 * @method static Builder<static>|HashMapItem whereValue($value)
 *
 * @mixin \Eloquent
 */
class HashMapItem extends Model
{
    /** @use HasFactory<HashMapItemFactory>*/
    use HasFactory;

    protected $table = 'hashmap';

    protected $guarded = [];

    public $timestamps = false;

    /**
     * @param  Builder<HashMapItem>  $query
     * @return Builder<HashMapItem>
     */
    protected function scopeKey(Builder $query, string $key): Builder
    {
        return $query->where('key', '=', $key);
    }

    /**
     * @param  Builder<HashMapItem>  $query
     * @return Builder<HashMapItem>
     */
    protected function scopeSubkey(Builder $query, string $subkey): Builder
    {
        return $query->where('subkey', '=', $subkey);
    }
}
