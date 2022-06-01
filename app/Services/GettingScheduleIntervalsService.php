<?php

namespace App\Services;

use App\Http\Resources\IntervalResource;
use App\Http\Resources\ScheduleIntervalResource;
use App\Models\ScheduleInterval;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;

class GettingScheduleIntervalsService
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
     * Searches for schedule intervals.
     *
     * @param array $scheduleIds
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    #[ArrayShape(['schedule_intervals' => "array", 'intervals' => "array"])]
    public function search(
        array $scheduleIds,
        string $startDate,
        string $endDate
    ): array
    {
        $scheduleIntervals = $this->getByIdsAndDate($scheduleIds, $startDate, $endDate);

        $intervalIds = $scheduleIntervals->pluck('interval_id')->all();
        $intervals = $this->gettingIntervalsService->getIntervalsByIds($intervalIds);

        return [
            'schedule_intervals' => ScheduleIntervalResource::collection($scheduleIntervals)->toArray(new Request()),
            'intervals' => IntervalResource::collection($intervals->keyBy('id'))->toArray(new Request()),
        ];
    }

    /**
     * Gets schedule intervals by requested ids and dates
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
        return ScheduleInterval::query()
            ->select(['id', 'schedule_id', 'date', 'interval_id'])
            ->whereIn('schedule_id', $scheduleIds)
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->get();
    }
}
