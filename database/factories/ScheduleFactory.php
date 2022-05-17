<?php

namespace Database\Factories;

use App\Models\Enums\ScheduleTypeEnum;
use App\Models\Enums\TimeStepEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'schedule_type' => $this->faker->randomElement(ScheduleTypeEnum::values()),
            'time_step' => $this->faker->randomElement(TimeStepEnum::values()),
            'number_available_days' => 15,
        ];
    }
}
