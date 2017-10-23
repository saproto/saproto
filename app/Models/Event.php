<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $hidden = ['created_at', 'updated_at', 'secret', 'image_id', 'deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'events';

    /**
     * @return mixed The activity associated with this event, if any.
     */
    public function activity()
    {
        return $this->hasOne('Proto\Models\Activity');
    }

    /**
     * @return mixed The committee associated with this event, if any.
     */
    public function committee()
    {
        return $this->belongsTo('Proto\Models\Committee');
    }

    public function tickets()
    {
        return $this->hasMany('Proto\Models\Ticket', 'event_id');
    }

    public function getTicketPurchasesFor(User $user)
    {
        return TicketPurchase::where('user_id', $user->id)->whereIn('ticket_id', $this->tickets->pluck('id'))->get();
    }

    /**
     * @return mixed The image associated with this event, if any.
     */
    public function image()
    {
        return $this->belongsTo('Proto\Models\StorageEntry');
    }

    /**
     * @return mixed The image associated with this event, if any.
     */
    public function albums()
    {
        return $this->hasMany('Proto\Models\FlickrAlbum', 'event_id');
    }

    /**
     * @return Event A collection of events for the weekly newsletter.
     */
    public static function getEventsForNewsletter()
    {
        return Event::where('include_in_newsletter', true)->where('secret', false)->where('start', '>', date('U'))->orderBy('start')->get();
    }

    public function current()
    {
        return ($this->start < date('U') && $this->end > date('U'));
    }

    public function over()
    {
        return ($this->end < date('U'));
    }

    public function generateTimespanText($long_format, $short_format, $combiner)
    {
        return date($long_format, $this->start) . " " . $combiner . " " . (
            (($this->end - $this->start) < 3600 * 24)
                ?
                date($short_format, $this->end)
                :
                date($long_format, $this->end)
            );
    }

    public function isEventAdmin(User $user)
    {
        return $user->can('board') || ($this->committee && $this->committee->isMember($user)) || $this->isEventEro($user);
    }

    public function isEventEro(User $user)
    {
        if ($user->can('board')) {
            return true;
        }
        if (date('U') > $this->end) {
            return false;
        }
        if (!$this->activity) {
            return false;
        }
        $eroHelping = HelpingCommittee::where('activity_id', $this->activity->id)
            ->where('committee_id', config('proto.committee')['ero'])->first();
        if ($eroHelping) {
            return ActivityParticipation::where('activity_id', $this->activity->id)
                    ->where('committees_activities_id', $eroHelping->id)
                    ->where('user_id', $user->id)->count() > 0;
        } else {
            return false;
        }
    }

    public function returnAllUsers()
    {
        $users = [];
        foreach ($this->tickets as $ticket) {
            $users = array_merge($users, $ticket->getUsers()->pluck('id')->toArray());
        }
        if ($this->activity) {
            $users = array_merge($users, $this->activity->allUsers->pluck('id')->toArray());
        }
        return User::whereIn('id', array_unique($users))->get()->sortBy('name');
    }

    public function getAllEmails()
    {
        return $this->returnAllUsers()->pluck('email')->toArray();
    }

    protected $guarded = ['id'];

}
