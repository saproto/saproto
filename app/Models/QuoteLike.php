<?php

namespace Proto\Models;

use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Quote Like Model.
 *
 * @property int $id
 * @property int $user_id
 * @property int $quote_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Quote $quote
 * @property-read User $user
 * @method static Builder|QuoteLike whereCreatedAt($value)
 * @method static Builder|QuoteLike whereId($value)
 * @method static Builder|QuoteLike whereQuoteId($value)
 * @method static Builder|QuoteLike whereUpdatedAt($value)
 * @method static Builder|QuoteLike whereUserId($value)
 * @mixin Eloquent
 */
class QuoteLike extends Model
{
    protected $table = 'quotes_users';

    protected $guarded = ['id'];

    protected $rules = [
        'user_id' => 'required|integer',
        'quote_id' => 'required|integer',
    ];

    /** @return BelongsTo|User */
    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }

    /** @return BelongsTo|Quote */
    public function quote()
    {
        return $this->belongsTo('Proto\Models\Quote');
    }
}
