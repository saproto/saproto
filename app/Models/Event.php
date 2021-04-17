<?php

namespace Proto\Models;

use Auth;
use Carbon;
use Eloquent;
use Hashids;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection as SupportCollection;

/**
 * Event Model.
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $is_external
 * @property int $is_educational
 * @property int $start
 * @property int $end
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $location
 * @property int $is_featured
 * @property int $involves_food
 * @property int $secret
 * @property int $force_calendar_sync
 * @property int|null $image_id
 * @property Carbon|null $deleted_at
 * @property int|null $committee_id
 * @property string|null $summary
 * @property int $include_in_newsletter
 * @property-read Activity $activity
 * @property-read Collection|PhotoAlbum[] $albums
 * @property-read Committee|null $committee
 * @property-read mixed $formatted_date
 * @property-read mixed $is_future
 * @property-read StorageEntry|null $image
 * @property-read Collection|Ticket[] $tickets
 * @property-read Collection|Video[] $videos
 * @method static bool|null forceDelete()
 * @method static QueryBuilder|Event onlyTrashed()
 * @method static QueryBuilder|Event withTrashed()
 * @method static QueryBuilder|Event withoutTrashed()
 * @method static bool|null restore()
 * @method static Builder|Event whereCommitteeId($value)
 * @method static Builder|Event whereCreatedAt($value)
 * @method static Builder|Event whereDeletedAt($value)
 * @method static Builder|Event whereDescription($value)
 * @method static Builder|Event whereEnd($value)
 * @method static Builder|Event whereForceCalendarSync($value)
 * @method static Builder|Event whereId($value)
 * @method static Builder|Event whereImageId($value)
 * @method static Builder|Event whereIncludeInNewsletter($value)
 * @method static Builder|Event whereInvolvesFood($value)
 * @method static Builder|Event whereIsEducational($value)
 * @method static Builder|Event whereIsExternal($value)
 * @method static Builder|Event whereIsFeatured($value)
 * @method static Builder|Event whereLocation($value)
 * @method static Builder|Event whereSecret($value)
 * @method static Builder|Event whereStart($value)
 * @method static Builder|Event whereSummary($value)
 * @method static Builder|Event whereTitle($value)
 * @method static Builder|Event whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Event extends Model
{
    use SoftDeletes;

    protected $table = 'events';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at', 'secret', 'image_id', 'deleted_at'];

    protected $appends = ['is_future', 'formatted_date'];

    protected $dates = ['deleted_at'];

    /** @return string */
    public function getPublicId()
    {
        return Hashids::connection('event')->encode($this->id);
    }

    /**
     * @param $public_id
     * @return Model
     */
    public static function fromPublicId($public_id)
    {
        $id = Hashids::connection('event')->decode($public_id);
        return self::findOrFail(count($id) > 0 ? $id[0] : 0);
    }

    /** @return BelongsTo|Committee */
    public function committee()
    {
        return $this->belongsTo('Proto\Models\Committee');
    }

    /** @return BelongsTo|StorageEntry */
    public function image()
    {
        return $this->belongsTo('Proto\Models\StorageEntry');
    }

    /** @return HasOne|Activity */
    public function activity()
    {
        return $this->hasOne('Proto\Models\Activity');
    }

    /** @return HasMany|Video[] */
    public function videos()
    {
        return $this->hasMany('Proto\Models\Video');
    }

    /** @return HasMany|PhotoAlbum[] */
    public function albums()
    {
        return $this->hasMany('Proto\Models\PhotoAlbum', 'event_id');
    }

    /** @return HasMany|Ticker[] */
    public function tickets()
    {
        return $this->hasMany('Proto\Models\Ticket', 'event_id');
    }

    /**
     * @param User $user
     * @return bool Whether the user is organising the activity.
     */
    public function isOrganising($user)
    {
        return $this->committee && $user->isInCommittee($this->committee);
    }

    /** @return Collection|TicketPurchase[] */
    public function getTicketPurchasesFor(User $user)
    {
        return TicketPurchase::where('user_id', $user->id)->whereIn('ticket_id', $this->tickets->pluck('id'))->get();
    }

    /** @return Collection|Event[] */
    public static function getEventsForNewsletter()
    {
        return self::where('include_in_newsletter', true)->where('secret', false)->where('start', '>', date('U'))->orderBy('start')->get();
    }

    /** @return bool */
    public function current()
    {
        return $this->start < date('U') && $this->end > date('U');
    }

    /** @return bool */
    public function over()
    {
        return $this->end < date('U');
    }

    /**
     * @param string $long_format Format when timespan is larger than 24 hours.
     * @param string $short_format Format when timespan is smaller than 24 hours.
     * @param string $combiner Character to separate start and end time.
     * @return string Timespan text in given format
     */
    public function generateTimespanText($long_format, $short_format, $combiner)
    {
        return date($long_format, $this->start).' '.$combiner.' '.(
            (($this->end - $this->start) < 3600 * 24)
                ?
                date($short_format, $this->end)
                :
                date($long_format, $this->end)
        );
    }

    /**
     * @param User $user
     * @return bool Whether the user is an admin of the event.
     */
    public function isEventAdmin($user)
    {
        return $user->can('board') || ($this->committee && $this->committee->isMember($user)) || $this->isEventEro($user);
    }

    /**
     * @param User $user
     * @return bool Whether the user is an ERO at the event
     */
    public function isEventEro($user)
    {
        if ($user->can('board')) {
            return true;
        }
        if (date('U') > $this->end) {
            return false;
        }
        if (! $this->activity) {
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

    /**
     * @param User $user
     * @return bool Whether the user has bought a ticket for the event.
     */
    public function hasBoughtTickets($user)
    {
        return $this->getTicketPurchasesFor($user)->count() > 0;
    }

    /** @return SupportCollection */
    public function returnAllUsers()
    {
        $users = collect([]);
        foreach ($this->tickets as $ticket) {
            $users = $users->merge($ticket->getUsers());
        }
        if ($this->activity) {
            $users = $users->merge($this->activity->allUsers);
        }
        return $users->sort(function ($a, $b) {
            return strcmp($a->name, $b->name);
        });
    }

    /** @return string[] */
    public function getAllEmails()
    {
        return $this->returnAllUsers()->pluck('email')->toArray();
    }

    /** @return bool */
    public function shouldShowDietInfo()
    {
        return $this->involves_food && $this->end > strtotime('-1 week');
    }

    /** @return bool */
    public function getIsFutureAttribute()
    {
        return date('U') < $this->start;
    }

    /** @return object */
    public function getFormattedDateAttribute()
    {
        return (object) [
            'simple' => date('M d, Y', $this->start),
            'year' => date('Y', $this->start),
            'month' => date('M Y', $this->start),
            'time' => date('H:i', $this->start),
        ];
    }

    public static function countEventsPerYear(int $year): int
    {
        $yearStart = strtotime('January 1, '.$year);
        $yearEnd = strtotime('January 1, '.($year + 1));
        $events = self::where('start', '>', $yearStart)->where('end', '<', $yearEnd);
        if (! Auth::check() || ! Auth::user()->can('board')) {
            $events = $events->where('secret', 0);
        }

        return $events->count();
    }
}
