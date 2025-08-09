<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Job Offer Model.
 *
 * @property int $id
 * @property int $company_id
 * @property string $title
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $redirect_url
 * @property-read Company|null $company
 *
 * @method static Builder<static>|Joboffer newModelQuery()
 * @method static Builder<static>|Joboffer newQuery()
 * @method static Builder<static>|Joboffer query()
 * @method static Builder<static>|Joboffer whereCompanyId($value)
 * @method static Builder<static>|Joboffer whereCreatedAt($value)
 * @method static Builder<static>|Joboffer whereDescription($value)
 * @method static Builder<static>|Joboffer whereId($value)
 * @method static Builder<static>|Joboffer whereRedirectUrl($value)
 * @method static Builder<static>|Joboffer whereTitle($value)
 * @method static Builder<static>|Joboffer whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Joboffer extends Model
{
    use HasFactory;

    protected $table = 'joboffers';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo<Company, $this> */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
