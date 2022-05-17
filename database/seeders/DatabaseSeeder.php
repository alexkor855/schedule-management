<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountrySeeder::class);
        $this->call(CitySeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(BranchSeeder::class);

        $this->call(ServiceSeeder::class);
        $this->call(WorkplaceSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(ServiceEmployeeSeeder::class);
        $this->call(ServiceWorkplaceSeeder::class);

        $this->call(ScheduleDayIntervalSeeder::class);
        $this->call(ScheduleSeeder::class);
        $this->call(ScheduleWorkDaySeeder::class);
    }
}
