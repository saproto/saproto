<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'committees';

    /**
     * @return mixed All events organized by this committee.
     */
    public function organizedActivities() {
        return $this->hasMany('Proto\Models\Activity', 'organizing_committee');
    }

    /**
     * @return mixed All activities at which this committee helped out.
     */
    public function helpedActivities() {
        return $this->hasMany('Proto\Models\Activity', 'committees_events')->withPivot(array('amount', 'id'))->withTimestamps();
    }

    /**
     * @return mixed All users associated with this committee.
     */
    public function users()
    {
        return $this->belongsToMany('Proto\Models\User', 'committees_users')->withPivot(array('start', 'end', 'role', 'edition'))->withTimestamps()->orderBy('pivot_start', 'desc');
    }

    protected $fillable = ['name', 'slug', 'description', 'public'];
}