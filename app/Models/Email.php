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
        } elseif ($this->to_list) {
            return $this->lists->toArray();
        } elseif ($this->to_event != false) {
            return 'event';
        }
    }

    public function recipients()
    {
        if ($this->to_user) {
            return User::orderBy('name', 'asc')->get();
        } elseif ($this->to_member) {
            return User::has('member')->orderBy('name', 'asc')->get();
        } elseif ($this->to_list) {
            $userids = [];
            foreach ($this->lists as $list) {
                $userids = array_merge($userids, $list->users->lists('id')->toArray());
            }
            return User::whereIn('id', $userids)->orderBy('name', 'asc')->get();
        } elseif ($this->to_event != false) {
            $event = Event::find($this->to_event);
            if ($event && $event->activity) {
                $userids = ActivityParticipation::whereNull('committees_activities_id')->where('activity_id', $event->activity->id)->where('backup', false)->get()->pluck('user_id');
                return User::whereIn('id', $userids)->orderBy('name', 'asc')->get();
            } else {
                return collect([]);
            }
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
        if ($this->to_event == false) {
            return 'No event.';
        } else {
            $event = Event::find($this->to_event);
            if ($event) {
                return $event->title;
            } else {
                return 'Unknown Event';
            }
        }
    }

}
