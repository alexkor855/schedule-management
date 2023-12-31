<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBranchServiceRequest;
use App\Http\Requests\UpdateBranchServiceRequest;
use App\Models\BranchService;

class BranchServiceController extends Controller
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
     * @param  \App\Http\Requests\StoreBranchServiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBranchServiceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BranchService  $branchService
     * @return \Illuminate\Http\Response
     */
    public function show(BranchService $branchService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BranchService  $branchService
     * @return \Illuminate\Http\Response
     */
    public function edit(BranchService $branchService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBranchServiceRequest  $request
     * @param  \App\Models\BranchService  $branchService
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBranchServiceRequest $request, BranchService $branchService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BranchService  $branchService
     * @return \Illuminate\Http\Response
     */
    public function destroy(BranchService $branchService)
    {
        //
    }
}
