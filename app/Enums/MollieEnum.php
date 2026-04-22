<?php

namespace App\Enums;

enum MollieEnum: string
{
    case PAID = 'paid';
    case FAILED = 'failed';
    case OPEN = 'open';
    case UNKNOWN = 'unknown';
}
