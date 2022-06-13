<?php

namespace App\Models;

use App\Models\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScheduleInterval extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    protected $fillable = [
        'schedule_id',
        'date',
        'interval_id',
    ];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class, 'schedule_id', 'id');
    }

    public function interval(): BelongsTo
    {
        return $this->belongsTo(Interval::class, 'interval_id', 'id');
    }
}
