<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Validatable
{

    protected $rules = array(
        'registration_start' => 'required|integer',
        'registration_end' => 'required|integer',
        'deregistration_end' => 'required|integer',
        'participants' => 'integer',
        'price' => 'required|regex:/[0-9]+(\.[0-9]{0,2}){0,1}/'
    );

    protected $guarded = [];

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
    public function users()
    {
        return $this->belongsToMany('Proto\Models\User', 'activities_users')->whereNull('committees_activities_id')
            ->whereNull('activities_users.deleted_at')->where('backup', false)->withPivot('id')->withTimestamps()->get();
    }

    /**
     * @return mixed A list of participants to this activity.
     */
    public function backupUsers()
    {
        return $this->belongsToMany('Proto\Models\User', 'activities_users')->whereNull('committees_activities_id')
            ->whereNull('activities_users.deleted_at')->where('backup', true)->withPivot('id')->withTimestamps()->get();
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
        return ActivityParticipation::whereNull('activities_users.deleted_at')->where('committees_activities_id', $helpid)->get();
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

        $p = ActivityParticipation::where('activity_id', $this->id)->where('user_id', $user->id)
            ->where('committees_activities_id', $h->id)->first();
        return $p;
    }

    /**
     * @param User $user The user to check participation status for.
     * @return Model|null|static Return the ActivityParticipation for the supplied user. Returns null if users doesn't participate.
     */
    public function getParticipation(User $user, HelpingCommittee $h = null)
    {
        if ($h == null) {
            return ActivityParticipation::where('activity_id', $this->id)->where('user_id', $user->id)
                ->whereNull('committees_activities_id')->first();
        } else {
            return ActivityParticipation::where('activity_id', $this->id)->where('user_id', $user->id)
                ->where('committees_activities_id', $h->id)->first();
        }
    }

    /**
     * @return null If this activity is associated with an event,
     */
    public function organizingCommittee()
    {
        $this->hasOne('Proto\Models\Committee', 'organizing_committee');
    }

    /**
     * @return bool Returns whether the activity is full or not.
     */
    public function isFull()
    {
        return count($this->users()) >= $this->participants;
    }

    /**
     * @return int The amount of free spots available.
     */
    public function freeSpots()
    {
        if ($this->participants == null) {
            return null;
        } else {
            return ($this->participants - count($this->users()));
        }
    }

    /**
     * @return bool Returns whether one can still subscribe for this activity.
     */
    public function canSubscribe()
    {
        if ($this->closed) {
            return false;
        }
        return date('U') > $this->registration_start && date('U') < $this->registration_end;
    }

    /**
     * @return bool Returns whether one can still unsubscribe for this activity.
     */
    public function canUnsubscribe()
    {
        if ($this->closed) {
            return false;
        }
        return $this->deregistration_end === null || date('U') < $this->deregistration_end;
    }
}
