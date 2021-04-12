<?php

namespace Proto\Models;

use Eloquent;
use Illuminate\Database\Eloquent\{Builder, Model};

/**
 * HashMap Item Model
 *
 * @property int $id
 * @property string $key
 * @property string|null $subkey
 * @property string $value
 * @method static Builder|HashMapItem key($key)
 * @method static Builder|HashMapItem subkey($subkey)
 * @method static Builder|HashMapItem whereId($value)
 * @method static Builder|HashMapItem whereKey($value)
 * @method static Builder|HashMapItem whereSubkey($value)
 * @method static Builder|HashMapItem whereValue($value)
 * @mixin Eloquent
 */
class HashMapItem extends Model
{
    protected $table = 'hashmap';

    protected $guarded = [];

    public $timestamps = false;

    /**
     * @param $query
     * @param string $key
     * @return mixed
     */
    public function scopeKey($query, $key)
    {
        return $query->where('key', '=', $key);
    }

    /**
     * @param $query
     * @param string $subkey
     * @return mixed
     */
    public function scopeSubkey($query, $subkey)
    {
        return $query->where('subkey', '=', $subkey);
    }

}
