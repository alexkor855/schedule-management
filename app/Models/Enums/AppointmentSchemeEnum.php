<?php

namespace App\Models\Enums;

use App\Models\Traits\EnumValues;

/**
 * Enumeration of appointment schemes
 */
enum AppointmentSchemeEnum: int
{
    use EnumValues;

    case AnyEmployee = 1;
    case AnyWorkplace = 2;
    case SpecificEmployee = 3;
    case SpecificWorkplace = 4;
    case SpecificEmployeeAnyWorkplace = 5;
    case SpecificWorkplaceAnyEmployee = 6;

    public static function schemesWithEmployee(): array
    {
        return [
            self::AnyEmployee->value,
            self::SpecificEmployee->value,
            self::SpecificEmployeeAnyWorkplace->value,
            self::SpecificWorkplaceAnyEmployee->value,
        ];
    }

    public static function schemesWithWorkplace(): array
    {
        return [
            self::AnyWorkplace->value,
            self::SpecificWorkplace->value,
            self::SpecificEmployeeAnyWorkplace->value,
            self::SpecificWorkplaceAnyEmployee->value,
        ];
    }
}
