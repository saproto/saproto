<?php

namespace App\Models;

use Database\Factories\ActivityFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Date;
use Override;

/**
 * Activity Model.
 *
 * @property int $id
 * @property int|null $event_id
 * @property float|null $price
 * @property float $no_show_fee
 * @property int $participants
 * @property bool $hide_participants
 * @property int|null $attendees
 * @property int $registration_start
 * @property int $registration_end
 * @property int $deregistration_end
 * @property bool $closed
 * @property int|null $closed_account
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $comment
 * @property string|null $redirect_url
 * @property-read Collection<int, User> $backupUsers
 * @property-read int|null $backup_users_count
 * @property-read Account|null $closedAccount
 * @property-read Event|null $event
 * @property-read Collection<int, HelpingCommittee> $helpingCommittees
 * @property-read int|null $helping_committees_count
 * @property-read Collection<int, ActivityParticipation> $participation
 * @property-read int|null $participation_count
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 *
 * @method static ActivityFactory factory($count = null, $state = [])
 * @method static Builder<static>|Activity newModelQuery()
 * @method static Builder<static>|Activity newQuery()
 * @method static Builder<static>|Activity query()
 * @method static Builder<static>|Activity whereAttendees($value)
 * @method static Builder<static>|Activity whereClosed($value)
 * @method static Builder<static>|Activity whereClosedAccount($value)
 * @method static Builder<static>|Activity whereComment($value)
 * @method static Builder<static>|Activity whereCreatedAt($value)
 * @method static Builder<static>|Activity whereDeregistrationEnd($value)
 * @method static Builder<static>|Activity whereEventId($value)
 * @method static Builder<static>|Activity whereHideParticipants($value)
 * @method static Builder<static>|Activity whereId($value)
 * @method static Builder<static>|Activity whereNoShowFee($value)
 * @method static Builder<static>|Activity whereParticipants($value)
 * @method static Builder<static>|Activity wherePrice($value)
 * @method static Builder<static>|Activity whereRedirectUrl($value)
 * @method static Builder<static>|Activity whereRegistrationEnd($value)
 * @method static Builder<static>|Activity whereRegistrationStart($value)
 * @method static Builder<static>|Activity whereUpdatedAt($value)
 *
 * @mixin Model
 */
class Activity extends Validatable
{
    /** @use HasFactory<ActivityFactory>*/
    use HasFactory;

    protected $table = 'activities';

    protected $guarded = ['id'];

    /** @var array|string[] */
    protected array $rules = [
        'registration_start' => 'required|integer',
        'registration_end' => 'required|integer',
        'deregistration_end' => 'required|integer',
        'participants' => 'integer',
        'price' => 'required|regex:/[0-9]+(\.[0-9]{0,2}){0,1}/',
    ];

    /**
     * @return BelongsTo<Event, $this>
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * @return BelongsTo<Account, $this>
     */
    public function closedAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'closed_account');
    }

    /**
     * @return BelongsToMany<User, $this>
     */
    public function allUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'activities_users')
            ->withPivot('id', 'is_present', 'backup')
            ->withTimestamps();
    }

    /**
     * @return Attribute<Collection<int, User>, never>
     */
    protected function users(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->allUsers->where('pivot.backup', false),
        );
    }

    /**
     * @return Attribute<Collection<int, User>, never>
     */
    protected function backupUsers(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->allUsers->where('pivot.backup', true),
        );
    }

    /**
     * @return int|null how many people actually showed up
     */
    public function getAttendees(): ?int
    {
        $present = $this->countPresent();

        return $present > 0 ? $present : $this->attendees;
    }

    /**
     * @return int how many people are marked as present with the tool
     */
    public function countPresent(): int
    {
        return $this->users->where('pivot.is_present', true)
            ->count();
    }

    /**
     * @return HasMany<HelpingCommittee, $this>
     */
    public function helpingCommittees(): HasMany
    {
        return $this->hasMany(HelpingCommittee::class, 'activity_id');
    }

    public function isHelping(User $user): bool
    {
        return $this->helpingCommittees->flatMap(static fn (HelpingCommittee $c) => $c->users)->contains('id', $user->id);
    }

    public function isEro(User $user): bool
    {
        return $this->helpingCommittees->where('committee_id', Config::integer('proto.committee.ero'))->flatMap(static fn (HelpingCommittee $c) => $c->users)->contains('id', $user->id);
    }

    /**
     * @return bool Whether the user participates
     */
    public function isParticipating(User $user): bool
    {
        return $this->users->contains('id', $user->id);
    }

    /**
     * @return bool Whether the user is on the backup list
     */
    public function isOnBackupList(User $user): bool
    {
        return $this->backupUsers->contains('id', $user->id);
    }

    /**
     * @return bool Whether the activity is full
     */
    public function isFull(): bool
    {
        return $this->participants != -1 && ($this->users_count ?? $this->users->count()) >= $this->participants;
    }

    /**
     * @return int The number of free spots
     */
    public function freeSpots(): int
    {
        if ($this->participants <= 0) {
            return -1;
        }

        return max(($this->participants - ($this->users_count ?? $this->users->count())), 0);
    }

    /**
     * @return bool Whether people can still subscribe to the activity.
     */
    public function canSubscribe(): bool
    {
        if ($this->closed || $this->isFull() || $this->participants == 0) {
            return false;
        }

        return Date::now()->timestamp >= $this->registration_start && Date::now()->timestamp < $this->registration_end;
    }

    /**
     * @return bool Whether people can still subscribe to the activity's backup list.
     */
    public function canSubscribeBackup(): bool
    {
        if ($this->canSubscribe()) {
            return true;
        }

        return ! ($this->closed || $this->participants == 0 || Date::now()->timestamp < $this->registration_start);
    }

    /**
     * @return bool Whether people can still unsubscribe from the activity.
     */
    public function canUnsubscribe(): bool
    {
        if ($this->closed) {
            return false;
        }

        return Date::now()->timestamp < $this->deregistration_end;
    }

    /**
     * @return bool Whether the activity has started yet.
     */
    public function hasStarted(): bool
    {
        return $this->event->start < Date::now()->timestamp;
    }

    /**
     * @return bool Whether the activity has participants.
     */
    public function withParticipants(): bool
    {
        return $this->participants !== 0;
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'closed' => 'boolean',
            'hide_participants' => 'boolean',
        ];
    }

    #[Override]
    protected static function boot(): void
    {
        parent::boot();

        static::saved(function (Activity $activity) {
            Cache::forget('home.events');
        });
    }
}
