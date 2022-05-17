<?php

namespace App\Models\Enums;

use App\Models\Traits\EnumValues;

/**
 * Enumeration of schedule types
 */
enum TimeStepEnum: int
{
    use EnumValues;

    case OneMinute = 1;
    case FiveMinutes = 5;
    case TenMinutes = 10;
    case FifteenMinutes = 15;
    case TwentyMinutes = 20;
    case ThirtyMinutes = 30;
    case SixtyMinutes = 60;
}
