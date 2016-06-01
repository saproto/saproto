<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class CommitteeMembership extends Validatable
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'committees_activities';

    /**
     * @return mixed The user this association is for.
     */
    public function activity() {
        return $this->belongsTo('Proto\Models\Activity');
    }

    /**
     * @return mixed The committee this association is for.
     */
    public function committee() {
        return $this->belongsTo('Proto\Models\Committee');
    }

    protected $fillable = ['user_id', 'committee_id', 'role', 'edition', 'start', 'end'];

    protected $rules = array(
        'activity_id' => 'required|integer',
        'committee_id' => 'required|integer',
        'amount' => 'required|integer'
    );
}