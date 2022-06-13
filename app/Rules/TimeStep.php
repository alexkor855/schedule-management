<?php

namespace App\Rules;

use App\Models\Enums\TimeStepEnum;
use Illuminate\Contracts\Validation\Rule;

class TimeStep implements Rule
{
    private int $timeStep;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $timeStep)
    {
        $this->timeStep = $timeStep;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!in_array($this->timeStep, TimeStepEnum::values())) {
            throw new \UnexpectedValueException('TimeStep param must be in array ' .
                implode(', ', TimeStepEnum::values()));
        }

        $minutes = (int) explode(':', $value)[1];

        if ($minutes % $this->timeStep === 0) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a multiple of ' . $this->timeStep . '.';
    }
}
