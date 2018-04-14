<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class EmailDbDomain extends Model
{

    protected $connection = 'mysql-mail';

    public $timestamps = false;

    protected $table = 'virtual_domains';

    protected $guarded = ['id'];

}
