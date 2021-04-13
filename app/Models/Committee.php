<?php

namespace Proto\Models;

use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'committees';
    protected $hidden = ['image_id'];

    public function getPublicId()
    {
        return $this->slug;
    }

    /**
     * @param $public_id
     *
     * @return mixed
     */
    public static function fromPublicId($public_id)
    {
        return Committee::where('slug', $public_id)->firstOrFail();
    }

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
        $events = $this->organizedEvents()->where('end', '<', time())->orderBy('start', 'desc');

        if (Auth::check() && Auth::user()->can('board')) {
            return $events->get();
        } else {
            return $events->where('secret', '=', 0)->get();
        }
    }

    /**
     * @return mixed All upcoming events organized by this committee.
     */
    public function upcomingEvents()
    {
        $events = $this->organizedEvents()->where('end', '>', time());

        if (Auth::check() && Auth::user()->can('board')) {
            return $events->get();
        } else {
            return $events->where('secret', '=', 0)->get();
        }
    }

    /**
     * @param $includeSecret
     *
     * @return mixed All events at which this committee helped out.
     */
    public function helpedEvents($includeSecret = false)
    {
        $activities = $this->belongsToMany('Proto\Models\Activity', 'committees_activities')->orderBy('created_at', 'desc')->get();
        $events = [];
        foreach ($activities as $activity) {
            $event = $activity->event;
            if ($event && (!$event->secret || $includeSecret)) {
                $events[] = $event;
            }
        }

        return $events;
    }

    /**
     * @return mixed All events at which this committee helped out.
     */
    public function pastHelpedEvents()
    {
        $activities = $this->belongsToMany('Proto\Models\Activity', 'committees_activities')->orderBy('created_at', 'desc')->get();
        $events = [];
        foreach ($activities as $activity) {
            $event = $activity->event;
            if ($event && !$event->secret && $event->end < time()) {
                $events[] = $event;
            }
        }

        return $events;
    }

    /**
     * @return mixed All users currently associated with this committee.
     */
    public function users()
    {
        return $this->belongsToMany('Proto\Models\User', 'committees_users')
            ->where(function ($query) {
                $query->whereNull('committees_users.deleted_at')
                    ->orWhere('committees_users.deleted_at', '>', Carbon::now());
            })
            ->where('committees_users.created_at', '<', Carbon::now())
            ->withPivot(['id', 'role', 'edition', 'created_at', 'deleted_at'])
            ->withTimestamps()
            ->orderBy('pivot_created_at', 'desc');
    }

    public function image()
    {
        return $this->belongsTo('Proto\Models\StorageEntry', 'image_id');
    }

    public function allmembers()
    {
        $members = ['editions' => [], 'members' => ['current' => [], 'past' => [], 'future' => []]];

        foreach (
            CommitteeMembership::withTrashed()->where('committee_id', $this->id)
                ->orderBy(DB::raw('deleted_at IS NULL'), 'desc')
                ->orderBy('created_at', 'desc')
                ->orderBy('deleted_at', 'desc')
                ->get()
            as $membership
        ) {
            if ($membership->edition) {
                $members['editions'][$membership->edition][] = $membership;
            } else {
                if (
                    strtotime($membership->created_at) < date('U') &&
                    (
                        !$membership->deleted_at ||
                        strtotime($membership->deleted_at) > date('U')
                    )
                ) {
                    $members['members']['current'][] = $membership;
                } elseif (strtotime($membership->created_at) > date('U')) {
                    $members['members']['future'][] = $membership;
                } else {
                    $members['members']['past'][] = $membership;
                }
            }
        }

        return $members;
    }

    /**
     * @param User $user The user to check membership for.
     *
     * @return bool Whether the user is currently a member of this committee.
     */
    public function isMember(User $user)
    {
        return $user->isInCommittee($this);
    }

    public function getEmailAddress()
    {
        return $this->slug.'@'.config('proto.emaildomain');
    }

    public function helperReminderSubscribers()
    {
        return $this->hasMany('Proto\Models\HelperReminder');
    }

    public function getHelperReminderSubscribers()
    {
        $users = [];
        foreach ($this->helperReminderSubscribers as $subscriber) {
            $users[] = $subscriber->user;
        }

        return $users;
    }

    public function wantsToReceiveHelperReminder(User $user)
    {
        return HelperReminder::where('user_id', $user->id)->where('committee_id', $this->id)->count() > 0;
    }

    protected $guarded = [];
}
