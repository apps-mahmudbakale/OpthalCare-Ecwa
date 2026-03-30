<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\NursingNote;
use App\Models\NursingTask;
use App\Models\ProgressNote;
use App\Models\ProcedureRequest;
use Illuminate\Http\Request;

class AdmissionNotesController extends Controller
{
    // ── Progress Notes ────────────────────────────────────────────────

    public function storeProgressNote(Request $request)
    {
        $request->validate(['note' => 'required|string']);

        $patientId = $this->resolvePatientId($request);

        ProgressNote::create([
            'admission_id'         => $request->admission_id ?: null,
            'procedure_request_id' => $request->procedure_request_id ?: null,
            'patient_id'           => $patientId,
            'user_id'              => auth()->id(),
            'note'                 => $request->note,
        ]);

        return back()->with('success', 'Progress note saved.');
    }

    public function destroyProgressNote(ProgressNote $progressNote)
    {
        $progressNote->delete();
        return back()->with('success', 'Progress note deleted.');
    }

    // ── Nursing Notes ─────────────────────────────────────────────────

    public function storeNursingNote(Request $request)
    {
        $request->validate(['note' => 'required|string']);

        $patientId = $this->resolvePatientId($request);

        NursingNote::create([
            'admission_id'         => $request->admission_id ?: null,
            'procedure_request_id' => $request->procedure_request_id ?: null,
            'patient_id'           => $patientId,
            'user_id'              => auth()->id(),
            'note'                 => $request->note,
        ]);

        return back()->with('success', 'Nursing note saved.');
    }

    public function destroyNursingNote(NursingNote $nursingNote)
    {
        $nursingNote->delete();
        return back()->with('success', 'Nursing note deleted.');
    }

    // ── Nursing Tasks ─────────────────────────────────────────────────

    public function storeNursingTask(Request $request)
    {
        $request->validate(['task' => 'required|string']);

        $patientId = $this->resolvePatientId($request);

        NursingTask::create([
            'admission_id'         => $request->admission_id ?: null,
            'procedure_request_id' => $request->procedure_request_id ?: null,
            'patient_id'           => $patientId,
            'user_id'              => auth()->id(),
            'task'                 => $request->task,
            'status'               => 'Pending',
        ]);

        return back()->with('success', 'Nursing task added.');
    }

    public function toggleNursingTask(NursingTask $nursingTask)
    {
        $nursingTask->status = $nursingTask->status === 'Completed' ? 'Pending' : 'Completed';
        $nursingTask->save();
        return back();
    }

    public function destroyNursingTask(NursingTask $nursingTask)
    {
        $nursingTask->delete();
        return back()->with('success', 'Nursing task deleted.');
    }

    // ── Helper ────────────────────────────────────────────────────────

    private function resolvePatientId(Request $request): ?int
    {
        if ($request->admission_id) {
            return Admission::find($request->admission_id)?->patient_id;
        }
        if ($request->procedure_request_id) {
            return ProcedureRequest::find($request->procedure_request_id)?->patient_id;
        }
        return null;
    }
}
