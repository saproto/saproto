<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * DmxChannel Model.
 *
 * @property int $id
 * @property string $name
 * @property string $special_function
 *
 * @method static Builder<static>|DmxChannel newModelQuery()
 * @method static Builder<static>|DmxChannel newQuery()
 * @method static Builder<static>|DmxChannel query()
 * @method static Builder<static>|DmxChannel whereId($value)
 * @method static Builder<static>|DmxChannel whereName($value)
 * @method static Builder<static>|DmxChannel whereSpecialFunction($value)
 *
 * @mixin \Eloquent
 */
class DmxChannel extends Model
{
    protected $table = 'dmx_channels';

    protected $fillable = ['id', 'name'];

    public $timestamps = false;
}
