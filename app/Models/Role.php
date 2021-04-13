<?php

namespace Proto\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $fillable = ['name', 'display_name', 'description'];

    public function permissions()
    {
        return $this->belongsToMany('Proto\Models\Permission', 'permission_role');
    }

    public function users()
    {
        return $this->belongsToMany('Proto\Models\User', 'role_user');
    }
}
