<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Procedure;
use App\Models\ProcedureRequest;
use Illuminate\Http\Request;

use App\Services\ServiceRequestHandler;

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
      $procedure = Admission::where('ref', $ref)->first();

      return view('procedure.prepare', compact('procedure'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'user_id' => 'required|exists:users,id',
            'procedure_id' => 'required|array',
        ]);

        $request_ref = str()->upper(str()->random(6));
        $serviceHandler = new ServiceRequestHandler();

        foreach ($request->procedure_id as $index => $procedureId) {
            $procedure = Procedure::find($procedureId);

            if (!$procedure) {
                continue; // Skip invalid entries
            }

            ProcedureRequest::create([
                'patient_id'   => $request->patient_id,
                'user_id'      => $request->user_id,
                'procedure_id' => $procedure->id,
                'status'       => 'Pending',
                'request_ref'  => $request_ref,
            ]);

            $serviceHandler->handleServiceRequest(
                $procedure->name,
                $request->patient_id,
                'Procedure',
                'fresh',
                $request_ref,
                1
            );
        }

        return redirect()->back()->with('success', 'Procedure request created successfully.');
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
