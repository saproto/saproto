<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WallstreetEvent extends Model
{
    protected $table = 'wallstreet_drink_events';

    /** @return BelongsTo */
    public function image(): BelongsTo
    {
        return $this->belongsTo('App\Models\StorageEntry');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'wallstreet_drink_event_product', 'wallstreet_drink_event_id');
    }
}