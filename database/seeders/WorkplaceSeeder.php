<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Enums\AppointmentSchemeEnum;
use App\Models\Workplace;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkplaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $branches = Branch::query()
            ->select(['id', 'appointment_scheme'])
            ->get();

        foreach ($branches as $branch) {
            if (! in_array($branch->appointment_scheme, AppointmentSchemeEnum::schemesWithWorkplace())) {
                continue;
            }
            Workplace::factory()
                ->count(4)
                ->create([
                    'branch_id' => $branch->id,
                ]);
        }
    }
}
