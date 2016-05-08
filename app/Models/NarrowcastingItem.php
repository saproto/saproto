<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class NarrowcastingItem extends Model
{
    protected $table = 'narrowcasting';

    /**
     * @return mixed The image associated with this item..
     */
    public function image() {
        return $this->belongsTo('Proto\Models\StorageEntry');
    }
}
