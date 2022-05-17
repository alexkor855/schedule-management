<?php

namespace App\Models\Enums;

use App\Models\Traits\EnumValues;

/**
 * Enumeration of schedule types
 */
enum ScheduleTypeEnum: int
{
    use EnumValues;

    case ForBranch = 1;
    case ForEmployee = 2;
    case ForWorkplace = 3;
    case ForEmployeeAndWorkplace = 4;
}
