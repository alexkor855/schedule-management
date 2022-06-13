<?php

namespace App\Models;

use App\Models\Traits\Uuids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interval extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    protected $fillable = [
        'start_time',
        'end_time',
    ];

    /**
     * Get/set start time
     *
     * @return Attribute
     */
    protected function startTime(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => substr($value, 0, 5),
            set: fn ($value) => $value . ':00',
        );
    }

    /**
     * Get/set end time
     *
     * @return Attribute
     */
    protected function endTime(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => substr($value, 0, 5),
            set: fn ($value) => $value . ':00',
        );
    }

}
