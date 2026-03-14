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
        $hmos = \App\Models\HmoGroup::all();
        return view('hmo-plans.create', compact('hmos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hmo_id' => 'required|exists:hmo_groups,id',
            'name' => 'required|string|max:255',
            'enrollment_amount' => 'nullable|numeric|min:0',
            'signup_amount' => 'nullable|numeric|min:0',
            'max_no' => 'nullable|integer|min:1',
            'is_insurance' => 'boolean',
        ]);

        $validated['is_insurance'] = $request->has('is_insurance');

        HmoPlan::create($validated);

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
        $hmos = \App\Models\HmoGroup::all();
        return view('hmo-plans.edit', compact('hmoPlan', 'hmos'));
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
        $validated = $request->validate([
            'hmo_id' => 'required|exists:hmo_groups,id',
            'name' => 'required|string|max:255',
            'enrollment_amount' => 'nullable|numeric|min:0',
            'signup_amount' => 'nullable|numeric|min:0',
            'max_no' => 'nullable|integer|min:1',
            'is_insurance' => 'boolean',
        ]);

        $validated['is_insurance'] = $request->has('is_insurance');

        $hmoPlan->update($validated);

        return redirect()->route('app.settings.index')->with('success', 'HMO Plan Updated');
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

    public function importView()
    {
        return view('hmo-plans.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv' => 'required|mimes:csv,xlsx,xls'
        ]);

        \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\HmoPlanImport, $request->file('csv')->store('files'));
        
        return redirect()->back()->with('success', 'HMO Plans imported successfully!');
    }
}
