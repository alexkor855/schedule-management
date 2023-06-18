<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBranchEmployeeRequest;
use App\Http\Requests\UpdateBranchEmployeeRequest;
use App\Models\BranchEmployee;

class BranchEmployeeController extends Controller
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
     * @param  \App\Http\Requests\StoreBranchEmployeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBranchEmployeeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BranchEmployee  $branchEmployee
     * @return \Illuminate\Http\Response
     */
    public function show(BranchEmployee $branchEmployee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BranchEmployee  $branchEmployee
     * @return \Illuminate\Http\Response
     */
    public function edit(BranchEmployee $branchEmployee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBranchEmployeeRequest  $request
     * @param  \App\Models\BranchEmployee  $branchEmployee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBranchEmployeeRequest $request, BranchEmployee $branchEmployee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BranchEmployee  $branchEmployee
     * @return \Illuminate\Http\Response
     */
    public function destroy(BranchEmployee $branchEmployee)
    {
        //
    }
}
