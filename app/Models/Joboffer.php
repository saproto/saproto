<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
 * @property-read Company $company
 *
 * @method static Builder|Joboffer whereCompanyId($value)
 * @method static Builder|Joboffer whereCreatedAt($value)
 * @method static Builder|Joboffer whereDescription($value)
 * @method static Builder|Joboffer whereId($value)
 * @method static Builder|Joboffer whereRedirectUrl($value)
 * @method static Builder|Joboffer whereTitle($value)
 * @method static Builder|Joboffer whereUpdatedAt($value)
 * @method static Builder|Joboffer newModelQuery()
 * @method static Builder|Joboffer newQuery()
 * @method static Builder|Joboffer query()
 *
 * @mixin Model
 */
class Joboffer extends Model
{
    protected $table = 'joboffers';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo<Company, $this> */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
