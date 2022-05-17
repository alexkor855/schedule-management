<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = Country::query()->get(['id', 'name'])->pluck('id', 'name');

        City::factory()->create([
            'name' => 'Berlin',
            'country_id' => $countries['Germany'],
        ]);

        City::factory()->create([
            'name' => 'Hamburg',
            'country_id' => $countries['Germany'],
        ]);

        City::factory()->create([
            'name' => 'Amsterdam',
            'country_id' => $countries['Netherlands'],
        ]);

        City::factory()->create([
            'name' => 'Rotterdam',
            'country_id' => $countries['Netherlands'],
        ]);

        City::factory()->create([
            'name' => 'London',
            'country_id' => $countries['UK'],
        ]);

        City::factory()->create([
            'name' => 'Manchester',
            'country_id' => $countries['UK'],
        ]);

        City::factory()->create([
            'name' => 'New York',
            'country_id' => $countries['US'],
        ]);

        City::factory()->create([
            'name' => 'Los Angeles',
            'country_id' => $countries['US'],
        ]);
    }
}
