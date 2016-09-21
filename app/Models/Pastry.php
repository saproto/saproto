<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Pastry extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pastries';

    /**
     * @return mixed The user owning the achievement.
     */
    public function users()
    {
        return $this->belongsToMany('Proto\Models\User');
    }

    /**
     * @return mixed The achievement this association is for.
     */

    protected $fillable = ['user_id_a', 'user_id_b', 'person_b'];

    protected $rules = array(
        'user_id_a' => 'required|integer',
        'user_id_b' => 'integer',
        'person_b' => 'string',
        'pastry' => 'required|integer'
    );
}