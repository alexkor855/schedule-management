<?php

namespace App\Http\Requests;

use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWorkDayScheduleRequest extends FormRequest
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
            'schedule_id' => [
                'required',
                'uuid',
                Rule::exists('schedules', 'id')->where(function ($query) use ($branchesIds) {
                    return $query->whereIn('branch_id', $branchesIds);
                })
            ],
            'date' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:'.Carbon::today()->format('Y-m-d')],
            'interval_id' => ['same:interval.id'],
            'interval.id' => [
                'nullable',
                'uuid',
                Rule::exists('schedule_intervals', 'id')->where(function (Builder $query) {
                    $query->where('start_time', $this->input('start_time'));
                    $query->where('end_time', $this->input('end_time'));
                })
            ],
            'interval.start_time' => ['required', 'date_format:H:i'],
            'interval.end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ];
    }
}
