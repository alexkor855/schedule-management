<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Enums\AppointmentSchemeEnum;
use App\Models\Enums\ScheduleTypeEnum;
use App\Models\Enums\TimeStepEnum;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleControllerTest extends TestCase
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
     * @dataProvider dataProvider
     *
     * @param ScheduleTypeEnum $scheduleType
     * @param AppointmentSchemeEnum $appointmentScheme
     * @return void
     */
    public function test_that_store_returns_a_successful_response(
        ScheduleTypeEnum $scheduleType,
        AppointmentSchemeEnum $appointmentScheme

    ): void
    {
        $params = $this->getParams($scheduleType, $appointmentScheme, false);

        if ($scheduleType === ScheduleTypeEnum::ForBranch) {
            $schedule = $this->getScheduleByParams($params);
            $schedule->delete();
        }

        $response = $this
            ->postJson('/schedule', $params)
            ->assertCreated()
            ->assertJsonStructure([
                'id',
                'schedule_type',
                'branch_id',
                'employee_id',
                'workplace_id',
                'time_step',
                'number_available_days',
            ]);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData['id']);
        $this->assertEquals($scheduleType->value, $responseData['schedule_type']);
        $this->assertEquals($params['branch_id'], $responseData['branch_id']);
        $this->assertEquals($params['employee_id'], $responseData['employee_id']);
        $this->assertEquals($params['workplace_id'], $responseData['workplace_id']);
        $this->assertEquals($params['time_step'], $responseData['time_step']);
        $this->assertEquals($params['number_available_days'], $responseData['number_available_days']);
    }

    /**
     * Test that destroy returns a successful response
     *
     * @dataProvider dataProvider
     *
     * @param ScheduleTypeEnum $scheduleType
     * @param AppointmentSchemeEnum $appointmentScheme
     * @return void
     */
    public function test_that_destroy_returns_a_successful_response(
        ScheduleTypeEnum $scheduleType,
        AppointmentSchemeEnum $appointmentScheme

    ): void
    {
        $params = $this->getParams($scheduleType, $appointmentScheme, true);
        $schedule = $this->getScheduleByParams($params);

        $response = $this->deleteJson('/schedule', ['schedule_id' => $schedule->id]);

        $response->assertOk();
    }

    /**
     * Data provider
     *
     * @return array[]
     */
    private function dataProvider(): array
    {
        return [
            'branch schedule' => [ScheduleTypeEnum::ForBranch, AppointmentSchemeEnum::AnyEmployee],
            'employee schedule' => [ScheduleTypeEnum::ForEmployee, AppointmentSchemeEnum::AnyEmployee],
            'workplace schedule' => [ScheduleTypeEnum::ForWorkplace, AppointmentSchemeEnum::AnyWorkplace],
            'employee and workplace schedule' =>
                [ScheduleTypeEnum::ForEmployeeAndWorkplace, AppointmentSchemeEnum::SpecificEmployeeAnyWorkplace],
        ];
    }

    /**
     * Gets params for schedule
     *
     * @return array[]
     */
    private function getParams(
        ScheduleTypeEnum $scheduleType,
        AppointmentSchemeEnum $appointmentScheme,
        bool $hasSchedule
    ): array
    {
        $branch = Branch::query()
            ->with([
                'branchEmployees' => function ($query) {
                    $query->select(['id', 'branch_id', 'employee_id']);
                    $query->orderBy('id');
                },
                'workplaces' => function ($query) {
                    $query->select(['id', 'branch_id']);
                    $query->orderBy('id');
                },
            ])
            ->where('appointment_scheme', $appointmentScheme->value)
            ->where('name', '№ 1')
            ->first();

        $data = [];
        $number = $hasSchedule ? 0 : 1;

        $commonParams = [
            'branch_id' => $branch->id,
            'time_step' => collect(TimeStepEnum::values())->random(),
            'number_available_days' => 10,
        ];

        if ($scheduleType === ScheduleTypeEnum::ForBranch) {
            $data = [
                'schedule_type' => ScheduleTypeEnum::ForBranch->value,
                'employee_id' => null,
                'workplace_id' => null,
            ];
        }

        if ($scheduleType === ScheduleTypeEnum::ForEmployee) {
            $data = [
                'schedule_type' => ScheduleTypeEnum::ForEmployee->value,
                'employee_id' => $branch->branchEmployees[$number]->employee_id,
                'workplace_id' => null,
            ];
        }

        if ($scheduleType === ScheduleTypeEnum::ForWorkplace) {
            $data = [
                'schedule_type' => ScheduleTypeEnum::ForWorkplace->value,
                'employee_id' => null,
                'workplace_id' => $branch->workplaces[$number]->id,
            ];
        }

        if ($scheduleType === ScheduleTypeEnum::ForEmployeeAndWorkplace) {
            $data = [
                'schedule_type' => ScheduleTypeEnum::ForEmployeeAndWorkplace->value,
                'employee_id' => $branch->branchEmployees[$number]->employee_id,
                'workplace_id' => $branch->workplaces[$number]->id,
            ];
        }

        return array_merge($data, $commonParams);
    }

    /**
     * Gets schedule by params
     *
     * @param array $params
     * @return Schedule
     */
    private function getScheduleByParams(array $params): Schedule
    {
        return Schedule::query()
            ->where('schedule_type', $params['schedule_type'])
            ->where('branch_id', $params['branch_id'])
            ->where('employee_id', $params['employee_id'])
            ->where('workplace_id', $params['workplace_id'])
            ->first();
    }
}
