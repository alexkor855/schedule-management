<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResourceWithRelations extends JsonResource
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
        $result = [
            'id' => $this->id,
            'schedule_type' => $this->schedule_type,
            'branch_id' => $this->branch_id,
            'employee_id' => $this->employee_id,
            'workplace_id' => $this->workplace_id,
            'time_step' => $this->time_step,
            'number_available_days' => $this->number_available_days,
            'branch' => [],
            'employee' => [],
            'workplace' => [],
        ];

        if (!is_null($this->branch)) {
            $result['branch']['id'] = $this->branch->id;
            $result['branch']['name'] = $this->branch->name;
        }

        if (!is_null($this->employee)) {
            $result['employee']['id'] = $this->employee->id;
            $result['employee']['first_name'] = $this->employee->first_name;
            $result['employee']['last_name'] = $this->employee->last_name;
            $result['employee']['middle_name'] = $this->employee->middle_name;
            $result['employee']['gender'] = $this->employee->gender;
        }

        if (!is_null($this->workplace)) {
            $result['workplace']['id'] = $this->workplace->id;
            $result['workplace']['name'] = $this->workplace->name;
        }

        return $result;
    }
}
