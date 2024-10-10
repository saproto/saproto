<?php

namespace App\Data;

use Illuminate\Database\Eloquent\Collection;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class TicketData extends Data
{
    public function __construct(
        public int          $id,
        public ActivityData $event,
        public ProductData  $product,
        /** @var Collection<TicketPurchaseData> */
        public array        $purchases,
    )
    {
    }
}
