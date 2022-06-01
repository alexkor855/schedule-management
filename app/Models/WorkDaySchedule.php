<?php

namespace App\Models;

use App\Models\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkDaySchedule extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class, 'schedule_id', 'id');
    }
}
