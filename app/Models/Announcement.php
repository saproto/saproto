<?php

namespace Proto\Models;

use Cookie;
use Illuminate\Support\Facades\Route;

use Proto\Models\User;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{

    protected $table = 'announcements';
    protected $guarded = ['id'];

    public function showByTime()
    {
        return (strtotime($this->display_from) < date('U') && strtotime($this->display_till) > date('U'));
    }

    public function showForUser(User $user = null)
    {

        // Check for homepage.
        if ($this->show_only_homepage && Route::current()->getName() != 'homepage') {
            return false;
        }

        // Not within the scheduled timeframe.
        if (!$this->showByTime()) {
            return false;
        }

        // Verify user type requirement.
        if (
            !($this->show_guests && $user == null) &&
            !($this->show_users && $user != null && $user->member == null) &&
            !($this->show_members && $user != null && $user->member != null)
        ) {
            return false;
        }

        // Check new user requirement
        if ($this->show_only_new && $user != null && $user->created_at < $this->display_from) {
            return false;
        }

        // Check for first years.
        if ($this->show_only_firstyear && $user != null && $user->member != null && !$user->isFirstYear()) {
            return false;
        }

        // Check for first years.
        if ($this->show_only_active && $user != null && $user->member != null && !$user->isActiveMember()) {
            return false;
        }

        // Check if not already dismissed.
        if ($this->is_dismissable && Cookie::get($this->hashMapId())) {
            return false;
        } else if ($user != null && $this->is_dismissable && HashMapItem::where('key', $this->hashMapId())->where('subkey', $user->id)->count() > 0) {
            return false;
        }
        return true;
    }

    public function bootstrap_style()
    {
        switch ($this->show_style) {
            case 0:
                return 'primary';
            case 1:
                return 'info';
            case 2:
                return 'warning';
            case 3:
                return 'danger';
            default:
                return 'default';
        }
    }

    public function textualVisibility()
    {
        $flags = [];

        if ($this->show_only_homepage) {
            $flags[] = 'Homepage only';
        } else {
            $flags[] = 'Entire site';
        }

        if ($this->show_guests) {
            $flags[] = 'All guests';
        }
        if ($this->show_users) {
            if ($this->only_new) {
                $flags[] = 'New users';
            } else {
                $flags[] = 'All users';
            }
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
            if ($this->is_dismissable) {
                $flags[] = 'Dismissable';
            } else {
                $flags[] = 'Persistent';
            }
        }

        $flags[] = sprintf('Style: %s', $this->bootstrap_style());

        return implode(', ', $flags);

    }

    public function dismissForUser(User $user = null)
    {
        if ($user) {
            HashMapItem::create(['key' => $this->hashMapId(), 'subkey' => $user->id]);
        } else {
            Cookie::queue($this->hashMapId(), true, 525600);
        }
    }

    public function hashMapId()
    {
        return sprintf("dismiss-announcement-%s", $this->id);
    }

    public function modalId()
    {
        return sprintf("modal-announcement-%s", $this->id);
    }

}
