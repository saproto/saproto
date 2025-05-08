<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class HelperParticipation extends Model
{
    use SoftDeletes;
    protected $table = 'helping_committees_users';

    protected $guarded = ['id'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function helpingCommittee(): BelongsTo
    {
        return $this->belongsTo(HelpingCommittee::class, 'helping_committee_id');
    }
}
