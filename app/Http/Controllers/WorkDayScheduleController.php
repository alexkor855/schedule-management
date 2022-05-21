<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkDayScheduleRequest;
use App\Http\Requests\UpdateWorkDayScheduleRequest;
use App\Models\WorkDaySchedule;

class WorkDayScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreWorkDayScheduleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWorkDayScheduleRequest $request)
    {
        //
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
     * @param  \App\Http\Requests\UpdateWorkDayScheduleRequest  $request
     * @param  \App\Models\WorkDaySchedule  $scheduleWorkDay
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWorkDayScheduleRequest $request, WorkDaySchedule $scheduleWorkDay)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkDaySchedule  $scheduleWorkDay
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkDaySchedule $scheduleWorkDay)
    {
        //
    }
}
