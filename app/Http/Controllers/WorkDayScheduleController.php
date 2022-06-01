<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\JsonResponseTrait;
use App\Http\Requests\CopyWorkDayScheduleRequest;
use App\Http\Requests\DeleteWorkDaySchedulesRequest;
use App\Http\Requests\GetWorkDaySchedulesRequest;
use App\Http\Requests\StoreWorkDayScheduleRequest;
use App\Http\Requests\UpdateWorkDayScheduleRequest;
use App\Http\Resources\WorkDayScheduleResource;
use App\Http\Resources\WorkDayScheduleWithIntervalResource;
use App\Models\WorkDaySchedule;
use App\Services\GettingWorkDaySchedulesService;
use App\Services\WorkDayScheduleService;
use Illuminate\Http\JsonResponse;

class WorkDayScheduleController extends Controller
{
    use JsonResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @param GetWorkDaySchedulesRequest $request
     * @param GettingWorkDaySchedulesService $service
     * @return JsonResponse
     */
    public function index(GetWorkDaySchedulesRequest $request, GettingWorkDaySchedulesService $service): JsonResponse
    {
        $response = $service->search(
            $request->schedule_ids,
            $request->start_date,
            $request->end_date
        );
        return $this->getSuccessfulJsonResponse($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreWorkDayScheduleRequest $request
     * @param WorkDayScheduleService $service
     * @return JsonResponse
     */
    public function store(StoreWorkDayScheduleRequest $request, WorkDayScheduleService $service): JsonResponse
    {
        $workDaySchedule = $service->create($request);
        $response = (new WorkDayScheduleWithIntervalResource($workDaySchedule))->toArray($request);
        return $this->getSuccessfulJsonResponse($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorkDaySchedule  $scheduleWorkDay
     * @return \Illuminate\Http\Response
     */
    public function show(WorkDaySchedule $scheduleWorkDay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkDaySchedule  $scheduleWorkDay
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkDaySchedule $scheduleWorkDay)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateWorkDayScheduleRequest $request
     * @param WorkDayScheduleService $service
     * @return JsonResponse
     */
    public function update(UpdateWorkDayScheduleRequest $request, WorkDayScheduleService $service): JsonResponse
    {
        $workDaySchedule = $service->update($request);
        $response = (new WorkDayScheduleWithIntervalResource($workDaySchedule))->toArray($request);
        return $this->getSuccessfulJsonResponse($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteWorkDaySchedulesRequest $request
     * @param WorkDayScheduleService $service
     * @return JsonResponse
     */
    public function destroy(DeleteWorkDaySchedulesRequest $request, WorkDayScheduleService $service): JsonResponse
    {
        $response = [];
        $response['success'] = $service->delete($request->work_day_schedule_ids) === count($request->work_day_schedule_ids);
        return $this->getSuccessfulJsonResponse($response);
    }

    /**
     * Copy WorkDaySchedules to some days.
     *
     * @param CopyWorkDayScheduleRequest $request
     * @param WorkDayScheduleService $service
     * @return JsonResponse
     */
    public function copy(CopyWorkDayScheduleRequest $request, WorkDayScheduleService $service): JsonResponse
    {
        $workDaySchedules = $service->copy($request);
        $response = WorkDayScheduleResource::collection($workDaySchedules)->toArray($request);
        return $this->getSuccessfulJsonResponse($response);
    }
}
