<?php

namespace App\Services;

use App\Models\Enums\ScheduleTypeEnum;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Collection;

class GettingSchedulesService
{
    /**
     * Searches for schedules.
     *
     * @param int $scheduleType
     * @param string $branchId
     * @param string|null $employeeId
     * @param string|null $workplaceId
     * @return Collection
     */
    public function search(
        int $scheduleType,
        string $branchId,
        ?string $employeeId,
        ?string $workplaceId
    ): Collection
    {
        $query = Schedule::query()
            ->where('schedule_type', $scheduleType)
            ->where('branch_id', $branchId);

        if ($scheduleType === ScheduleTypeEnum::ForEmployee->value && !empty($employeeId)) {
            $query->where('employee_id', $employeeId);
        }

        if ($scheduleType === ScheduleTypeEnum::ForWorkplace->value && !empty($workplaceId)) {
            $query->where('workplace_id', $workplaceId);
        }

        if ($scheduleType === ScheduleTypeEnum::ForEmployeeAndWorkplace->value) {
            if (!empty($employeeId)) {
                $query->where('employee_id', $employeeId);
            }

            if (!empty($workplaceId)) {
                $query->where('workplace_id', $workplaceId);
            }
        }

        return $query
            ->with([
                'branch:id,name',
                'employee:id,first_name,last_name,middle_name,gender',
                'workplace:id,name',
            ])
            ->get();
    }
}
