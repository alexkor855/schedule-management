<?php

namespace Database\Seeders;

use App\Models\Interval;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IntervalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Interval::factory()->create(['start_time' => '06:00', 'end_time' => '12:00']);
        Interval::factory()->create(['start_time' => '07:00', 'end_time' => '12:00']);
        Interval::factory()->create(['start_time' => '08:00', 'end_time' => '12:00']);
        Interval::factory()->create(['start_time' => '09:00', 'end_time' => '13:00']);
        Interval::factory()->create(['start_time' => '10:00', 'end_time' => '14:00']);
        Interval::factory()->create(['start_time' => '11:00', 'end_time' => '14:00']);
        Interval::factory()->create(['start_time' => '12:00', 'end_time' => '16:00']);
        Interval::factory()->create(['start_time' => '12:00', 'end_time' => '17:00']);
        Interval::factory()->create(['start_time' => '12:00', 'end_time' => '18:00']);
        Interval::factory()->create(['start_time' => '13:00', 'end_time' => '17:00']);
        Interval::factory()->create(['start_time' => '13:00', 'end_time' => '18:00']);
        Interval::factory()->create(['start_time' => '14:00', 'end_time' => '18:00']);
        Interval::factory()->create(['start_time' => '14:00', 'end_time' => '19:00']);
    }
}
