<?php

namespace App\Models;

use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Permission;

/**
 * Password Entry Model.
 *
 * @property int $id
 * @property int $permission_id
 * @property string|null $description
 * @property string|null $username
 * @property string|null $password
 * @property string|null $url
 * @property string|null $note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Permission|null $permission
 *
 * @method static Builder<static>|PasswordEntry newModelQuery()
 * @method static Builder<static>|PasswordEntry newQuery()
 * @method static Builder<static>|PasswordEntry query()
 * @method static Builder<static>|PasswordEntry whereCreatedAt($value)
 * @method static Builder<static>|PasswordEntry whereDescription($value)
 * @method static Builder<static>|PasswordEntry whereId($value)
 * @method static Builder<static>|PasswordEntry whereNote($value)
 * @method static Builder<static>|PasswordEntry wherePassword($value)
 * @method static Builder<static>|PasswordEntry wherePermissionId($value)
 * @method static Builder<static>|PasswordEntry whereUpdatedAt($value)
 * @method static Builder<static>|PasswordEntry whereUrl($value)
 * @method static Builder<static>|PasswordEntry whereUsername($value)
 *
 * @mixin \Eloquent
 */
class PasswordEntry extends Model
{
    protected $table = 'passwordstore';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo<Permission, $this> */
    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }

    public function canAccess(User $user): bool
    {
        $permission = $this->permission;

        return $permission && $user->can($permission->name);
    }

    /**
     * @return float|int
     *
     * @throws Exception
     */
    public function age()
    {
        return Carbon::instance(new DateTime($this->updated_at))->diffInMonths(Carbon::now());
    }
}
