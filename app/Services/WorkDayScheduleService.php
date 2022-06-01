<?php

namespace App\Services;

use App\Http\Requests\CopyWorkDayScheduleRequest;
use App\Http\Requests\StoreWorkDayScheduleRequest;
use App\Http\Requests\UpdateWorkDayScheduleRequest;
use App\Models\Schedule;
use App\Models\ScheduleInterval;
use App\Models\WorkDaySchedule;
use Illuminate\Database\Eloquent\Collection;

class WorkDayScheduleService
{
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreWorkDayScheduleRequest $request
     * @return Schedule
     */
    public function create(StoreWorkDayScheduleRequest $request): Schedule
    {
        $intervalData = $request->validated('interval');
        $interval = ScheduleInterval::query()->firstOrCreate($intervalData);

        $data = $request->validated();
        if (is_null($data['interval_id'])) {
            $data['interval_id'] = $interval->id;
        }

        /** @var Schedule $schedule */
        $schedule = Schedule::query()->create($data);
        return $schedule;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateWorkDayScheduleRequest $request
     * @return Schedule
     */
    public function update(UpdateWorkDayScheduleRequest $request): Schedule
    {
        $intervalData = $request->validated('interval');
        $interval = ScheduleInterval::query()->firstOrCreate($intervalData);

        $data = $request->validated();
        $schedule = Schedule::query()->find($data['id']);

        if (is_null($data['interval_id'])) {
            $schedule->interval_id = $interval->id;
            $schedule->save();
        }

        return $schedule;
    }

    /**
     * Copy WorkDaySchedules to some days.
     *
     * @param CopyWorkDayScheduleRequest $request
     * @return Collection
     */
    public function copy(CopyWorkDayScheduleRequest $request): Collection
    {
        $copiedDates = $request->to_dates;
        $copiedDayIntervals = $request->workDaySchedules;

        // get schedules for copying
        $scheduleIds = collect($copiedDayIntervals)->pluck('schedule_id')->all();

        // get all day intervals from target days
        $existingWorkDaySchedules = WorkDaySchedule::query()
            ->whereIn('date', $copiedDates)
            ->whereIn('schedule_id', $scheduleIds)
            ->get();

        // search no changing day intervals
        $noChangingWorkDaySchedules = $this->filterByScheduleAndInterval(
            $existingWorkDaySchedules,
            $copiedDayIntervals
        );

        // delete changing day intervals
        $workDaySchedulesToDelete = $existingWorkDaySchedules->except($noChangingWorkDaySchedules->modelKeys());
        Schedule::destroy($workDaySchedulesToDelete->modelKeys());

        // create new day intervals
        $existingWorkDaySchedules = $existingWorkDaySchedules->groupBy(function ($item, $key) {
            return $this->getUniqueKey($item->date, $item->schedule_id, $item->interval_id);
        });

        $result = Collection::empty();
        foreach ($copiedDates as $date) {
            foreach ($copiedDayIntervals as $copiedDayInterval) {
                $searchKey = $this->getUniqueKey(
                    $date,
                    $copiedDayInterval['schedule_id'],
                    $copiedDayInterval['interval_id']
                );

                if (array_key_exists($searchKey, $existingWorkDaySchedules)) {
                    continue;
                }

                $copiedDayInterval['date'] = $date;
                $workDaySchedule = WorkDaySchedule::query()->create($copiedDayInterval);
                $result->add($workDaySchedule);
            }
        }

        return $result;
    }

    /**
     * Delete resources in storage.
     *
     * @param array $ids
     * @return int
     */
    public function delete(array $ids): int
    {
        return Schedule::destroy($ids);
    }

    /**
     * Gets unique key for day schedule interval
     *
     * @param string $date
     * @param string $scheduleId
     * @param string $intervalId
     * @return string
     */
    private function getUniqueKey(string $date, string $scheduleId, string $intervalId): string
    {
        return $date . '|' . $scheduleId . '|' . $intervalId;
    }

    /**
     * Gets key by schedule and interval for day schedule interval
     *
     * @param string $scheduleId
     * @param string $intervalId
     * @return string
     */
    private function getKeyByScheduleAndInterval(string $scheduleId, string $intervalId): string
    {
        return $scheduleId . '|' . $intervalId;
    }

    /**
     * Filters by schedule and interval
     *
     * @param Collection $workDaySchedules
     * @param array $searchData
     * @return Collection
     */
    private function filterByScheduleAndInterval(
        Collection $workDaySchedules,
        array $searchData
    ): Collection
    {
        $result = Collection::empty();

        $indexedWorkDaySchedules = $workDaySchedules->groupBy(function ($item, $key) {
            return $this->getKeyByScheduleAndInterval($item->schedule_id, $item->interval_id);
        });

        foreach ($searchData as $item) {
            $searchKey = $this->getKeyByScheduleAndInterval($item['schedule_id'], $item['interval_id']);
            $result->merge($indexedWorkDaySchedules->get($searchKey, []));
        }

        return $result;
    }
}
