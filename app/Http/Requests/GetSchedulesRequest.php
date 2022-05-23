<?php

namespace App\Http\Requests;

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
        return [
            //'schedule_type' => ['required', Rule::in(ScheduleTypeEnum::values())],
            'branch_id' => ['required', 'uuid'],
            'employee_id ' => ['uuid'],
            'workplace_id' => ['uuid'],
        ];
    }
}
