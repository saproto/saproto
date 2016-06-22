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
    public function organizedActivities()
    {
        return $this->hasMany('Proto\Models\Activity', 'organizing_committee');
    }

    /**
     * @return mixed All activities at which this committee helped out.
     */
    public function helpedActivities()
    {
        return $this->belongsToMany('Proto\Models\Activity', 'committees_events')->withPivot(array('amount', 'id'))->withTimestamps();
    }

    /**
     * @return mixed All users associated with this committee.
     */
    public function users()
    {
        return $this->belongsToMany('Proto\Models\User', 'committees_users')->withPivot(array('id', 'role', 'edition'))->withTimestamps()->orderBy('pivot_start', 'desc');
    }

    public function image()
    {
        return $this->belongsTo('Proto\Models\StorageEntry', 'image_id');
    }

    public function allmembers()
    {

        $members = array('editions' => [], 'members' => ['current' => [], 'past' => []]);

        foreach (CommitteeMembership::withTrashed()->where('committee_id', $this->id)->orderBy('created_at', 'desc')->get() as $membership) {
            if ($membership->edition) {
                $members['editions'][$membership->edition][] = $membership;
            } else {
                if ($membership->trashed()) {
                    $members['members']['past'][] = $membership;
                } else {
                    $members['members']['current'][] = $membership;
                }
            }
        }

        return $members;

    }

    /**
     * @param User $user The user to check membership for.
     * @return bool Whether the user is currently a member of this committee.
     */
    public function isMember(User $user)
    {
        $p = CommitteeMembership::where('user_id', $user->id)->where('committee_id', $this->id)->get();
        return $p !== null;
    }

    protected $guarded = [];
}