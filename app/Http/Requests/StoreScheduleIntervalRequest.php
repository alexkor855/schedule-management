<?php

namespace App\Http\Requests;

use App\Models\Branch;
use App\Models\Schedule;
use App\Rules\TimeStep;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreScheduleIntervalRequest extends FormRequest
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
        $schedule = Schedule::query()
            ->select(['id', 'time_step'])
            ->find($this->input('schedule_id'))
            ->first();

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
                Rule::exists('intervals', 'id')->where(function (Builder $query) {
                    $query->where('start_time', $this->input('interval.start_time'));
                    $query->where('end_time', $this->input('interval.end_time'));
                })
            ],
            'interval.start_time' => ['required', 'date_format:H:i', new TimeStep($schedule->time_step)],
            'interval.end_time' => ['required', 'date_format:H:i', 'after:interval.start_time', new TimeStep($schedule->time_step)],
        ];
    }
}
