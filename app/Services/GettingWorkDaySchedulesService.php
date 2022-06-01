<?php

namespace App\Services;

use App\Http\Resources\IntervalResource;
use App\Http\Resources\WorkDayScheduleResource;
use App\Models\WorkDaySchedule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;

class GettingWorkDaySchedulesService
{
    private GettingIntervalsService $gettingIntervalsService;

    /**
     * @param GettingIntervalsService $gettingIntervalsService
     */
    public function __construct(GettingIntervalsService $gettingIntervalsService)
    {
        $this->gettingIntervalsService = $gettingIntervalsService;
    }

    /**
     * Searches for work day intervals.
     *
     * @param array $scheduleIds
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    #[ArrayShape(['work_day_schedules' => "array", 'intervals' => "array"])]
    public function search(
        array $scheduleIds,
        string $startDate,
        string $endDate
    ): array
    {
        $workDaySchedules = $this->getByIdsAndDate($scheduleIds, $startDate, $endDate);

        $intervalIds = $workDaySchedules->pluck('interval_id')->all();
        $intervals = $this->gettingIntervalsService->getIntervalsByIds($intervalIds);

        return [
            'work_day_schedules' => WorkDayScheduleResource::collection($workDaySchedules)->toArray(new Request()),
            'intervals' => IntervalResource::collection($intervals->keyBy('id'))->toArray(new Request()),
        ];
    }

    /**
     * Gets work day intervals by requested ids and dates
     *
     * @param array $scheduleIds
     * @param string $startDate
     * @param string $endDate
     * @return Collection
     */
    public function getByIdsAndDate(
        array $scheduleIds,
        string $startDate,
        string $endDate
    ): Collection
    {
        return WorkDaySchedule::query()
            ->select(['id', 'schedule_id', 'date', 'interval_id'])
            ->whereIn('schedule_id', $scheduleIds)
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->get();
    }
}
