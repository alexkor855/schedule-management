<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Enums\AppointmentSchemeEnum;
use App\Models\Enums\ScheduleTypeEnum;
use Tests\TestCase;

class IndexActionOfScheduleControllerTest extends TestCase
{
    /**
     * Test that index returns a successful response
     *
     * @dataProvider dataProvider
     * @return void
     */
    public function test_that_index_returns_a_successful_response(
        ScheduleTypeEnum $scheduleType,
        AppointmentSchemeEnum $appointmentScheme,
        string $assertEmployee,
        string $assertWorkplace
    ): void
    {
        $branch = Branch::query()
            ->with([
                'schedules' => function ($query) use ($scheduleType) {
                    $query->where('schedule_type', $scheduleType->value);
                    $query->first();
                }
            ])
            ->where('appointment_scheme', $appointmentScheme->value)
            ->where('name', '№ 1')
            ->first();

        $schedule = $branch->schedules->first();
        $params = [
            'schedule_type' => $schedule->schedule_type,
            'branch_id' => $branch->id,
            'employee_id' => $schedule->employee_id,
            'workplace_id' => $schedule->workplace_id,
        ];

        $response = $this->getJson('/schedule?' . http_build_query($params));

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'schedule_type',
                    'branch_id',
                    'employee_id',
                    'workplace_id',
                    'time_step',
                    'number_available_days',
                    'branch',
                    'employee',
                    'workplace',
                ]
            ]);

        $data = $response->json();
        $scheduleFromResponse = $data[0];

        $this->assertEquals($scheduleFromResponse['schedule_type'], $scheduleType->value);
        $this->assertEquals($scheduleFromResponse['branch_id'], $branch->id);
        $this->$assertEmployee($scheduleFromResponse['employee_id']);
        $this->$assertWorkplace($scheduleFromResponse['workplace_id']);
    }

    /**
     * Data provider
     *
     * @return array[]
     */
    private function dataProvider(): array
    {
        return [
            'branch schedule' =>
                [ScheduleTypeEnum::ForBranch, AppointmentSchemeEnum::AnyEmployee, 'assertNull', 'assertNull'],
            'employee schedule' =>
                [ScheduleTypeEnum::ForEmployee, AppointmentSchemeEnum::AnyEmployee, 'assertNotEmpty', 'assertNull'],
            'workplace schedule' =>
                [ScheduleTypeEnum::ForWorkplace, AppointmentSchemeEnum::AnyWorkplace, 'assertNull', 'assertNotEmpty'],
            'employee and workplace schedule' =>
                [ScheduleTypeEnum::ForEmployeeAndWorkplace, AppointmentSchemeEnum::SpecificEmployeeAnyWorkplace, 'assertNotEmpty', 'assertNotEmpty'],
        ];
    }
}
