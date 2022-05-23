<?php

namespace App\Http\Requests;

use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWorkDayScheduleRequest extends FormRequest
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
        // $branchesIds = $user->company->branches->modelKeys(); // change after authentication implementation
        $branchesIds = Branch::query()->select('id')->get()->modelKeys();

        return [
            'schedule_id' => [
                'required',
                'uuid',
                Rule::exists('schedules', 'id')->where(function ($query) use ($branchesIds) {
                    return $query->whereIn('branch_id', $branchesIds);
                })
            ],
            'date' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:'.Carbon::today()->format('Y-m-d')],
            'intervals.*.interval_id' => ['nullable', 'exists:schedule_intervals,id'],
            'intervals.*.start_time' => ['required', 'date_format:H:i'],
            'intervals.*.end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ];
    }
}
