<?php

namespace App\Enums;

enum VisibilityEnum: int
{
    case PUBLIC = 0;
    case SECRET = 1;
    case SCHEDULED = 2;
}
