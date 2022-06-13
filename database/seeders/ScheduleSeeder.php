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
                'branchEmployees:branch_id,employee_id',
                'workplaces:id,branch_id',
            ])
            ->orderBy('id')
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
                foreach ($branch->workplaces as $workplaceNumber => $workplace) {
                    if ($workplaceNumber % 2 === 1) {
                        continue;
                    }
                    foreach ($branch->branchEmployees as $employeeNumber => $branchEmployee) {
                        if ($employeeNumber % 2 === 1) {
                            continue;
                        }
                        Schedule::factory()
                            ->create([
                                'schedule_type' => ScheduleTypeEnum::ForEmployeeAndWorkplace->value,
                                'branch_id' => $branch->id,
                                'workplace_id' => $workplace->id,
                                'employee_id' => $branchEmployee->employee_id,
                                'time_step' => 15,
                            ]);
                    }
                }
            } elseif (in_array($branch->appointment_scheme, AppointmentSchemeEnum::schemesWithEmployee())) {
                foreach ($branch->branchEmployees as $employeeNumber => $branchEmployee) {
                    if ($employeeNumber % 2 === 1) {
                        continue;
                    }
                    Schedule::factory()
                        ->create([
                            'schedule_type' => ScheduleTypeEnum::ForEmployee->value,
                            'branch_id' => $branch->id,
                            'employee_id' => $branchEmployee->employee_id,
                            'time_step' => 15,
                        ]);
                }
            } elseif (in_array($branch->appointment_scheme, AppointmentSchemeEnum::schemesWithWorkplace())) {
                foreach ($branch->workplaces as $workplaceNumber => $workplace) {
                    if ($workplaceNumber % 2 === 1) {
                        continue;
                    }
                    Schedule::factory()
                        ->create([
                            'schedule_type' => ScheduleTypeEnum::ForWorkplace->value,
                            'branch_id' => $branch->id,
                            'workplace_id' => $workplace->id,
                            'time_step' => 15,
                        ]);
                }
            }
        }
    }
}
