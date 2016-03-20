<?php

namespace Proto;

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
    public function event() {
        return $this->belongsTo('Proto\Models\Event');
    }

    /**
     * @return mixed A list of participants to this activity.
     */
    public function participants() {
        return $this->belongsToMany('Proto\Models\User', 'activities_users')->wherePivot('committees_activities_id', '!=', 'null')->withTimestamps();
    }

    /**
     * @return mixed A list of committees helping out at this activity.
     */
    public function helpingCommittees() {
        return $this->belongsToMany('Proto\Models\Committee', 'committees_activities')->withPivot(array('amount', 'id'))->withTimestamps();
    }

    /**
     * @param Committee|null $committee The committee of which to retrieve the helping users. If null, returns all helping users.
     * @return array The list of helping users.
     */
    public function helpingUsers(Committee $committee = null) {
        $u = array();
        foreach($this->helpingCommittees() as $c) {
            if ($committee == null || $committee == $c) {
               $u = array_merge($u, $this->belongsToMany('Proto\Models\User', 'activities_users')->wherePivot('committees_activities_id', '=', $c->pivot->id)->withTimestamps());
            }
        }
        return $u;
    }

    /**
     * @return null If this activity is associated with an event,
     */
    public function organizingCommittee() {
        $this->hasOne('Proto\Models\Committee', 'organizing_committee');
    }
}
