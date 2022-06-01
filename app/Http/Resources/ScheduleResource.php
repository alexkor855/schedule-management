<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * Indicates if the resource's collection keys should be preserved.
     *
     * @var bool
     */
    public bool $preserveKeys = true;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'schedule_type' => $this->schedule_type,
            'branch_id' => $this->branch_id,
            'employee_id' => $this->employee_id,
            'workplace_id' => $this->workplace_id,
            'time_step' => $this->time_step,
            'number_available_days' => $this->number_available_days,
        ];
    }
}
