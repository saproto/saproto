<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Study extends Model
{

    protected $table = 'studies';

    /**
     * @return mixed All users associated with this study.
     */
    public function users()
    {
        return $this->belongsToMany('Proto\Models\User', 'studies_users')->withPivot(array('id', 'start', 'end'))->withTimestamps();
    }

    public function current($ismember = true)
    {
        $users = array();
        foreach ($this->users as $user) {
            if ((!$ismember || $user->member) && $user->pivot->start < date('U') && ($user->pivot->end == null || ($user->pivot->end > date('U')))) {
                $users[] = $user;
            }
        }
        return $users;
    }

    public function past($ismember = true)
    {
        $users = array();
        foreach ($this->users as $user) {
            if ((!$ismember || $user->member) && $user->pivot->end != null && ($user->pivot->end < date('U'))) {
                $users[] = $user;
            }
        }
        return $users;
    }

    public function future($ismember = true)
    {
        $users = array();
        foreach ($this->users as $user) {
            if ((!$ismember || $user->member) && $user->pivot->start > date('U')) {
                $users[] = $user;
            }
        }
        return $users;
    }

    protected $guarded = ['id'];

}
