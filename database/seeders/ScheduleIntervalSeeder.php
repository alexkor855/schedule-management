<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\Interval;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ScheduleIntervalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schedules = Schedule::query()
            ->select(['id', 'number_available_days'])
            ->get();

        $interval = Interval::query()->first();

        $days = [];
        foreach (range(1, 30) as $dayNumber) {
            $days[] = [
                'date' => Carbon::now()->addDays($dayNumber)->format('Y-m-d'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ];
        }

        foreach ($schedules as $schedule) {

            $scheduleIntervals = array_map(function ($item) use ($schedule, $interval) {
                $item['id'] = Str::orderedUuid()->toString();
                $item['schedule_id'] = $schedule->id;
                $item['interval_id'] = $interval->id;
                return $item;
            },
                $days
            );

            DB::table('schedule_intervals')->insert($scheduleIntervals);
        }
    }
}
