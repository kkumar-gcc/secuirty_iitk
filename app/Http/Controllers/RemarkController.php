<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRemarkRequest;
use App\Http\Requests\UpdateRemarkRequest;
use App\Models\Remark;

class RemarkController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Remark::class, 'remark');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRemarkRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Remark $remark)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Remark $remark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRemarkRequest $request, Remark $remark)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Remark $remark)
    {
        //
    }
}
