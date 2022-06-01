<?php

namespace App\Services;

use App\Http\Requests\StoreScheduleRequest;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

class ScheduleService
{
    /**
     * Stores a newly created resource in storage.
     *
     * @param StoreScheduleRequest $request
     * @return Schedule
     */
    public function create(StoreScheduleRequest $request): Schedule
    {
        $data = $request->validated();
        /** @var Schedule $schedule */
        $schedule = Schedule::query()->create($data);
        return $schedule;
    }

    /**
     * Removes the specified resource from storage.
     *
     * @param string $scheduleId
     *
     * @throws \Throwable
     * @return bool
     */
    public function delete(string $scheduleId): bool
    {
        $schedule = Schedule::query()->findOrFail($scheduleId);

        DB::transaction(function () use ($schedule) {
            $schedule->workDaySchedules()->delete();
            return $schedule->delete();
        });

        return true;
    }
}
