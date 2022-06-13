<?php

namespace App\Models;

use App\Models\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Schedule
 *
 * @mixin \Eloquent
 * @property string $id
 * @property string $schedule_type
 * @property string $branch_id
 * @property string|null $employee_id
 * @property string|null $workplace_id
 * @property string $time_step Time step in minutes
 * @property int $number_available_days Number of days available for appointment from the current date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ScheduleInterval[] $scheduleIntervals
 * @property-read int|null $schedule_intervals_count
 * @method static \Database\Factories\ScheduleFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule newQuery()
 * @method static \Illuminate\Database\Query\Builder|Schedule onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule query()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereNumberAvailableDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereScheduleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereTimeStep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereWorkplaceId($value)
 * @method static \Illuminate\Database\Query\Builder|Schedule withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Schedule withoutTrashed()
 */
class Schedule extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    protected $fillable = [
        'schedule_type',
        'branch_id',
        'employee_id',
        'workplace_id',
        'time_step',
        'number_available_days',
    ];

    public function scheduleIntervals(): HasMany
    {
        return $this->hasMany(ScheduleInterval::class, 'schedule_id', 'id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function workplace(): BelongsTo
    {
        return $this->belongsTo(Workplace::class, 'workplace_id', 'id');
    }
}
