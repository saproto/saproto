<?php

namespace App\Models;

use App\Enums\VisibilityEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

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
 * @property int|null $image_id
 * @property int $allow_anonymous_email
 * @property int $is_society
 * @property int $is_active
 * @property-read string $email
 * @property-read StorageEntry|null $image
 * @property-read Collection|Event[] $organizedEvents
 * @property-read Collection|User[] $users
 *
 * @method static Builder|Committee whereAllowAnonymousEmail($value)
 * @method static Builder|Committee whereCreatedAt($value)
 * @method static Builder|Committee whereDescription($value)
 * @method static Builder|Committee whereId($value)
 * @method static Builder|Committee whereImageId($value)
 * @method static Builder|Committee whereIsSociety($value)
 * @method static Builder|Committee whereName($value)
 * @method static Builder|Committee wherePublic($value)
 * @method static Builder|Committee whereSlug($value)
 * @method static Builder|Committee whereUpdatedAt($value)
 * @method static Builder|Committee newModelQuery()
 * @method static Builder|Committee newQuery()
 * @method static Builder|Committee query()
 *
 * @mixin Model
 */
class Committee extends Model
{
    use HasFactory;

    protected $table = 'committees';

    protected $guarded = ['id'];

    protected $hidden = ['image_id'];

    protected $with = ['image'];

    public function getPublicId(): string
    {
        return $this->slug;
    }

    public static function fromPublicId($public_id): Committee
    {
        return self::query()->where('slug', $public_id)->firstOrFail();
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
     * @return BelongsTo<StorageEntry, $this>
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(StorageEntry::class, 'image_id');
    }

    public function organizedEvents(): Builder
    {
        return Event::getEventBlockQuery()->with('committee')->where('committee_id', $this->id);
    }

    protected function email(): Attribute
    {
        return Attribute::make(get: fn (): string => $this->slug.'@'.Config::string('proto.emaildomain'));
    }

    public function pastEvents(): Builder
    {
        return $this->organizedEvents()->where('end', '<', Carbon::now()->getTimestamp())
            ->unless(Auth::user()?->can('board'), static function ($q) {
                $q->where(function ($q) {
                    $q->where('visibility', '!=', VisibilityEnum::SECRET)
                        ->orWhere(function ($q) {
                            $q->where('visibility', VisibilityEnum::SCHEDULED)->were('publication', '<', Carbon::now()->timestamp);
                        });
                });
            })->reorder('start', 'desc');
    }

    public function upcomingEvents(): Builder
    {
        return $this
            ->organizedEvents()
            ->where('end', '>', Carbon::now()->timestamp)
            ->orderBy('start', 'desc')
            ->unless(Auth::user()?->can('board'), static function ($q) {
                $q->where(function ($q) {
                    $q->where('visibility', '!=', VisibilityEnum::SECRET)
                        ->orWhere(function ($q) {
                            $q->where('visibility', VisibilityEnum::SCHEDULED)->were('publication', '<', Carbon::now()->timestamp);
                        });
                });
            });
    }

    public function pastHelpedEvents(): Builder
    {
        $activityIds = HelpingCommittee::query()->where('committee_id', $this->id)->pluck('activity_id');

        return Event::getEventBlockQuery()->whereHas('activity', function ($q) use ($activityIds) {
            $q->whereIn('id', $activityIds);
        })
            ->unless(Auth::user()?->can('board'), static function ($q) {
                $q->where(function ($q) {
                    $q->where('visibility', '!=', VisibilityEnum::SECRET)
                        ->orWhere(function ($q) {
                            $q->where('visibility', VisibilityEnum::SCHEDULED)->were('publication', '<', Carbon::now()->timestamp);
                        });
                });
            })
            ->where('end', '<', Carbon::now()->timestamp)
            ->with('committee')
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
            ->with('user.photo')
            ->get();

        foreach ($memberships as $membership) {
            if ($membership->edition) {
                $members['editions'][$membership->edition][] = $membership;
            } elseif (strtotime($membership->created_at) < Carbon::now()->format('U') &&
                (! $membership->deleted_at || strtotime($membership->deleted_at) > Carbon::now()->format('U'))) {
                $members['members']['current'][] = $membership;
            } elseif (strtotime($membership->created_at) > Carbon::now()->format('U')) {
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

        return $user->committees->contains($this);
    }
}
