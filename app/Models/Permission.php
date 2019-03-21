<?php

namespace Proto\Models;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $fillable = ['name', 'display_name', 'description'];

    public function roles() {
        return $this->belongsToMany('Proto\Models\Role', 'permission_role');
    }
}
