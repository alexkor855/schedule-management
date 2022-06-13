<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\JsonResponseTrait;
use App\Http\Requests\DeleteScheduleRequest;
use App\Http\Requests\GetSchedulesRequest;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Http\Resources\ScheduleResource;
use App\Http\Resources\ScheduleResourceWithRelations;
use App\Models\Schedule;
use App\Services\GettingSchedulesService;
use App\Services\ScheduleService;
use Illuminate\Http\JsonResponse;

class ScheduleController extends Controller
{
    use JsonResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @param GetSchedulesRequest $request
     * @param GettingSchedulesService $schedulesService
     * @return JsonResponse
     */
    public function index(GetSchedulesRequest $request, GettingSchedulesService $schedulesService): JsonResponse
    {
        $schedules = $schedulesService->search(
            $request->schedule_type,
            $request->branch_id,
            $request->employee_id,
            $request->workplace_id
        );
        $response = ScheduleResourceWithRelations::collection($schedules)->toArray($request);
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
     * @param  StoreScheduleRequest  $request
     * @param  ScheduleService  $service
     * @return JsonResponse
     */
    public function store(StoreScheduleRequest $request, ScheduleService $service): JsonResponse
    {
        $schedule = $service->create($request);
        $response = (new ScheduleResource($schedule))->toArray($request);
        return $this->getCreatedJsonResponse($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateScheduleRequest  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteScheduleRequest  $request
     * @param  ScheduleService  $service
     * @return JsonResponse
     */
    public function destroy(DeleteScheduleRequest $request, ScheduleService $service): JsonResponse
    {
        $response = ['success' => $service->delete($request->schedule_id)];
        return $this->getSuccessfulJsonResponse($response);
    }
}
