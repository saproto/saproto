<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activities';

    /**
     * @return mixed The event this activity belongs to, if any.
     */
    public function event()
    {
        return $this->belongsTo('Proto\Models\Event');
    }

    /**
     * @return mixed A list of participants to this activity.
     */
    public function participants()
    {
        return $this->belongsToMany('Proto\Models\User', 'activities_users')->whereNull('committees_activities_id')->withTimestamps();
    }

    /**
     * @return mixed A list of committees helping out at this activity.
     */
    public function helpingCommittees()
    {
        return $this->belongsToMany('Proto\Models\Committee', 'committees_activities')->withPivot(array('amount', 'id'))->withTimestamps();
    }

    /**
     * @param $helpid The committee-activity link for which helping users should be returned.
     * @return $this All associated ActivityParticipations.
     */
    public function helpingUsers($helpid)
    {
        return ActivityParticipation::where('committees_activities_id', $helpid)->get();
    }

    /**
     * @param Committee $committee The committee for which the user should be helping.
     * @param User $user The user to check helping status for.
     * @return bool Return the ActivityParticipation for the supplied user and committee in combination with this activity. Returns null if there is none.
     */
    public function getHelpingParticipation(Committee $committee, User $user)
    {
        $h = HelpingCommittee::where('activity_id', $this->id)->where('committee_id', $committee->id)->first();
        if ($h === null) return null;

        $p = ActivityParticipation::where('activity_id', $this->id)->where('user_id', $user->id)->where('committees_activities_id', $h->id)->first();
        return $p;
    }

    /**
     * @param User $user The user to check participation status for.
     * @return Model|null|static Return the ActivityParticipation for the supplied user. Returns null if users doesn't participate.
     */
    public function getParticipation(User $user)
    {
        $p = ActivityParticipation::where('activity_id', $this->id)->where('user_id', $user->id)->whereNull('committees_activities_id')->first();
        return $p;
    }

    /**
     * @return null If this activity is associated with an event,
     */
    public function organizingCommittee()
    {
        $this->hasOne('Proto\Models\Committee', 'organizing_committee');
    }
}
