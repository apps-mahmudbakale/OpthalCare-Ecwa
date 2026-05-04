<?php

namespace App\Http\Controllers;

use App\Charts\BloodPressureChart;
use App\Charts\PulseChart;
use App\Charts\TemperatureChart;
use App\Charts\WeightChart;
use App\Models\Admission;
use App\Models\Billing;
use App\Models\Patient;
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
                1,
                null,
                'procedure_request',
                'Procedure requested via procedure interface by ' . auth()->user()->firstname . ' ' . auth()->user()->lastname,
                $procedure->id
            );
        }

        return redirect()->back()->with('success', 'Procedure request created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BloodPressureChart $chart, PulseChart $pulse, TemperatureChart $temperature, WeightChart $weight, $id)
    {
        $procedureRequest = ProcedureRequest::with(['patient.user', 'procedure.category', 'user'])
            ->findOrFail($id);

        $patient = Patient::where('id', $procedureRequest->patient_id)->first();
        $wallet_balance = $patient->wallet ? $patient->wallet->balance : 0;
        $outstanding_balance = Billing::where('user_id', $procedureRequest->patient_id)->where('status', 0)->sum('amount');
        
        return view('procedure.show', [
            'procedureRequest' => $procedureRequest,
            'patient'          => $patient,
            'blood_pressure'   => $chart->build($patient->id),
            'pulse'            => $pulse->build($patient->id),
            'temperature'      => $temperature->build($patient->id),
            'weight'           => $weight->build($patient->id),
            'outstanding_balance' => $outstanding_balance,
            'wallet_balance'   => $wallet_balance,
            'progressNotes'    => \App\Models\ProgressNote::with('user')->where('procedure_request_id', $procedureRequest->id)->latest()->paginate(10, ['*'], 'progress_page'),
            'nursingNotes'     => \App\Models\NursingNote::with('user')->where('procedure_request_id', $procedureRequest->id)->latest()->paginate(10, ['*'], 'nursing_page'),
            'nursingTasks'     => \App\Models\NursingTask::with('user')->where('procedure_request_id', $procedureRequest->id)->latest()->paginate(10, ['*'], 'task_page'),
            'labRequests'      => \App\Models\LabRequest::with('test')->where('patient_id', $patient->id)->latest()->paginate(10, ['*'], 'lab_page'),
            'imagingRequests'  => \App\Models\RadiologyRequest::with('test')->where('patient_id', $patient->id)->latest()->paginate(10, ['*'], 'imaging_page'),
            'drugRequests'     => \App\Models\DrugRequest::with('drug')->where('patient_id', $patient->id)->latest()->paginate(10, ['*'], 'drug_page'),
        ]);
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

    public function conclude(Request $request, ProcedureRequest $procedureRequest)
    {
        $request->validate([
            'conclusion_note' => 'nullable|string',
        ]);

        $procedureRequest->update([
            'status' => 'Concluded',
        ]);

        // Save conclusion as a progress note if provided
        if ($request->filled('conclusion_note')) {
            \App\Models\ProgressNote::create([
                'procedure_request_id' => $procedureRequest->id,
                'patient_id'           => $procedureRequest->patient_id,
                'user_id'              => auth()->id(),
                'note'                 => $request->conclusion_note,
            ]);
        }

        return back()->with('success', 'Procedure concluded successfully.');
    }
}
