<?php

namespace Tests\Feature;

use App\Models\Enums\ScheduleTypeEnum;
use App\Models\Interval;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ScheduleIntervalControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected bool $seed = true;

    /**
     * Test that store returns a successful response
     *
     * @dataProvider dataProviderForSuccessfulResponses
     *
     * @param ScheduleTypeEnum $scheduleType
     * @param string $date
     * @param bool $mastSearchInterval
     * @param string $startTime
     * @param string $endTime
     * @return void
     */
    public function test_that_store_returns_a_successful_response(
        ScheduleTypeEnum $scheduleType,
        string $date,
        bool $mastSearchInterval,
        string $startTime,
        string $endTime

    ): void
    {
        $params = $this->getParams($scheduleType, $date, $mastSearchInterval, $startTime, $endTime);

        $response = $this
            ->postJson('/schedule-interval', $params)
            ->assertCreated()
            ->assertJsonStructure([
                'id',
                'schedule_id',
                'date',
                'interval_id',
                'interval' => [
                    'id',
                    'start_time',
                    'end_time',
                ],
            ]);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData['id']);
        $this->assertEquals($params['schedule_id'], $responseData['schedule_id']);
        $this->assertEquals($params['date'], $responseData['date']);
        $this->assertNotEmpty($responseData['interval_id']);

        if ($mastSearchInterval) {
            $this->assertEquals($params['interval_id'], $responseData['interval_id']);
            $this->assertEquals($params['interval_id'], $responseData['interval']['id']);
        } else {
            $this->assertNotEmpty($responseData['interval_id']);
            $this->assertNotEmpty($responseData['interval']['id']);
        }
        $this->assertEquals($params['interval']['start_time'], $responseData['interval']['start_time']);
        $this->assertEquals($params['interval']['end_time'], $responseData['interval']['end_time']);
    }

    /**
     * Data provider for successful responses
     *
     * @return array[]
     */
    private function dataProviderForSuccessfulResponses(): array
    {
        $date = Carbon::now()->addDays(1)->format('Y-m-d');
        return [
            'branch schedule' => [ScheduleTypeEnum::ForBranch, $date, true, '13:00', '17:00'],
            'employee schedule' => [ScheduleTypeEnum::ForEmployee, $date, false, '13:00', '17:00'],
            'workplace schedule' => [ScheduleTypeEnum::ForWorkplace, $date, false, '13:00', '19:00'],
            'employee and workplace schedule' =>
                [ScheduleTypeEnum::ForEmployeeAndWorkplace, $date, false, '13:00', '17:15'],
        ];
    }

    /**
     * Test that store throws an exception response
     *
     * @dataProvider dataProviderForException
     *
     * @param ScheduleTypeEnum $scheduleType
     * @param string $date
     * @param bool $mastSearchInterval
     * @param string $startTime
     * @param string $endTime
     * @return void
     */
    public function test_that_store_throws_a_exception_response(
        ScheduleTypeEnum $scheduleType,
        string $date,
        bool $mastSearchInterval,
        string $startTime,
        string $endTime

    ): void
    {
        $this->expectException(ValidationException::class);

        $params = $this->getParams($scheduleType, $date, $mastSearchInterval, $startTime, $endTime);

        $response = $this->withoutExceptionHandling()->postJson('/schedule-interval', $params);
    }

    /**
     * Data provider for exceptions
     *
     * @return array[]
     */
    private function dataProviderForException(): array
    {
        $date = Carbon::now()->addDays(1)->format('Y-m-d');
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        return [
            'invalid date, yesterday' => [ScheduleTypeEnum::ForBranch, $yesterday, true, '13:00', '17:00'],
            'invalid date' => [ScheduleTypeEnum::ForBranch, '', false, '13:00', '17:00'],
            'invalid time step, 17:01' => [ScheduleTypeEnum::ForEmployee, $date, false, '13:00', '17:01'],
            'invalid time step, 13:50' => [ScheduleTypeEnum::ForEmployee, $date, false, '13:50', '17:00'],
            'invalid interval' => [ScheduleTypeEnum::ForWorkplace, $date, false, '19:00', '13:00'],
        ];
    }

    /**
     * Get params for ScheduleInterval
     *
     * @param ScheduleTypeEnum $scheduleType
     * @param string $date
     * @param bool $mastSearchInterval
     * @param string $startTime
     * @param string $endTime
     * @return array
     */
    private function getParams(
        ScheduleTypeEnum $scheduleType,
        string $date,
        bool $mastSearchInterval,
        string $startTime,
        string $endTime

    ): array
    {
        $schedule = Schedule::query()
            ->where('schedule_type', $scheduleType->value)
            ->limit(1)
            ->first();

        $params = [
            'schedule_id' => $schedule->id,
            'date' => $date,
            'interval_id' => null,
            'interval' => [
                'id' => null,
                'start_time' => $startTime,
                'end_time' => $endTime,
            ]
        ];

        if ($mastSearchInterval) {
            $interval = Interval::query()
                ->where('start_time', $startTime)
                ->where('end_time', $endTime)
                ->first();

            if ($interval instanceof Interval) {
                $params['interval_id'] = $interval->id;
                $params['interval']['id'] = $interval->id;
            }
        }

        return $params;
    }
}
