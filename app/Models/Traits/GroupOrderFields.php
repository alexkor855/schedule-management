<?php

namespace App\Models\Traits;

trait GroupOrderFields
{
    /**
     * Generates service attributes: group_order_flag, max_simultaneous_customers, min_simultaneous_customers
     * with some probability for test data
     *
     * @return array
     */
    public function getGroupOrderParams(): array
    {
        $hasSimultaneousCustomers = $this->faker->numberBetween(1, 100) < 20; // 20%
        $groupOrderFlag = false;
        $minSimultaneousCustomers = null;
        $maxSimultaneousCustomers = null;
        $namePrefix = '';

        if ($hasSimultaneousCustomers) {
            $maxSimultaneousCustomers = $this->faker->numberBetween(2, 100);
            $diffNumber = $maxSimultaneousCustomers - $this->faker->numberBetween(2, 100);
            $minSimultaneousCustomers = $diffNumber > 1 ? $diffNumber : null;
            $groupOrderFlag = $this->faker->numberBetween(1, 100) > 50; // 50%
            $namePrefix = 'Many ' .
                ($groupOrderFlag ? 'multi orders ' : 'single orders ') .
                ($maxSimultaneousCustomers ? ('max=' . $maxSimultaneousCustomers) : '') .
                ($minSimultaneousCustomers ? (' min=' . $minSimultaneousCustomers) : '') .
                ' ';
        }

        return [$namePrefix, $groupOrderFlag, $minSimultaneousCustomers, $maxSimultaneousCustomers];
    }
}
