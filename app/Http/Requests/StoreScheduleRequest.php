<?php

namespace App\Http\Requests;

use App\Models\Branch;
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
        $branchesIds = Branch::query()->select('id')->get()->modelKeys();

        return [
            'schedule_type' => ['required', Rule::in(ScheduleTypeEnum::values())],
            'branch_id' => ['required', 'uuid', Rule::in($branchesIds)],
            'employee_id ' => ['uuid',
                Rule::requiredIf(in_array($this->schedule_type,
                    [ScheduleTypeEnum::ForEmployee->value, ScheduleTypeEnum::ForEmployeeAndWorkplace->value])
                ),
                'exists:employees,id',
                Rule::exists('branch_employees', 'employee_id')->where(function ($query) {
                    return $query->where('branch_id', $this->input('branch_id'));
                }),
            ],
            'workplace_id' => ['uuid',
                Rule::requiredIf(in_array($this->schedule_type,
                        [ScheduleTypeEnum::ForWorkplace->value, ScheduleTypeEnum::ForEmployeeAndWorkplace->value])
                ),
                Rule::exists('workplaces', 'id')->where(function ($query) {
                    return $query->where('branch_id', $this->input('branch_id'));
                }),
            ],
            'time_step' => ['required', Rule::in(TimeStepEnum::values())],
            'number_available_days' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
