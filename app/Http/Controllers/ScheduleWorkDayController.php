<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleWorkDayRequest;
use App\Http\Requests\UpdateScheduleWorkDayRequest;
use App\Models\ScheduleWorkDay;

class ScheduleWorkDayController extends Controller
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
     * @param  \App\Http\Requests\StoreScheduleWorkDayRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreScheduleWorkDayRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ScheduleWorkDay  $scheduleWorkDay
     * @return \Illuminate\Http\Response
     */
    public function show(ScheduleWorkDay $scheduleWorkDay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ScheduleWorkDay  $scheduleWorkDay
     * @return \Illuminate\Http\Response
     */
    public function edit(ScheduleWorkDay $scheduleWorkDay)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateScheduleWorkDayRequest  $request
     * @param  \App\Models\ScheduleWorkDay  $scheduleWorkDay
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateScheduleWorkDayRequest $request, ScheduleWorkDay $scheduleWorkDay)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ScheduleWorkDay  $scheduleWorkDay
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScheduleWorkDay $scheduleWorkDay)
    {
        //
    }
}
