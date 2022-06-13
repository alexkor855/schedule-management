<?php

namespace Tests\Feature;

use App\Models\Schedule;
use Carbon\Carbon;
use Tests\TestCase;

class IndexActionOfScheduleIntervalControllerTest extends TestCase
{
    /**
     * Test that index returns a successful response
     *
     * @return void
     */
    public function test_that_index_returns_a_successful_response(): void
    {
        $schedules = Schedule::query()->limit(2)->get();

        $params = [
            'schedule_ids' => $schedules->pluck('id')->all(),
            'start_date' => Carbon::now()->format('Y-m-d'),
            'end_date' => Carbon::now()->addDays(30)->format('Y-m-d'),
        ];

        $response = $this->getJson('/schedule-interval?' . http_build_query($params));

        $response
            ->assertOk()
            ->assertJsonStructure([
                'schedule_intervals' => [
                    '*' => [
                        'id',
                        'schedule_id',
                        'date',
                        'interval_id',
                    ]
                ],
                'intervals' => [
                    '*' => [
                        'id',
                        'start_time',
                        'end_time',
                    ]
                ],
            ]);
    }
}
