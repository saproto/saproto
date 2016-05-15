<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class StudyEntry extends Validatable
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'studies_users';

    /**
     * @return mixed The user this association is for.
     */
    public function user() {
        return $this->belongsTo('Proto\Models\User');
    }

    /**
     * @return mixed The committee this association is for.
     */
    public function study() {
        return $this->belongsTo('Proto\Models\Study');
    }

    protected $fillable = ['user_id', 'study_id', 'start'];

    protected $rules = array(
        'user_id' => 'required|integer',
        'study' => 'required|integer',
        'start' => 'required|integer',
        'end' => 'integer'
    );
}