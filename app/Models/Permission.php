<?php

namespace Proto\Models;

use Zizaco\Entrust\EntrustPermission;


/**
 * Proto\Models\Permission
 *
 * @property integer $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Proto\Models\Role[] $roles
 */
class Permission extends EntrustPermission
{
    protected $fillable = ['name', 'display', 'description'];
}
