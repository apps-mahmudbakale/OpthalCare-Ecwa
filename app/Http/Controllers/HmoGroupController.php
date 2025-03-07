<?php

namespace App\Http\Controllers;

use App\Models\HmoGroup;
use Illuminate\Http\Request;

class HmoGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
        $hmo = HmoGroup::create($request->all());
        return back()->with('success', 'HMO Group Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HmoGroup  $hmoGroup
     * @return \Illuminate\Http\Response
     */
    public function show(HmoGroup $hmoGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HmoGroup  $hmoGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(HmoGroup $hmoGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HmoGroup  $hmoGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HmoGroup $hmoGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HmoGroup  $hmoGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hmoGroup = HmoGroup::find($id);
        
        $hmoGroup->delete();

        return back()->with('success', 'HMO Deleted');
    }
}
