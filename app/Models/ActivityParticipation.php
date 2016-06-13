<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityParticipation extends Validatable
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activities_users';

    /**
     * @return mixed The user this association is for.
     */
    public function user() {
        return $this->belongsTo('Proto\Models\User');
    }

    /**
     * @return mixed The activity this association is for.
     */
    public function activity() {
        return $this->belongsTo('Proto\Models\Activity');
    }

    protected $guarded = ['id'];

    protected $rules = array(
        'user_id' => 'required|integer',
        'activity_id' => 'required|integer',
        'committees_activities_id' => 'required|integer'
    );
}