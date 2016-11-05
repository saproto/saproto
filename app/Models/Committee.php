<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

use Auth;

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
    public function organizedEvents()
    {
        return $this->hasMany('Proto\Models\Event', 'committee_id');
    }

    /**
     * @return mixed All events organized by this committee in the past.
     */
    public function pastEvents()
    {
        $events = $this->organizedEvents()->where('end', '<', time())->get();

        if(Auth::check() && Auth::user()->can('board')) {
            return $events;
        }else {
            return $events->where('secret', '=' , 0);
        }
    }

    /**
     * @return mixed All upcoming events organized by this committee.
     */
    public function upcomingEvents()
    {
        $events = $this->organizedEvents()->where('end', '>', time())->get();

        if(Auth::check() && Auth::user()->can('board')) {
            return $events;
        }else {
            return $events->where('secret', '=' , 0);
        }
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
        return $this->belongsToMany('Proto\Models\User', 'committees_users')->whereNull('committees_users.deleted_at')->withPivot(array('id', 'role', 'edition', 'created_at', 'deleted_at'))->withTimestamps()->orderBy('pivot_created_at', 'desc');
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
        return count(CommitteeMembership::whereNull('committees_users.deleted_at')->where('user_id', $user->id)->where('committee_id', $this->id)->get()) > 0;
    }

    protected $guarded = [];
}