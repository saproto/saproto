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
 * @method static Builder|HashMapItem key($key)
 * @method static Builder|HashMapItem subkey($subkey)
 * @method static Builder|HashMapItem whereId($value)
 * @method static Builder|HashMapItem whereKey($value)
 * @method static Builder|HashMapItem whereSubkey($value)
 * @method static Builder|HashMapItem whereValue($value)
 * @method static builder|HashMapItem newmodelquery()
 * @method static builder|HashMapItem newquery()
 * @method static builder|HashMapItem query()
 *
 * @mixin Model
 *
 * @method static HashMapItemFactory factory($count = null, $state = [])
 * @method static Builder<static>|HashMapItem newModelQuery()
 * @method static Builder<static>|HashMapItem newQuery()
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
    public function scopeKey(Builder $query, string $key): Builder
    {
        return $query->where('key', '=', $key);
    }

    /**
     * @param  Builder<HashMapItem>  $query
     * @return Builder<HashMapItem>
     */
    public function scopeSubkey(Builder $query, string $subkey): Builder
    {
        return $query->where('subkey', '=', $subkey);
    }
}
