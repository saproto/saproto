<?php

namespace App\Models;

use App\Enums\CompanyEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Override;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Company Model.
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property string $excerpt
 * @property string $description
 * @property bool $on_carreer_page
 * @property bool $in_logo_bar
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $on_membercard
 * @property string|null $membercard_excerpt
 * @property string|null $membercard_long
 * @property int $sort
 * @property-read Collection<int, Joboffer> $joboffers
 * @property-read int|null $joboffers_count
 *
 * @method static Builder<static>|Company newModelQuery()
 * @method static Builder<static>|Company newQuery()
 * @method static Builder<static>|Company query()
 * @method static Builder<static>|Company whereCreatedAt($value)
 * @method static Builder<static>|Company whereDescription($value)
 * @method static Builder<static>|Company whereExcerpt($value)
 * @method static Builder<static>|Company whereId($value)
 * @method static Builder<static>|Company whereInLogoBar($value)
 * @method static Builder<static>|Company whereMembercardExcerpt($value)
 * @method static Builder<static>|Company whereMembercardLong($value)
 * @method static Builder<static>|Company whereName($value)
 * @method static Builder<static>|Company whereOnCarreerPage($value)
 * @method static Builder<static>|Company whereOnMembercard($value)
 * @method static Builder<static>|Company whereSort($value)
 * @method static Builder<static>|Company whereUpdatedAt($value)
 * @method static Builder<static>|Company whereUrl($value)
 *
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 *
 * @mixin Model
 */
class Company extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'companies';

    protected $guarded = ['id'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')
            ->useDisk(App::environment('local') ? 'public' : 'stack')
            ->storeConversionsOnDisk('public')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion(CompanyEnum::LARGE->value)
            ->nonQueued()
            ->fit(Fit::Max, 1920, 1920)
            ->format('webp');

        $this->addMediaConversion(CompanyEnum::SMALL->value)
            ->nonQueued()
            ->fit(Fit::Max, 500)
            ->format('webp');
    }

    public function getImageUrl(CompanyEnum $companyEnum = CompanyEnum::LARGE): string
    {
        return $this->getFirstMediaUrl('default', $companyEnum->value);
    }

    /**
     * @return HasMany<Joboffer, $this>
     */
    public function joboffers(): HasMany
    {
        return $this->hasMany(Joboffer::class, 'company_id');
    }

    protected function casts(): array
    {
        return [
            'on_carreer_page' => 'boolean',
            'in_logo_bar' => 'boolean',
            'on_membercard' => 'boolean',
        ];
    }

    #[Override]
    protected static function boot(): void
    {
        parent::boot();

        static::saved(function (Company $company) {
            Cache::forget('home.companies');
        });
    }
}
