<?php

namespace App\Http\Requests;

use App\Models\Branch;
use App\Models\ScheduleInterval;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateScheduleIntervalRequest extends FormRequest
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
     * @throws ValidationException
     * @return array
     */
    public function rules()
    {
        $branchesIds = Branch::query()->select('id')->get()->modelKeys();

        $modelBeforeChange = ScheduleInterval::query()->whereKey($this->input('id'))->first();
        if (is_null($modelBeforeChange)) {
            throw ValidationException::withMessages([
                'id' => 'Model not found',
            ]);
        }

        return [
            'id' => [
                'required',
                'uuid',
                Rule::exists('schedule_intervals', 'id')->where(function (Builder $query) {
                    return $query->where('date', $this->input('date'));
                })
            ],
            'schedule_id' => [
                'required',
                'uuid',
                Rule::exists('schedules', 'id')->where(function (Builder $query) use ($branchesIds) {
                    return $query->whereIn('branch_id', $branchesIds);
                }),
                Rule::in([$modelBeforeChange->schedule_id]),
            ],
            'date' => [
                'required',
                'date',
                'date_format:Y-m-d',
                'after_or_equal:'.Carbon::today()->format('Y-m-d'),
                Rule::in([$modelBeforeChange->date]),
            ],
            'interval_id' => ['same:interval.id'],
            'interval.id' => [
                'nullable',
                'uuid',
                Rule::exists('intervals', 'id')->where(function (Builder $query) {
                    $query->where('start_time', $this->input('start_time'));
                    $query->where('end_time', $this->input('end_time'));
                })
            ],
            'interval.start_time' => ['required', 'date_format:H:i'],
            'interval.end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ];
    }
}
