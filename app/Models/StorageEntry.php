<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class StorageEntry extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'files';

    public function committees() {
        return $this->hasMany('Proto\Models\Committee');
    }
}
