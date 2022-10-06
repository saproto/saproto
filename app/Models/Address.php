<?php

namespace Proto\Models;

use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Proto\Models\Address.
 *
 * @property int $id
 * @property int $user_id
 * @property string $street
 * @property string $number
 * @property string $zipcode
 * @property string $city
 * @property string $country
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @method static Builder|Address whereCity($value)
 * @method static Builder|Address whereCountry($value)
 * @method static Builder|Address whereCreatedAt($value)
 * @method static Builder|Address whereId($value)
 * @method static Builder|Address whereNumber($value)
 * @method static Builder|Address whereStreet($value)
 * @method static Builder|Address whereUpdatedAt($value)
 * @method static Builder|Address whereUserId($value)
 * @method static Builder|Address whereZipcode($value)
 * @mixin Eloquent
 */
class Address extends Validatable
{
    protected $table = 'addresses';

    protected $guarded = ['id'];

    protected $hidden = ['id'];

    protected $rules = [
        'user_id' => 'required|integer',
        'street' => 'required|string',
        'number' => 'required|string',
        'zipcode' => 'required|string',
        'city' => 'required|string',
        'country' => 'required|string',
    ];

    /** @return BelongsTo|User */
    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }
}
