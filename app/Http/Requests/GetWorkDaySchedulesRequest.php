<?php

namespace App\Http\Requests;

use App\Models\Branch;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetWorkDaySchedulesRequest extends FormRequest
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
            'schedule_ids.*' => [
                'required',
                'uuid',
                Rule::exists('schedules', 'id')->where(function ($query) use ($branchesIds) {
                    return $query->whereIn('branch_id', $branchesIds);
                })
            ],
            'start_date' => ['required', 'date', 'date_format:Y-m-d'],
            'end_date' => ['required', 'date', 'date_format:Y-m-d', 'after:start_date'],
        ];
    }
}
