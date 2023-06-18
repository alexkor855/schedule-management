<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceEmployeeRequest;
use App\Http\Requests\UpdateServiceEmployeeRequest;
use App\Models\ServiceEmployee;

class ServiceEmployeeController extends Controller
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
     * @param  \App\Http\Requests\StoreServiceEmployeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceEmployeeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceEmployee  $serviceEmployee
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceEmployee $serviceEmployee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceEmployee  $serviceEmployee
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceEmployee $serviceEmployee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceEmployeeRequest  $request
     * @param  \App\Models\ServiceEmployee  $serviceEmployee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceEmployeeRequest $request, ServiceEmployee $serviceEmployee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceEmployee  $serviceEmployee
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceEmployee $serviceEmployee)
    {
        //
    }
}
