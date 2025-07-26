<?php

namespace App\Enums;

enum PhotoEnum: string
{
    case ORIGINAL = 'original';
    case LARGE = 'large';
    case MEDIUM = 'medium';
    case SMALL = 'small';
}
