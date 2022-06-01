<?php

namespace App\Http\Requests;

use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleteWorkDaySchedulesRequest extends FormRequest
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
            'work_day_schedule_ids.*' => [
                'required',
                'uuid',
                Rule::exists('work_day_schedules', 'id')->where(function (Builder $query) use ($branchesIds) {
                    $query->where('date', '>=', Carbon::today()->format('Y-m-d'));
                    $query->whereHas('schedule', function ($query) use ($branchesIds) {
                        $query->whereIn('branch_id', $branchesIds);
                    });
                })
            ],
        ];
    }
}
