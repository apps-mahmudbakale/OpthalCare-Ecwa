<?php

namespace App\Http\Controllers;

use App\Models\HmoPlan;
use Illuminate\Http\Request;

class HmoPlanController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $plan = HmoPlan::create($request->all());

        return redirect()->route('app.settings.index')->with('success', 'HMO Plan Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HmoPlan  $hmoPlan
     * @return \Illuminate\Http\Response
     */
    public function show(HmoPlan $hmoPlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HmoPlan  $hmoPlan
     * @return \Illuminate\Http\Response
     */
    public function edit(HmoPlan $hmoPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HmoPlan  $hmoPlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HmoPlan $hmoPlan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HmoPlan  $hmoPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(HmoPlan $hmoPlan)
    {
        //
    }
}
