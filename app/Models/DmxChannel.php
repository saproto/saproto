<?php

namespace Proto\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * DmxChannel Model
 *
 * @property int $id
 * @property string $name
 * @property string $special_function
 * @method static Builder|DmxChannel whereId($value)
 * @method static Builder|DmxChannel whereName($value)
 * @method static Builder|DmxChannel whereSpecialFunction($value)
 * @mixin Eloquent
 */
class DmxChannel extends Model
{
    protected $table = 'dmx_channels';

    protected $guarded = ['id'];

    public $timestamps = false;
}
