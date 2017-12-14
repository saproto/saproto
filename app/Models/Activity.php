<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

use Auth;

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
        return $this->belongsToMany('Proto\Models\User', 'activities_users')->withPivot('id', 'committees_activities_id', 'is_present')->whereNull('activities_users.deleted_at')->whereNull('committees_activities_id')->where('backup', false)->withTimestamps();
    }

    /**
     * @return mixed A list of participants to this activity.
     */
    public function allUsers()
    {
        return $this->belongsToMany('Proto\Models\User', 'activities_users')->withPivot('id', 'committees_activities_id', 'is_present')->whereNull('activities_users.deleted_at')->where('backup', false)->withTimestamps();
    }

    /**
     * @return mixed A sorted list of participants, not as a relation!
     */
    public function allUsersSorted()
    {
        return $this->allUsers->sort(function ($a, $b) {
            return strcmp($a->name, $b->name);
        });
    }

    /**
     * @return mixed A list of participants to this activity.
     */
    public function backupUsers()
    {
        return $this->belongsToMany('Proto\Models\User', 'activities_users')->whereNull('activities_users.deleted_at')->whereNull('committees_activities_id')->where('backup', true)->withPivot('id')->withTimestamps();
    }

    /**
     * @return mixed A list of committees helping out at this activity.
     */
    public function helpingCommittees()
    {
        return $this->belongsToMany('Proto\Models\Committee', 'committees_activities')->withPivot(array('amount', 'id'))->withTimestamps();
    }

    /**
     * @return mixed A list of committees helping out at this activity.
     */
    public function helpingCommitteeInstances()
    {
        return $this->hasMany('Proto\Models\HelpingCommittee', 'activity_id');
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
     * @return ActivityParticipation|null Return the ActivityParticipation for the supplied user and committee in combination with this activity. Returns null if there is none.
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
     * @return ActivityParticipation|null Return the ActivityParticipation for the supplied user. Returns null if users doesn't participate.
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
     * @param User $user
     * @return bool Return whether the user is participating in the activity.
     */
    public function isParticipating(User $user)
    {
        return $this->getParticipation($user) !== null;
    }

    /**
     * @param User $user
     * @param HelpingCommittee|null $h
     * @return bool Return whether the user is helping at the activity, optionally constraining whether it is for a committee.
     */
    public function isHelping(User $user, HelpingCommittee $h = null)
    {
        if ($h) {
            return $this->getParticipation($user, $h) !== null;
        } else {
            return ActivityParticipation::where('activity_id', $this->id)->where('user_id', $user->id)->whereNotNull('committees_activities_id')->count() > 0;
        }
    }

    /**
     * @return bool Returns whether the activity is full or not.
     */
    public function isFull()
    {
        return $this->participants != -1 && count($this->users) >= $this->participants;
    }

    /**
     * @return int The amount of free spots available.
     */
    public function freeSpots()
    {
        if ($this->participants <= 0) {
            return -1;
        } else {
            return max(($this->participants - count($this->users)), 0);
        }
    }

    /**
     * @return bool Returns whether one can still subscribe for this activity.
     */
    public function canSubscribe()
    {
        if (Auth::check() && Auth::user()->isElegibleForKickInCamp() && $this->event->id == config('proto.kickinEvent')->event) {
            return true;
        }
        if ($this->closed || $this->isFull() || $this->participants == 0) {
            return false;
        }
        return date('U') > $this->registration_start && date('U') < $this->registration_end;
    }

    /**
     * @return bool Returns whether one can still subscribe for the back-up list for this activity.
     */
    public function canSubscribeBackup()
    {
        if ($this->canSubscribe()) {
            return true;
        }
        if ($this->closed || $this->participants == 0 || date('U') < $this->registration_start) {
            return false;
        }
        return true;
    }

    /**
     * @return bool Returns whether one can still unsubscribe for this activity.
     */
    public function canUnsubscribe()
    {
        if ($this->closed) {
            return false;
        }
        return date('U') < $this->deregistration_end;
    }

    public function hasStarted()
    {
        return $this->event->start < date('U');
    }

    public function withParticipants()
    {
        return $this->participants !== 0;
    }
}
