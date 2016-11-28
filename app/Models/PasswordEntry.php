<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use DateTime;

class PasswordEntry extends Model
{

    protected $table = 'passwordstore';

    protected $guarded = ['id'];

    public function isNote()
    {
        return $this->note !== null;
    }

    public function canAccess(User $user)
    {
        $permission = $this->permission;
        return $permission && $user->can($permission->name);
    }

    public function permission()
    {
        return $this->belongsTo('Proto\Models\Permission', 'permission_id');
    }

    public function age()
    {
        return Carbon::instance(new DateTime($this->updated_at))->diffInMonths(Carbon::now());
    }

}
