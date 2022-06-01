<?php

namespace App\Services;

use App\Models\ScheduleInterval;
use Illuminate\Database\Eloquent\Collection;

class GettingScheduleIntervalsService
{
    /**
     * Gets intervals by requested ids
     *
     * @param array $intervalIds
     * @return Collection
     */
    public function getIntervalsByIds(array $intervalIds): Collection
    {
        return ScheduleInterval::query()
            ->select(['id', 'start_time', 'end_time'])
            ->whereIn('id', $intervalIds)
            ->get();
    }
}
