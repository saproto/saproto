<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Override;

/**
 * @property int $id
 * @property int $member_id
 * @property string $number
 * @property string $mail
 * @property string|null $department
 * @property string $givenname
 * @property string $surname
 * @property bool $found
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Member|null $member
 *
 * @method static Builder<static>|UtAccount newModelQuery()
 * @method static Builder<static>|UtAccount newQuery()
 * @method static Builder<static>|UtAccount query()
 * @method static Builder<static>|UtAccount whereCreatedAt($value)
 * @method static Builder<static>|UtAccount whereDepartment($value)
 * @method static Builder<static>|UtAccount whereFound($value)
 * @method static Builder<static>|UtAccount whereGivenname($value)
 * @method static Builder<static>|UtAccount whereId($value)
 * @method static Builder<static>|UtAccount whereMail($value)
 * @method static Builder<static>|UtAccount whereMemberId($value)
 * @method static Builder<static>|UtAccount whereNumber($value)
 * @method static Builder<static>|UtAccount whereSurname($value)
 * @method static Builder<static>|UtAccount whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class UtAccount extends Model
{
    use HasFactory;

    protected $table = 'ut_accounts';

    #[Override]
    protected function casts(): array
    {
        return [
            'found' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    protected $fillable = [
        'member_id',
        'department',
        'mail',
        'number',
        'givenname',
        'surname',
        'found',
    ];

    /**
     * @return BelongsTo<Member, $this>
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
