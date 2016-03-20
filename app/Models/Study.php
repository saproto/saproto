<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Proto\Study
 *
 * @property integer $id
 * @property string $name
 * @property string $faculty
 * @property-read \Illuminate\Database\Eloquent\Collection|\Proto\User[] $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
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
