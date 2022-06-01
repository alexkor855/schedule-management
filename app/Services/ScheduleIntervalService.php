<?php

namespace App\Services;

use App\Http\Requests\CopyScheduleIntervalsRequest;
use App\Http\Requests\StoreScheduleIntervalRequest;
use App\Http\Requests\UpdateScheduleIntervalRequest;
use App\Models\Schedule;
use App\Models\Interval;
use App\Models\ScheduleInterval;
use Illuminate\Database\Eloquent\Collection;

class ScheduleIntervalService
{
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreScheduleIntervalRequest $request
     * @return Schedule
     */
    public function create(StoreScheduleIntervalRequest $request): Schedule
    {
        $intervalData = $request->validated('interval');
        $interval = Interval::query()->firstOrCreate($intervalData);

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
     * @param UpdateScheduleIntervalRequest $request
     * @return Schedule
     */
    public function update(UpdateScheduleIntervalRequest $request): Schedule
    {
        $intervalData = $request->validated('interval');
        $interval = Interval::query()->firstOrCreate($intervalData);

        $data = $request->validated();
        $schedule = Schedule::query()->find($data['id']);

        if (is_null($data['interval_id'])) {
            $schedule->interval_id = $interval->id;
            $schedule->save();
        }

        return $schedule;
    }

    /**
     * Copy ScheduleIntervals to some days.
     *
     * @param CopyScheduleIntervalsRequest $request
     * @return Collection
     */
    public function copy(CopyScheduleIntervalsRequest $request): Collection
    {
        $copiedDates = $request->to_dates;
        $copiedDayIntervals = $request->scheduleIntervals;

        // get schedules for copying
        $scheduleIds = collect($copiedDayIntervals)->pluck('schedule_id')->all();

        // get schedule intervals for target days
        $existingScheduleIntervals = ScheduleInterval::query()
            ->whereIn('date', $copiedDates)
            ->whereIn('schedule_id', $scheduleIds)
            ->get();

        // searches day intervals which not changed
        $noChangingScheduleIntervals = $this->filterByScheduleAndInterval(
            $existingScheduleIntervals,
            $copiedDayIntervals
        );

        // delete changed day intervals
        $scheduleIntervalsToDelete = $existingScheduleIntervals->except($noChangingScheduleIntervals->modelKeys());
        Schedule::destroy($scheduleIntervalsToDelete->modelKeys());

        // create new day intervals
        $existingScheduleIntervals = $existingScheduleIntervals->groupBy(function ($item, $key) {
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

                if (array_key_exists($searchKey, $existingScheduleIntervals)) {
                    continue;
                }

                $copiedDayInterval['date'] = $date;
                $scheduleInterval = ScheduleInterval::query()->create($copiedDayInterval);
                $result->add($scheduleInterval);
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
     * Gets key by date, schedule and interval
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
     * Gets key by schedule and interval
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
     * @param Collection $scheduleIntervals
     * @param array $searchData
     * @return Collection
     */
    private function filterByScheduleAndInterval(
        Collection $scheduleIntervals,
        array $searchData
    ): Collection
    {
        $result = Collection::empty();

        $indexedScheduleIntervals = $scheduleIntervals->groupBy(function ($item, $key) {
            return $this->getKeyByScheduleAndInterval($item->schedule_id, $item->interval_id);
        });

        foreach ($searchData as $item) {
            $searchKey = $this->getKeyByScheduleAndInterval($item['schedule_id'], $item['interval_id']);
            $result->merge($indexedScheduleIntervals->get($searchKey, []));
        }

        return $result;
    }
}
