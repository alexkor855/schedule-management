<?php

namespace App\Services;

use App\Models\Interval;
use Illuminate\Database\Eloquent\Collection;

class GettingIntervalsService
{
    /**
     * Gets intervals by requested ids
     *
     * @param array $intervalIds
     * @return Collection
     */
    public function getIntervalsByIds(array $intervalIds): Collection
    {
        return Interval::query()
            ->select(['id', 'start_time', 'end_time'])
            ->whereIn('id', $intervalIds)
            ->get();
    }
}
