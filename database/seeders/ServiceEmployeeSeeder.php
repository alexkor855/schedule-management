<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Enums\AppointmentSchemeEnum;
use App\Models\ServiceEmployee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceEmployeeSeeder extends Seeder
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
                'branchServices:id,branch_id,service_id',
                'branchEmployees:id,branch_id,employee_id',
            ])
            ->get();

        foreach ($branches as $branch) {
            if (!in_array($branch->appointment_scheme, AppointmentSchemeEnum::schemesWithEmployee())) {
                continue;
            }

            foreach ($branch->branchServices as $branchService) {
                foreach ($branch->branchEmployees as $employeeNumber => $branchEmployee) {
                    if ($employeeNumber % 2 === 1) {
                        continue;
                    }
                    ServiceEmployee::factory()
                        ->create([
                            'branch_id' => $branch->id,
                            'service_id' => $branchService->service_id,
                            'employee_id' => $branchEmployee->employee_id,
                        ]);
                }
            }
        }
    }
}
