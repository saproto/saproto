<?php

namespace Proto\Models;

use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\{Builder, Model, Relations\BelongsTo};

/**
 * Welcome Message Model
 *
 * @property int $id
 * @property int $user_id
 * @property string $message
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @method static Builder|WelcomeMessage whereCreatedAt($value)
 * @method static Builder|WelcomeMessage whereId($value)
 * @method static Builder|WelcomeMessage whereMessage($value)
 * @method static Builder|WelcomeMessage whereUpdatedAt($value)
 * @method static Builder|WelcomeMessage whereUserId($value)
 * @mixin Eloquent
 */
class WelcomeMessage extends Model
{
    protected $table = 'user_welcome';

    protected $guarded = ['id'];

    protected $rules = [
        'user_id' => 'required|integer',
        'message' => 'required|string',
    ];

    /** @return BelongsTo|User */
    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }
}