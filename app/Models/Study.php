<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Study extends Model
{
    protected $table = 'studies';

    /**
     * @return mixed All users associated with this study.
     */
    public function users()
    {
        return $this->belongsToMany('Proto\Models\User', 'studies_users')->withPivot('till')->withTimestamps();
    }
}
