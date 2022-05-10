<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceWorkplaceRequest;
use App\Http\Requests\UpdateServiceWorkplaceRequest;
use App\Models\ServiceWorkplace;

class ServiceWorkplaceController extends Controller
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
     * @param  \App\Http\Requests\StoreServiceWorkplaceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceWorkplaceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceWorkplace  $serviceWorkplace
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceWorkplace $serviceWorkplace)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceWorkplace  $serviceWorkplace
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceWorkplace $serviceWorkplace)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceWorkplaceRequest  $request
     * @param  \App\Models\ServiceWorkplace  $serviceWorkplace
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceWorkplaceRequest $request, ServiceWorkplace $serviceWorkplace)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceWorkplace  $serviceWorkplace
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceWorkplace $serviceWorkplace)
    {
        //
    }
}
