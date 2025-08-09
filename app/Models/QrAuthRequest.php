<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * QrAuth Request Model.
 *
 * @property int $id
 * @property int $user_id
 * @property string $auth_token
 * @property string $qr_token
 * @property string $description
 * @property string|null $approved_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder<static>|QrAuthRequest newModelQuery()
 * @method static Builder<static>|QrAuthRequest newQuery()
 * @method static Builder<static>|QrAuthRequest query()
 * @method static Builder<static>|QrAuthRequest whereApprovedAt($value)
 * @method static Builder<static>|QrAuthRequest whereAuthToken($value)
 * @method static Builder<static>|QrAuthRequest whereCreatedAt($value)
 * @method static Builder<static>|QrAuthRequest whereDescription($value)
 * @method static Builder<static>|QrAuthRequest whereId($value)
 * @method static Builder<static>|QrAuthRequest whereQrToken($value)
 * @method static Builder<static>|QrAuthRequest whereUpdatedAt($value)
 * @method static Builder<static>|QrAuthRequest whereUserId($value)
 *
 * @mixin \Eloquent
 */
class QrAuthRequest extends Model
{
    use HasFactory;

    protected $table = 'qrauth_requests';

    protected $guarded = ['id'];

    public function isApproved(): bool
    {
        return $this->approved_at !== null;
    }

    /**
     * @return false|User
     *
     * @throws Exception
     */
    public function authUser()
    {
        if ($this->approved_at) {
            /** @var User $user */
            $user = User::query()->findOrFail($this->user_id);
            $this->delete();

            return $user;
        }

        return false;
    }
}
