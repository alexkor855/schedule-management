<?php

namespace Database\Factories;

use App\Models\Enums\AppointmentSchemeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = $this->faker->company();

        return [
            'appointment_scheme' => $this->faker->randomElements(AppointmentSchemeEnum::values())[0],
            'name' => $name,
            'full_name' => $name,
            'description' => $this->faker->text(20),
            'full_description' => $this->faker->text(),
            'logotype' => $this->faker->imageUrl(640, 480, $name, true),
        ];
    }
}
