<?php

namespace App\Http\Requests;

use App\Models\Branch;
use App\Models\ScheduleInterval;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CopyWorkDayScheduleRequest extends FormRequest
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
            'from_date' => ['required', 'date', 'date_format:Y-m-d'],
            'to_dates.*' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:'.Carbon::today()->format('Y-m-d')],
            'workDaySchedules.*.schedule_id' => [
                'required',
                'uuid',
                Rule::exists('schedules', 'id')->where(function ($query) use ($branchesIds) {
                    return $query->whereIn('branch_id', $branchesIds);
                })
            ],
            'workDaySchedules.*.interval_id' => ['required', 'exists:schedule_intervals,id'],
        ];
    }
}
