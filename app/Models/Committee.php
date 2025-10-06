<?php

namespace App\Models;

use App;
use App\Enums\CommitteeEnum;
use Database\Factories\CommitteeFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Committee Model.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property int $public
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $allow_anonymous_email
 * @property int $is_society
 * @property int $is_active
 * @property-read string $email
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 *
 * @method static CommitteeFactory factory($count = null, $state = [])
 * @method static Builder<static>|Committee newModelQuery()
 * @method static Builder<static>|Committee newQuery()
 * @method static Builder<static>|Committee query()
 * @method static Builder<static>|Committee whereAllowAnonymousEmail($value)
 * @method static Builder<static>|Committee whereCreatedAt($value)
 * @method static Builder<static>|Committee whereDescription($value)
 * @method static Builder<static>|Committee whereId($value)
 * @method static Builder<static>|Committee whereIsActive($value)
 * @method static Builder<static>|Committee whereIsSociety($value)
 * @method static Builder<static>|Committee whereName($value)
 * @method static Builder<static>|Committee wherePublic($value)
 * @method static Builder<static>|Committee whereSlug($value)
 * @method static Builder<static>|Committee whereUpdatedAt($value)
 *
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 *
 * @mixin \Eloquent
 */
class Committee extends Model implements HasMedia
{
    /** @use HasFactory<CommitteeFactory>*/
    use HasFactory;

    use InteractsWithMedia;

    protected $table = 'committees';

    protected $guarded = ['id'];

    protected $with = ['media'];

    public function getPublicId(): string
    {
        return $this->slug;
    }

    public static function fromPublicId(string $public_id): Committee
    {
        return self::query()->where('slug', $public_id)->firstOrFail();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')
            ->useDisk(App::environment('local') ? 'local' : 'stack')
            ->storeConversionsOnDisk('public')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        // 800x300
        // 450x300
        $this->addMediaConversion(CommitteeEnum::CARD->value)
            ->nonQueued()
            ->fit(Fit::Crop, 800, 300)
            ->format('webp');

        $this->addMediaConversion(CommitteeEnum::BLOCK->value)
            ->nonQueued()
            ->fit(Fit::Crop, 450, 300)
            ->format('webp');
    }

    public function getImageUrl(CommitteeEnum $committeeEnum = CommitteeEnum::CARD): string
    {
        return $this->getFirstMediaUrl('default', $committeeEnum->value);
    }

    /**
     * @return BelongsToMany<User, $this>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'committees_users')
            ->where(static function ($query) {
                $query
                    ->whereNull('committees_users.deleted_at')
                    ->orWhere('committees_users.deleted_at', '>', Carbon::now());
            })
            ->where('committees_users.created_at', '<', Carbon::now())
            ->withPivot(['id', 'role', 'edition', 'created_at', 'deleted_at'])
            ->withTimestamps()
            ->orderByPivot('created_at', 'desc');
    }

    /**
     * @return Builder<Event>
     */
    public function organizedEvents(): Builder
    {
        return Event::getEventBlockQuery()->where('committee_id', $this->id);
    }

    /**
     * @return Attribute<string, never>
     */
    protected function email(): Attribute
    {
        return Attribute::make(get: fn (): string => $this->slug.'@'.Config::string('proto.emaildomain'));
    }

    /**
     * @return Builder<Event>
     */
    public function pastEvents(): Builder
    {
        return $this->organizedEvents()->where('end', '<', Carbon::now()->timestamp)
            ->unless(Auth::user()?->can('board'), static function ($q) {
                $q->where(function ($q) {
                    $q->where('secret', false)->orWhere('publication', '<', Carbon::now()->timestamp)
                        ->orWhereNull('publication');
                });
            })->reorder('start', 'desc');
    }

    /**
     * @return Builder<Event>
     */
    public function upcomingEvents(): Builder
    {
        return $this
            ->organizedEvents()
            ->where('end', '>', Carbon::now()->timestamp)
            ->orderBy('start', 'desc')
            ->unless(Auth::user()?->can('board'), static function ($q) {
                $q->where(function ($q) {
                    $q->where('secret', false)->orWhere('publication', '<', Carbon::now()->timestamp)
                        ->orWhereNull('publication');
                });
            });
    }

    /**
     * @return Builder<Event>
     */
    public function pastHelpedEvents(): Builder
    {
        $activityIds = HelpingCommittee::query()->where('committee_id', $this->id)->pluck('activity_id');

        return Event::getEventBlockQuery()->whereHas('activity', function ($q) use ($activityIds) {
            $q->whereIn('id', $activityIds);
        })
            ->unless(Auth::user()?->can('board'), static function ($q) {
                $q->where(function ($q) {
                    $q->where('secret', false)->orWhere('publication', '<', Carbon::now()->timestamp)
                        ->orWhereNull('publication');
                });
            })
            ->where('end', '<', Carbon::now()->timestamp)
            ->reorder('start', 'desc');
    }

    /** @return array<string, array<string, array<int, CommitteeMembership>>> */
    public function allMembers(): array
    {
        $members = ['editions' => [], 'members' => ['current' => [], 'past' => [], 'future' => []]];
        $memberships = CommitteeMembership::withTrashed()->where('committee_id', $this->id)
            ->orderBy(DB::raw('deleted_at IS NULL'), 'desc')
            ->orderBy('created_at', 'desc')
            ->orderBy('deleted_at', 'desc')
            ->with('user.media')
            ->get();

        foreach ($memberships as $membership) {
            if ($membership->edition) {
                $members['editions'][$membership->edition][] = $membership;
            } elseif (Carbon::parse($membership->created_at)->timestamp < Carbon::now()->timestamp &&
                (! $membership->deleted_at || Carbon::parse($membership->deleted_at)->timestamp > Carbon::now()->timestamp)) {
                $members['members']['current'][] = $membership;
            } elseif (Carbon::parse($membership->created_at)->timestamp > Carbon::now()->timestamp) {
                $members['members']['future'][] = $membership;
            } else {
                $members['members']['past'][] = $membership;
            }
        }

        return $members;
    }

    /**
     * @return bool Whether the use is a member of the committee.
     */
    public function isMember(?User $user): bool
    {
        if (! $user instanceof User) {
            return false;
        }

        return $this->users->contains($user);
    }
}
