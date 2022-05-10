<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Email Database Alias Model.
 *
 * @property int $id
 * @property string $source
 * @property string $destination
 */

class EmailDbAlias extends Model
{
    public $connection = 'mysql-mail';

    protected $table = 'virtual_aliases';

    protected $guarded = ['id'];

    public $timestamps = false;
}
