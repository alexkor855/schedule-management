<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $countries = Country::query()->get(['id', 'name'])->pluck('id', 'name');

        Company::factory()->create([
            'country_id' => $countries['Germany'],
            'appointment_scheme' => 1,
            'name' => 'Company 1',
        ]);

        Company::factory()->create([
            'country_id' => $countries['Germany'],
            'appointment_scheme' => 2,
            'name' => 'Company 2',
        ]);

        Company::factory()->create([
            'country_id' => $countries['Netherlands'],
            'appointment_scheme' => 3,
            'name' => 'Company 3',
        ]);

        Company::factory()->create([
            'country_id' => $countries['UK'],
            'appointment_scheme' => 4,
            'name' => 'Company 4',
        ]);

        Company::factory()->create([
            'country_id' => $countries['US'],
            'appointment_scheme' => 5,
            'name' => 'Company 5',
        ]);

        Company::factory()->create([
            'country_id' => $countries['US'],
            'appointment_scheme' => 6,
            'name' => 'Company 6',
        ]);

//        Company::factory()
//            ->count(20)
//            ->state(new Sequence(
//                fn ($sequence) => ['country_id' => $countries->random()],
//            ))
//            ->create();
    }
}
