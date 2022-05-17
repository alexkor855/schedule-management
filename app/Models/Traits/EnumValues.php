<?php

namespace App\Models\Traits;

trait EnumValues
{
    /**
     * Returns enumeration values
     *
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
