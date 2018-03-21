<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class HelpingCommittee extends Validatable
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
    public function activity()
    {
        return $this->belongsTo('Proto\Models\Activity');
    }

    /**
     * @return mixed The committee this association is for.
     */
    public function committee()
    {
        return $this->belongsTo('Proto\Models\Committee');
    }

    /**
     * @return mixed A list of participants helping this activity for this committee.
     */
    public function users()
    {
        return $this->belongsToMany('Proto\Models\User', 'activities_users', 'committees_activities_id')
            ->whereNull('activities_users.deleted_at')->withTrashed();
    }

    public function getHelpingCount()
    {
        return ActivityParticipation::where('activity_id', $this->activity->id)->where('committees_activities_id', $this->id)->count();
    }

    protected $guarded = ['id'];

    protected $rules = array(
        'activity_id' => 'required|integer',
        'committee_id' => 'required|integer',
        'amount' => 'required|integer'
    );
}