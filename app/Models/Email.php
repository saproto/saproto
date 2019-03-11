<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Email extends Model
{

    protected $table = 'emails';

    protected $guarded = ['id'];

    public function lists()
    {
        return $this->belongsToMany('Proto\Models\EmailList', 'emails_lists', 'email_id', 'list_id');
    }

    public function events()
    {
        return $this->belongsToMany('Proto\Models\Event', 'emails_events', 'email_id', 'event_id');
    }

    public function attachments()
    {
        return $this->belongsToMany('Proto\Models\StorageEntry', 'emails_files', 'email_id', 'file_id');
    }

    public function destinationForBody()
    {
        if ($this->to_user) {
            return 'users';
        } elseif ($this->to_member) {
            return 'members';
        } elseif ($this->to_active) {
            return 'active members';
        } elseif ($this->to_list) {
            return 'list';
        } elseif ($this->to_event) {
            return 'event';
        }
    }

    public function recipients()
    {
        if ($this->to_user) {
            return User::orderBy('name', 'asc')->get();

        } elseif ($this->to_member) {
            return User::has('member')->orderBy('name', 'asc')->get();

        } elseif ($this->to_active) {
            $userids = [];
            foreach (Committee::all() as $committee) {
                $userids = array_merge($userids, $committee->users->pluck('id')->toArray());
            }
            return User::whereIn('id', $userids)->orderBy('name', 'asc')->get();

        } elseif ($this->to_list) {
            $userids = [];
            foreach ($this->lists as $list) {
                $userids = array_merge($userids, $list->users->pluck('id')->toArray());
            }
            return User::whereIn('id', $userids)->orderBy('name', 'asc')->get();

        } elseif ($this->to_event != false) {
            $userids = [];
            foreach ($this->events as $event) {
                if ($event) {
                    $userids = array_merge($userids, $event->returnAllUsers()->pluck('id')->toArray());
                }
            }
            return User::whereIn('id', $userids)->orderBy('name', 'asc')->get();
        } else {
            return collect([]);
        }
    }

    public function hasRecipientList(EmailList $list)
    {
        return DB::table('emails_lists')->where('email_id', $this->id)->where('list_id', $list->id)->count() > 0;
    }

    public function parseBodyFor(User $user)
    {
        $variable_from = ['$calling_name', '$name'];
        $variable_to = [$user->calling_name, $user->name];
        return str_replace($variable_from, $variable_to, $this->body);
    }

    public function getEventName()
    {
        $events = [];
        if ($this->to_event == false) {
            return '';
        } else {
            foreach ($this->events as $event) {
                if ($event) {
                    $events[] = $event->title;
                } else {
                    $events[] = 'Unknown Event';
                }
            }
        }
        return implode(', ', $events);
    }

    public function getListName()
    {
        $lists = [];
        if ($this->to_list == false) {
            return '';
        } else {
            foreach ($this->lists as $list) {
                $lists[] = $list->name;
            }
        }
        return implode(', ', $lists);

    }

    public static function getListUnsubscribeFooter($user_id, $email_id)
    {
        $footer = [];
        $lists = Email::whereId($email_id)->firstOrFail()->lists;
        foreach ($lists as $list) {
            $footer[] = sprintf('%s (<a href="%s" style="color: #00aac0;">unsubscribe</a>)', $list->name, route('unsubscribefromlist', ['hash' => EmailList::generateUnsubscribeHash($user_id, $list->id)]));
        }
        return implode(', ', $footer);
    }

}
