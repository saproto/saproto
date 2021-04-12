<?php

namespace Proto\Models;

use Eloquent;
use Illuminate\Database\Eloquent\
{
    Builder,
    Model,
    Relations\BelongsTo
};

/**
 * Helper Reminder Model
 *
 * @property int $id
 * @property int $user_id
 * @property int $committee_id
 * @property-read Committee $committee
 * @property-read User $user
 * @method static Builder|HelperReminder whereCommitteeId($value)
 * @method static Builder|HelperReminder whereId($value)
 * @method static Builder|HelperReminder whereUserId($value)
 * @mixin Eloquent
 */
class HelperReminder extends Model
{
    protected $table = 'committees_helper_reminders';

    public $guarded = ['id'];

    public $timestamps = false;

    /** @return BelongsTo|Committee */
    public function committee()
    {
        return $this->belongsTo('Proto\Models\Committee');
    }

    /** @return BelongsTo|User */
    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }
}
