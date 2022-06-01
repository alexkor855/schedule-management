<?php

namespace App\Models;

use App\Models\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WorkDaySchedule[] $workDaySchedules
 * @property-read int|null $work_day_schedules_count
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

    public function workDaySchedules(): HasMany
    {
        return $this->hasMany(WorkDaySchedule::class, 'schedule_id', 'id');
    }
}
