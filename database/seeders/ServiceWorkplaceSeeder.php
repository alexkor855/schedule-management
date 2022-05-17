<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Enums\AppointmentSchemeEnum;
use App\Models\ServiceWorkplace;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceWorkplaceSeeder extends Seeder
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
                'workplaces:id,branch_id',
            ])
            ->get();

        foreach ($branches as $branch) {
            if (!in_array($branch->appointment_scheme, AppointmentSchemeEnum::schemesWithWorkplace())) {
                continue;
            }

            foreach ($branch->branchServices as $branchService) {
                foreach ($branch->workplaces as $workplaceNumber => $workplace) {
                    if ($workplaceNumber % 2 === 1) {
                        continue;
                    }
                    ServiceWorkplace::factory()
                        ->create([
                            'branch_id' => $branch->id,
                            'service_id' => $branchService->service_id,
                            'workplace_id' => $workplace->id,
                        ]);
                }
            }
        }
    }
}
