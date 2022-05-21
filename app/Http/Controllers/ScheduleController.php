<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\JsonResponseTrait;
use App\Http\Requests\GetSchedulesRequest;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\Schedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ScheduleController extends Controller
{
    use JsonResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @param  GetSchedulesRequest  $request
     * @return JsonResponse
     */
    public function index(GetSchedulesRequest $request): JsonResponse
    {
        try {
            $response = [];
        } catch (ValidationException $exception) {
            $response['message'] = $exception->getMessage();
            $response['errors'] = $responseHelper->matchErrorFieldsToRequestFields($exception->errors(), []);
            return $this->getInvalidJsonResponse($response);
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());
            $response['message'] = 'Непредвиденная ошибка';
            return $this->getErrorJsonResponse($response);
        }
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
     * @param  \App\Http\Requests\StoreScheduleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreScheduleRequest $request)
    {
        //
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
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        //
    }
}
