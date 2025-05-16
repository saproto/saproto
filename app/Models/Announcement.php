<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

/**
 * Announcement Model.
 *
 * @property int $id
 * @property string $description
 * @property string $content
 * @property string $display_from
 * @property string $display_till
 * @property bool $show_guests
 * @property bool $show_users
 * @property bool $show_members
 * @property bool $show_only_homepage
 * @property bool $show_only_new
 * @property bool $show_only_firstyear
 * @property bool $show_only_active
 * @property int $show_as_popup
 * @property int $show_style
 * @property int $is_dismissable
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $bootstrap_style
 * @property-read string $hash_map_id
 * @property-read string $is_visible
 * @property-read string $modal_id
 * @property-read bool $show_by_time
 *
 * @method static Builder<static>|Announcement newModelQuery()
 * @method static Builder<static>|Announcement newQuery()
 * @method static Builder<static>|Announcement query()
 * @method static Builder<static>|Announcement whereContent($value)
 * @method static Builder<static>|Announcement whereCreatedAt($value)
 * @method static Builder<static>|Announcement whereDescription($value)
 * @method static Builder<static>|Announcement whereDisplayFrom($value)
 * @method static Builder<static>|Announcement whereDisplayTill($value)
 * @method static Builder<static>|Announcement whereId($value)
 * @method static Builder<static>|Announcement whereIsDismissable($value)
 * @method static Builder<static>|Announcement whereShowAsPopup($value)
 * @method static Builder<static>|Announcement whereShowGuests($value)
 * @method static Builder<static>|Announcement whereShowMembers($value)
 * @method static Builder<static>|Announcement whereShowOnlyActive($value)
 * @method static Builder<static>|Announcement whereShowOnlyFirstyear($value)
 * @method static Builder<static>|Announcement whereShowOnlyHomepage($value)
 * @method static Builder<static>|Announcement whereShowOnlyNew($value)
 * @method static Builder<static>|Announcement whereShowStyle($value)
 * @method static Builder<static>|Announcement whereShowUsers($value)
 * @method static Builder<static>|Announcement whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Announcement extends Model
{
    protected $table = 'announcements';

    protected $guarded = ['id'];

    /**
     * @return Attribute<string, never>
     */
    protected function bootstrapStyle(): Attribute
    {
        return Attribute::make(get: function (): string {
            $map = [
                'primary',
                'info',
                'warning',
                'danger',
                'default',
            ];

            return $map[$this->show_style];
        });
    }

    /**
     * @return Attribute<string, never>
     */
    protected function isVisible(): Attribute
    {
        return Attribute::make(get: function (): string {
            $flags = [];
            $flags[] = $this->show_only_homepage ? 'Homepage only' : 'Entire site';
            if ($this->show_guests) {
                $flags[] = 'All guests';
            }

            if ($this->show_users) {
                $flags[] = $this->show_only_new ? 'New users' : 'All users';
            }

            if ($this->show_members) {
                if ($this->show_only_firstyear && $this->show_only_active) {
                    $flags[] = 'First-year and active members';
                } elseif ($this->show_only_firstyear) {
                    $flags[] = 'First-year members';
                } elseif ($this->show_only_active) {
                    $flags[] = 'Active members';
                } else {
                    $flags[] = 'All members';
                }
            }

            if ($this->show_as_popup) {
                $flags[] = 'Pop-up';
            } else {
                $flags[] = 'Banner';
                $flags[] = $this->is_dismissable ? 'Dismissable' : 'Persistent';
            }

            $flags[] = sprintf('Style: %s', $this->bootstrap_style);

            return implode(', ', $flags);
        });
    }

    /**
     * @return Attribute<string, never>
     */
    protected function hashMapId(): Attribute
    {
        return Attribute::make(get: fn (): string => sprintf('dismiss-announcement-%s', $this->id));
    }

    /**
     * @return Attribute<string, never>
     */
    protected function modalId(): Attribute
    {
        return Attribute::make(get: fn (): string => sprintf('modal-announcement-%s', $this->id));
    }

    /**
     * @return Attribute<bool, never>
     */
    protected function showByTime(): Attribute
    {
        return Attribute::make(get: fn (): bool => strtotime($this->display_from) < Carbon::now()->format('U') && strtotime($this->display_till) > Carbon::now()->format('U'));
    }

    public function showForUser(?User $user = null): bool
    {
        // Check for homepage.
        if ($this->show_only_homepage && Route::current()->getName() != 'homepage') {
            return false;
        }

        // Not within the scheduled timeframe.
        if (! $this->show_by_time) {
            return false;
        }

        // Verify user type requirement.
        if (
            ! ($this->show_guests && $user == null) &&
            ! ($this->show_users && $user != null && ! $user->is_member) &&
            ! ($this->show_members && $user != null && $user->is_member)
        ) {
            return false;
        }

        // Check new user requirement
        if ($this->show_only_new && $user != null && $user->created_at < $this->display_from) {
            return false;
        }

        // Check for first years.
        if ($this->show_only_firstyear && $user != null && $user->is_member && ! $user->isFirstYear()) {
            return false;
        }

        // Check for first years.
        if ($this->show_only_active && $user != null && $user->is_member && ! $user->isActiveMember()) {
            return false;
        }

        // Check if not already dismissed.
        if ($this->is_dismissable && Cookie::get($this->hash_map_id)) {
            return false;
        }

        if ($user == null) {
            return true;
        }

        if (! $this->is_dismissable) {
            return true;
        }

        return HashMapItem::query()->where('key', $this->hash_map_id)->where('subkey', $user->id)->count() <= 0;
    }

    public function dismissForUser(?User $user = null): void
    {
        if ($user instanceof User) {
            HashMapItem::query()->create(['key' => $this->hash_map_id, 'subkey' => $user->id]);
        } else {
            Cookie::queue($this->hash_map_id, true, 525600);
        }
    }

    protected function casts(): array
    {
        return [
            'show_guests' => 'boolean',
            'show_users' => 'boolean',
            'show_members' => 'boolean',
            'show_only_homepage' => 'boolean',
            'show_only_new' => 'boolean',
            'show_only_firstyear' => 'boolean',
            'show_only_active' => 'boolean',
        ];
    }
}
