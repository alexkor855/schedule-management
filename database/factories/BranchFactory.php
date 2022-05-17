<?php

namespace Database\Factories;

use App\Models\Enums\AppointmentSchemeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Branch>
 */
class BranchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = '№ ' . $this->faker->numberBetween(100, 5000);

        return [
            'appointment_scheme' => $this->faker->randomElements(AppointmentSchemeEnum::values())[0],
            'name' => $name,
            'full_name' => $this->faker->text(20),
            'description' => $this->faker->text(20),
            'full_description' => $this->faker->text(),
            'address' => $this->faker->address(),
        ];
    }
}
