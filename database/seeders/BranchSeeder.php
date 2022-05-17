<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $countries = Country::query()
            ->select(['id', 'name'])
            ->with([
                'cities:id,country_id',
                'companies:id,country_id,appointment_scheme,name'
            ])
            ->get();

        foreach ($countries as $country) {
            foreach ($country->companies as $company) {
                foreach ($country->cities as $number => $city) {
                    Branch::factory()
                        ->count(2)
                        ->sequence(fn ($sequence) => ['name' => '№ '. (($number * 2) + $sequence->index + 1)])
                        ->create([
                            'company_id' => $company->id,
                            'city_id' => $city->id,
                            'appointment_scheme' => $company->appointment_scheme,
                        ]);
                }
            }
        }
    }
}
