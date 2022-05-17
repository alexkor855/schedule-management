<?php

namespace Database\Seeders;

use App\Models\BranchService;
use App\Models\Company;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
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
            Service::factory()
                ->count(10)
                ->has(
                    BranchService::factory()
                        ->count($company->branches->count())
                        ->sequence(fn ($sequence) => [
                            'branch_id' => $company->branches[$sequence->index % $company->branches->count()]['id']
                        ])
                )
                ->create([
                    'company_id' => $company->id,
                ]);
        }
    }
}
