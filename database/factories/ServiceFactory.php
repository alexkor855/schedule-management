<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Traits\GroupOrderFields;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    use GroupOrderFields;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        [$name, $groupOrderFlag, $minSimultaneousCustomers, $maxSimultaneousCustomers] = $this->getGroupOrderParams();

        return [
            'name' => $name . $this->faker->text(20),
            'full_name' => $this->faker->text(100),
            'description' => $this->faker->text(20),
            'full_description' => $this->faker->text(),
            'duration' => $this->faker->numberBetween(5, 120),
            'group_order_flag' => $groupOrderFlag,
            'min_simultaneous_customers' => $minSimultaneousCustomers,
            'max_simultaneous_customers' => $maxSimultaneousCustomers,
        ];
    }
}
