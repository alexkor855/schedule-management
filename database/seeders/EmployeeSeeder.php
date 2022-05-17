<?php

namespace Database\Seeders;

use App\Models\BranchEmployee;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Enums\AppointmentSchemeEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $companies = Company::query()
            ->select(['id'])
            ->with(['branches:id,company_id,appointment_scheme'])
            ->get();

        foreach ($companies as $company) {
            foreach ($company->branches as $branch) {
                if (!in_array($branch->appointment_scheme, AppointmentSchemeEnum::schemesWithEmployee())) {
                    continue;
                }

                Employee::factory()
                    ->count(4)
                    ->has(
                        BranchEmployee::factory()
                            ->state(function (array $attributes) use ($branch) {
                                return ['branch_id' => $branch->id];
                            })
                    )
                    ->create([
                        'company_id' => $company->id,
                    ]);
            }
        }
    }
}
