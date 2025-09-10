<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Database\Factories\EventFactory;
use Hashids;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Override;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Event Model.
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int|null $category_id
 * @property bool $is_external
 * @property int $start
 * @property int $end
 * @property int|null $publication
 * @property int $unique_users_count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $update_sequence
 * @property string $location
 * @property string|null $maps_location
 * @property bool $is_featured
 * @property bool $involves_food
 * @property bool $secret
 * @property bool $force_calendar_sync
 * @property Carbon|null $deleted_at
 * @property int|null $committee_id
 * @property string|null $summary
 * @property-read Activity|null $activity
 * @property-read Collection<int, PhotoAlbum> $albums
 * @property-read int|null $albums_count
 * @property-read EventCategory|null $category
 * @property-read Committee|null $committee
 * @property-read Collection<int, Dinnerform> $dinnerforms
 * @property-read int|null $dinnerforms_count
 * @property-read mixed $formatted_date
 * @property-read bool $is_future
 * @property-read Collection<int, Ticket> $tickets
 * @property-read int|null $tickets_count
 * @property-read Collection<int, Video> $videos
 * @property-read int|null $videos_count
 *
 * @method static EventFactory factory($count = null, $state = [])
 * @method static Builder<static>|Event newModelQuery()
 * @method static Builder<static>|Event newQuery()
 * @method static Builder<static>|Event onlyTrashed()
 * @method static Builder<static>|Event query()
 * @method static Builder<static>|Event whereCategoryId($value)
 * @method static Builder<static>|Event whereCommitteeId($value)
 * @method static Builder<static>|Event whereCreatedAt($value)
 * @method static Builder<static>|Event whereDeletedAt($value)
 * @method static Builder<static>|Event whereDescription($value)
 * @method static Builder<static>|Event whereEnd($value)
 * @method static Builder<static>|Event whereForceCalendarSync($value)
 * @method static Builder<static>|Event whereId($value)
 * @method static Builder<static>|Event whereInvolvesFood($value)
 * @method static Builder<static>|Event whereIsExternal($value)
 * @method static Builder<static>|Event whereIsFeatured($value)
 * @method static Builder<static>|Event whereLocation($value)
 * @method static Builder<static>|Event whereMapsLocation($value)
 * @method static Builder<static>|Event wherePublication($value)
 * @method static Builder<static>|Event whereSecret($value)
 * @method static Builder<static>|Event whereStart($value)
 * @method static Builder<static>|Event whereSummary($value)
 * @method static Builder<static>|Event whereTitle($value)
 * @method static Builder<static>|Event whereUniqueUsersCount($value)
 * @method static Builder<static>|Event whereUpdateSequence($value)
 * @method static Builder<static>|Event whereUpdatedAt($value)
 * @method static Builder<static>|Event withTrashed()
 * @method static Builder<static>|Event withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Event extends Model implements HasMedia
{
    /** @use HasFactory<EventFactory>*/
    use HasFactory;

    use InteractsWithMedia;
    use SoftDeletes;

    protected $table = 'events';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at', 'secret', 'deleted_at', 'update_sequence'];

    protected $with = ['category'];

    protected $appends = ['is_future', 'formatted_date'];

    #[Override]
    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
            'is_external' => 'boolean',
            'is_featured' => 'boolean',
            'involves_food' => 'boolean',
            'secret' => 'boolean',
            'force_calendar_sync' => 'boolean',
        ];
    }

    #[Override]
    public function getRouteKey(): string
    {
        return Str::slug($this->title).'-'.self::getPublicId($this->id);
    }

    #[Override]
    public function resolveRouteBinding($value, $field = null): ?Model
    {
        $id = Str::afterLast($value, '-');
        $model = parent::resolveRouteBinding(self::getIdFromPublicId($id), $field);
        if (! $model || $model->getRouteKey() === $value) {
            return $model;
        }

        throw new HttpResponseException(
            redirect()->route('event::show', $model->getRouteKey())
        );
    }

    public static function getPublicId(int $id): string
    {
        return Hashids::connection('event')->encode($id);
    }

    public static function getIdFromPublicId(string $public_id): ?int
    {
        $id = Hashids::connection('event')->decode($public_id);

        return count($id) > 0 ? (int) $id[0] : null;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('header')
            ->useDisk('public')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('card')
            ->performOnCollections('header')
            ->nonQueued()
            ->fit(Fit::Crop, 800, 300)
            ->format('webp');
    }

    /**
     * @return BelongsTo<Committee, $this>
     */
    public function committee(): BelongsTo
    {
        return $this->belongsTo(Committee::class);
    }

    public function mayViewEvent(?User $user): bool
    {
        // board may always view events
        if ($user?->can('board')) {
            return true;
        }

        // only show secret events if the user is participating, helping or organising
        if ($this->secret && ($user instanceof User && $this->activity && ($this->activity->isParticipating($user) || $this->activity->isHelping($user) || $this->isOrganising($user)))) {
            return true;
        }

        // show non-secret events only when published
        return ! $this->secret && (! $this->publication || $this->isPublished());
    }

    /**
     * @return Builder<$this>
     */
    public static function getEventBlockQuery(?User $user = null): Builder
    {
        if (! $user instanceof User) {
            $user = Auth::user();
        }

        return Event::query()
            ->orderBy('start')
            ->with('media')
            ->with('activity', static function ($e) use ($user) {
                $e
                    ->with(['participation' => function ($q) use ($user) {
                        $q->where('user_id', $user?->id);
                    }])
                    ->withCount([
                        'users',
                    ]);
            })
            ->with('committee', static function ($q) use ($user) {
                $q->with(['users' => function ($q) use ($user) {
                    $q->where('user_id', $user?->id);
                }]);
            })
            ->with(['tickets' => function ($q) use ($user) {
                $q->with('purchases', static function ($q) use ($user) {
                    $q->where('user_id', $user?->id);
                })->whereHas('purchases', static function ($q) use ($user) {
                    $q->where('user_id', $user?->id);
                });
            }]);
    }

    public function isPublished(): bool
    {
        return $this->publication < Carbon::now()->timestamp;
    }

    /**
     * @return HasOne<Activity, $this>
     */
    public function activity(): HasOne
    {
        return $this->hasOne(Activity::class);
    }

    /**
     * @return HasMany<Video, $this>
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    /**
     * @return HasMany<PhotoAlbum, $this>
     */
    public function albums(): HasMany
    {
        return $this->hasMany(PhotoAlbum::class, 'event_id');
    }

    /**
     * @return HasMany<Ticket, $this>
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'event_id');
    }

    /**
     * @return HasMany<Dinnerform, $this>
     */
    public function dinnerforms(): HasMany
    {
        return $this->hasMany(Dinnerform::class, 'event_id');
    }

    /**
     * @return BelongsTo<EventCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->BelongsTo(EventCategory::class);
    }

    /**
     * @return BelongsToMany<Email, $this>
     */
    public function emails(): BelongsToMany
    {
        return $this->belongsToMany(Email::class, 'emails_events', 'event_id', 'email_id');
    }

    /**
     * @return bool Whether the user is organising the activity.
     */
    public function isOrganising(User $user): bool
    {
        return $this->committee?->isMember($user) ?? false;
    }

    public function current(): bool
    {
        return $this->start < Carbon::now()->timestamp && $this->end > Carbon::now()->timestamp;
    }

    public function over(): bool
    {
        return $this->end < Carbon::now()->timestamp;
    }

    /**
     * @param  string  $long_format  Format when timespan is larger than 24 hours.
     * @param  string  $short_format  Format when timespan is smaller than 24 hours.
     * @param  string  $combiner  Character to separate start and end time.
     * @return string Timespan text in given format
     */
    public function generateTimespanText(string $long_format, string $short_format, string $combiner): string
    {
        return Carbon::createFromTimestamp($this->start, date_default_timezone_get())->format($long_format).' '.$combiner.' '.(
            (($this->end - $this->start) < 3600 * 24)
                ?
                Carbon::createFromTimestamp($this->end, date_default_timezone_get())->format($short_format)
                :
                Carbon::createFromTimestamp($this->end, date_default_timezone_get())->format($long_format)
        );
    }

    /**
     * @return bool Whether the user is an admin of the event.
     */
    public function isEventAdmin(?User $user): bool
    {
        if (! $user instanceof User) {
            return false;
        }

        if ($user->can('board')) {
            return true;
        }

        if ($this->committee?->isMember($user)) {
            return true;
        }

        return $this->isEventEro($user);
    }

    /**
     * @return bool Whether the user is an ERO at the event
     */
    public function isEventEro(User $user): bool
    {
        if ($user->can('board')) {
            return true;
        }

        if (Carbon::now()->timestamp > $this->end) {
            return false;
        }

        if (! $this->activity) {
            return false;
        }

        return $this->activity->isEro($user);
    }

    /**
     * @return bool Whether the user has bought a ticket for the event.
     */
    public function hasBoughtTickets(User $user): bool
    {
        return $this->tickets->pluck('purchases')->flatten()->filter(fn ($purchase): bool => $purchase->user_id === $user->id)->isNotEmpty();
    }

    /** @return Collection<int, User> */
    public function allUsers(): SupportCollection
    {
        $users = collect();
        foreach ($this->tickets as $ticket) {
            $users = $users->merge($ticket->getUsers());
        }

        if ($this->activity) {
            $users = $users->merge($this->activity->allUsers->sort(static function ($a, $b): int {
                return (int) isset($a->pivot->committees_activities_id);
                // prefer helper participation registration
            })->unique());
        }

        return $users->sort(static fn ($a, $b): int => strcmp($a->name, $b->name));
    }

    // recounts the unique users on an event to make the fetching of the event_block way faster
    public function updateUniqueUsersCount(): void
    {
        $allUserIds = collect();
        foreach ($this->tickets as $ticket) {
            if ($ticket->show_participants) {
                $allUserIds = $allUserIds->merge($ticket->getUsers()->pluck('id'));
            }
        }

        if ($this->activity) {
            $allUserIds = $allUserIds->merge($this->activity->users->pluck('id'));
        }

        $this->unique_users_count = $allUserIds->unique()->count();
        $this->save();
    }

    /** @return string[] */
    public function getAllEmails(): array
    {
        return $this->allUsers()->pluck('email')->toArray();
    }

    public function shouldShowDietInfo(): bool
    {
        return $this->involves_food && $this->end > Carbon::now()->subWeek()->timestamp;
    }

    /**
     * @return Attribute<bool, never>
     */
    protected function isFuture(): Attribute
    {
        return Attribute::make(get: fn (): bool => Carbon::now()->timestamp < $this->start);
    }

    /**
     * @return Attribute<string, never>
     */
    protected function formattedDate(): Attribute
    {
        $start = CarbonImmutable::createFromTimestamp($this->start, date_default_timezone_get());

        return Attribute::make(get: fn () => (object) [
            'simple' => $start->format('M d, Y'),
            'year' => $start->format('Y'),
            'month' => $start->format('M Y'),
            'time' => $start->format('H:i'),
        ]);
    }

    #[Override]
    protected static function boot(): void
    {
        parent::boot();

        self::updating(static function ($event) {
            $event->update_sequence++;
        });
    }
}
