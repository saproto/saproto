<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class EmailList extends Model
{

    protected $table = 'mailinglists';

    public $timestamps = false;

    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsToMany('Proto\Models\User', 'users_mailinglists', 'list_id', 'user_id');
    }

    public function isSubscribed(User $user)
    {
        return EmailListSubscription::where('user_id', $user->id)->where('list_id', $this->id)->count() > 0;
    }

    public function subscribe(User $user)
    {
        if (!$this->isSubscribed($user)) {
            EmailListSubscription::create([
                'user_id' => $user->id,
                'list_id' => $this->id
            ]);
            return true;
        } else {
            return false;
        }
    }

    public function unsubscribe(User $user)
    {
        $s = EmailListSubscription::where('user_id', $user->id)->where('list_id', $this->id);
        if (!$s) return false;
        $s->delete();
        return true;
    }

}
