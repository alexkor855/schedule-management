<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\JsonResponseTrait;
use App\Http\Requests\CopyScheduleIntervalsRequest;
use App\Http\Requests\DeleteScheduleIntervalsRequest;
use App\Http\Requests\GetScheduleIntervalsRequest;
use App\Http\Requests\StoreScheduleIntervalRequest;
use App\Http\Requests\UpdateScheduleIntervalRequest;
use App\Http\Resources\ScheduleIntervalResource;
use App\Http\Resources\ScheduleIntervalWithIntervalResource;
use App\Models\ScheduleInterval;
use App\Services\GettingScheduleIntervalsService;
use App\Services\ScheduleIntervalService;
use Illuminate\Http\JsonResponse;

class ScheduleIntervalController extends Controller
{
    use JsonResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @param GetScheduleIntervalsRequest $request
     * @param GettingScheduleIntervalsService $service
     * @return JsonResponse
     */
    public function index(GetScheduleIntervalsRequest $request, GettingScheduleIntervalsService $service): JsonResponse
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
     * @param StoreScheduleIntervalRequest $request
     * @param ScheduleIntervalService $service
     * @return JsonResponse
     */
    public function store(StoreScheduleIntervalRequest $request, ScheduleIntervalService $service): JsonResponse
    {
        $scheduleInterval = $service->create($request);
        $response = (new ScheduleIntervalWithIntervalResource($scheduleInterval))->toArray($request);
        return $this->getSuccessfulJsonResponse($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ScheduleInterval  $scheduleInterval
     * @return \Illuminate\Http\Response
     */
    public function show(ScheduleInterval $scheduleInterval)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ScheduleInterval  $scheduleInterval
     * @return \Illuminate\Http\Response
     */
    public function edit(ScheduleInterval $scheduleInterval)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateScheduleIntervalRequest $request
     * @param ScheduleIntervalService $service
     * @return JsonResponse
     */
    public function update(UpdateScheduleIntervalRequest $request, ScheduleIntervalService $service): JsonResponse
    {
        $scheduleInterval = $service->update($request);
        $response = (new ScheduleIntervalWithIntervalResource($scheduleInterval))->toArray($request);
        return $this->getSuccessfulJsonResponse($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteScheduleIntervalsRequest $request
     * @param ScheduleIntervalService $service
     * @return JsonResponse
     */
    public function destroy(DeleteScheduleIntervalsRequest $request, ScheduleIntervalService $service): JsonResponse
    {
        $response = [];
        $response['success'] = $service->delete($request->schedule_interval_ids) === count($request->schedule_interval_ids);
        return $this->getSuccessfulJsonResponse($response);
    }

    /**
     * Copy ScheduleIntervals to some days.
     *
     * @param CopyScheduleIntervalsRequest $request
     * @param ScheduleIntervalService $service
     * @return JsonResponse
     */
    public function copy(CopyScheduleIntervalsRequest $request, ScheduleIntervalService $service): JsonResponse
    {
        $scheduleIntervals = $service->copy($request);
        $response = ScheduleIntervalResource::collection($scheduleIntervals)->toArray($request);
        return $this->getSuccessfulJsonResponse($response);
    }
}
