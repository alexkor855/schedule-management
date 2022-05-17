<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Enums\AppointmentSchemeEnum;
use App\Models\Enums\ScheduleTypeEnum;
use App\Models\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branches = Branch::query()
            ->select(['id', 'appointment_scheme'])
            ->with([
                'serviceWorkplaces:id,branch_id,service_id,workplace_id',
                'serviceEmployees:id,branch_id,service_id,employee_id',
            ])
            ->get();

        foreach ($branches as $branch) {
            Schedule::factory()
                ->create([
                    'schedule_type' => ScheduleTypeEnum::ForBranch->value,
                    'branch_id' => $branch->id,
                    'time_step' => 15,
                ]);

            if (in_array($branch->appointment_scheme, AppointmentSchemeEnum::schemesWithWorkplace()) &&
                in_array($branch->appointment_scheme, AppointmentSchemeEnum::schemesWithEmployee())
            ) {
                foreach ($branch->serviceWorkplaces as $serviceWorkplace) {
                    $serviceEmployees = $branch->serviceEmployees
                        ->where('service_id', $serviceWorkplace->service_id)->all();

                    foreach ($serviceEmployees as $serviceEmployee) {
                        Schedule::factory()
                            ->create([
                                'schedule_type' => ScheduleTypeEnum::ForEmployeeAndWorkplace->value,
                                'branch_id' => $branch->id,
                                'workplace_id' => $serviceWorkplace->workplace_id,
                                'employee_id' => $serviceEmployee->employee_id,
                                'time_step' => 15,
                            ]);
                    }
                }
            } elseif (in_array($branch->appointment_scheme, AppointmentSchemeEnum::schemesWithEmployee())) {
                foreach ($branch->serviceEmployees as $serviceEmployee) {
                    Schedule::factory()
                        ->create([
                            'schedule_type' => ScheduleTypeEnum::ForEmployee->value,
                            'branch_id' => $branch->id,
                            'employee_id' => $serviceEmployee->employee_id,
                            'time_step' => 15,
                        ]);
                }
            } elseif (in_array($branch->appointment_scheme, AppointmentSchemeEnum::schemesWithWorkplace())) {
                foreach ($branch->serviceWorkplaces as $serviceWorkplace) {
                    Schedule::factory()
                        ->create([
                            'schedule_type' => ScheduleTypeEnum::ForWorkplace->value,
                            'branch_id' => $branch->id,
                            'workplace_id' => $serviceWorkplace->workplace_id,
                            'time_step' => 15,
                        ]);
                }
            }
        }
    }
}
