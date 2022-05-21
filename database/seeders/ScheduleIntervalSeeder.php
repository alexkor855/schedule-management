<?php

namespace Database\Seeders;

use App\Models\ScheduleInterval;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleIntervalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ScheduleInterval::factory()->create(['start_time' => '06:00:00', 'end_time' => '12:00:00']);
        ScheduleInterval::factory()->create(['start_time' => '07:00:00', 'end_time' => '12:00:00']);
        ScheduleInterval::factory()->create(['start_time' => '08:00:00', 'end_time' => '12:00:00']);
        ScheduleInterval::factory()->create(['start_time' => '09:00:00', 'end_time' => '13:00:00']);
        ScheduleInterval::factory()->create(['start_time' => '10:00:00', 'end_time' => '14:00:00']);
        ScheduleInterval::factory()->create(['start_time' => '11:00:00', 'end_time' => '14:00:00']);
        ScheduleInterval::factory()->create(['start_time' => '12:00:00', 'end_time' => '16:00:00']);
        ScheduleInterval::factory()->create(['start_time' => '12:00:00', 'end_time' => '17:00:00']);
        ScheduleInterval::factory()->create(['start_time' => '12:00:00', 'end_time' => '18:00:00']);
        ScheduleInterval::factory()->create(['start_time' => '13:00:00', 'end_time' => '17:00:00']);
        ScheduleInterval::factory()->create(['start_time' => '13:00:00', 'end_time' => '18:00:00']);
        ScheduleInterval::factory()->create(['start_time' => '14:00:00', 'end_time' => '18:00:00']);
        ScheduleInterval::factory()->create(['start_time' => '14:00:00', 'end_time' => '19:00:00']);
    }
}
