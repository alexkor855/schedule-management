<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ScheduleDayInterval>
 */
class ScheduleDayIntervalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $start = $this->faker->time('H:0:0', 'yesterday');
        $end = $this->faker->dateTimeInInterval($start, '+ 5 hour');
        $end = $end->format('H:i:0');

        if ($start > $end) {
            [$start, $end] = [$end, $start];
        }

        return [
            'start_time' => $start,
            'end_time' => $end,
        ];
    }
}
