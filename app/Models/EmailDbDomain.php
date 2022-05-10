<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Email Domain Alias Model.
 *
 * @property int $id
 */
class EmailDbDomain extends Model
{
    public $connection = 'mysql-mail';

    protected $table = 'virtual_domains';

    protected $guarded = ['id'];

    public $timestamps = false;
}
