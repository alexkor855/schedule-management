<?php

namespace App\Http\Requests;

use App\Models\Enums\ScheduleTypeEnum;
use App\Models\Enums\TimeStepEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'schedule_type' => ['required', Rule::in(ScheduleTypeEnum::values())],
            'branch_id' => ['required', 'uuid'],
            'employee_id ' => ['uuid',
                Rule::requiredIf(in_array($this->schedule_type,
                    [ScheduleTypeEnum::ForEmployee, ScheduleTypeEnum::ForEmployeeAndWorkplace])
                )
            ],
            'workplace_id' => ['uuid',
                Rule::requiredIf(in_array($this->schedule_type,
                        [ScheduleTypeEnum::ForWorkplace, ScheduleTypeEnum::ForEmployeeAndWorkplace])
                )
            ],
            'time_step' => ['required', Rule::in(TimeStepEnum::values())],
            'number_available_days' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
