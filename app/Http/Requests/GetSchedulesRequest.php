<?php

namespace App\Http\Requests;

use App\Models\Branch;
use App\Models\Enums\ScheduleTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetSchedulesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
            'employee_id ' => [
                'nullable',
                'uuid',
                Rule::requiredIf(($this->schedule_type === ScheduleTypeEnum::ForEmployeeAndWorkplace->value
                    && empty($this->workplace_id))
                ),
            ],
            'workplace_id' => [
                'nullable',
                'uuid',
                Rule::requiredIf(($this->schedule_type === ScheduleTypeEnum::ForEmployeeAndWorkplace->value
                    && empty($this->employee_id))
                ),
            ],
        ];
    }
}
