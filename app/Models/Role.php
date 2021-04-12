<?php

namespace Proto\Models;

use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Zizaco\Entrust\EntrustRole;

/**
 * Role Model
 *
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Permission[] $permissions
 * @property-read Collection|Permission[] $perms
 * @property-read Collection|User[] $users
 * @method static Builder|Role whereCreatedAt($value)
 * @method static Builder|Role whereDescription($value)
 * @method static Builder|Role whereDisplayName($value)
 * @method static Builder|Role whereId($value)
 * @method static Builder|Role whereName($value)
 * @method static Builder|Role whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Role extends EntrustRole
{
    protected $guarded = ['id'];

    /** @return BelongsToMany|Permission[] */
    public function permissions()
    {
        return $this->belongsToMany('Proto\Models\Permission', 'permission_role');
    }

    /** @return BelongsToMany|User[] */
    public function users()
    {
        return $this->belongsToMany('Proto\Models\User', 'role_user');
    }
}
