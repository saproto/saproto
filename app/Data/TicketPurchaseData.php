<?php

namespace App\Data;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class TicketPurchaseData extends Data
{
    public function __construct(
        public int         $id,
        public bool        $payment_complete,
        public ?string     $scanned,
        public ?UserData   $user,
        public ?TicketData $ticket,
    )
    {
    }
}
