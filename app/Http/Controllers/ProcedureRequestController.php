<?php

namespace App\Http\Controllers;

use App\Models\Procedure;
use App\Models\ProcedureRequest;
use Illuminate\Http\Request;

class ProcedureRequestController extends Controller
{
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

    public function prepare($ref){
      $procedure = ProcedureRequest::where('request_ref', $ref)->first();

      return view('procedure.prepare', compact('procedure'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request_ref = str()->random(6);
        $request = ProcedureRequest::create(array_merge($request->all(), ['user_id' => auth()->user()->id, 'request_ref' => $request_ref, 'status' => 'Pending']));

        return back()->with('success', 'Procedure request created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProcedureRequest $procedureRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProcedureRequest $procedureRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProcedureRequest $procedureRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProcedureRequest $procedureRequest)
    {
        //
    }
}
