<?php

namespace Proto;

use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'events';

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
}
