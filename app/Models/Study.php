<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Proto\Models\Study
 *
 * @property integer $id
 * @property string $name
 * @property string $faculty
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Proto\Models\User[] $user
 */
class Study extends Model
{
    protected $table = 'studies';

    public function user()
    {
        return $this->belongsToMany('Proto\Models\User');
    }
}
