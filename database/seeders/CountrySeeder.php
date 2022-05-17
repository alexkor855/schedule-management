<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::factory()->create([
            'name' => 'Germany',
            'full_name' => 'Germany',
        ]);

        Country::factory()->create([
            'name' => 'Netherlands',
            'full_name' => 'Netherlands',
        ]);

        Country::factory()->create([
            'name' => 'UK',
            'full_name' => 'United Kingdom',
        ]);

        Country::factory()->create([
            'name' => 'US',
            'full_name' => 'United States',
        ]);

//        Country::factory()
//            ->count(4)
//            ->hasCities(2)
//            ->create();
    }
}
