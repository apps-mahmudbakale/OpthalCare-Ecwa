<?php

namespace App\Http\Controllers;

use App\Charts\BloodPressureChart;
use App\Charts\PulseChart;
use App\Charts\TemperatureChart;
use App\Charts\WeightChart;
use App\Models\AntenatalRecord;
use App\Models\Billing;
use App\Models\Patient;
use Illuminate\Http\Request;

class AntenatalRecordController extends Controller
{
    public function index()
    {
        return view('antenatal.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'complaint'  => 'nullable|string',
            'treatment_plan' => 'nullable|string',
            'note'       => 'nullable|string',
            'visit_date' => 'nullable|date',
        ]);

        AntenatalRecord::create([
            'patient_id'     => $request->patient_id,
            'user_id'        => auth()->id(),
            'complaint'      => $request->complaint,
            'treatment_plan' => $request->treatment_plan,
            'note'           => $request->note,
            'visit_date'     => $request->visit_date ?? now()->toDateString(),
        ]);

        return redirect()->back()->with('success', 'Antenatal record saved successfully.');
    }

    public function show(BloodPressureChart $chart, PulseChart $pulse, TemperatureChart $temperature, WeightChart $weight, AntenatalRecord $antenatalRecord)
    {
        $patient = Patient::findOrFail($antenatalRecord->patient_id);
        $wallet_balance = $patient->wallet ? $patient->wallet->balance : 0;
        $outstanding_balance = Billing::where('user_id', $patient->id)->where('status', 0)->sum('amount');

        return view('antenatal.show', [
            'record'              => $antenatalRecord,
            'patient'             => $patient,
            'blood_pressure'      => $chart->build($patient->id),
            'pulse'               => $pulse->build($patient->id),
            'temperature'         => $temperature->build($patient->id),
            'weight'              => $weight->build($patient->id),
            'outstanding_balance' => $outstanding_balance,
            'wallet_balance'      => $wallet_balance,
        ]);
    }

    public function destroy(AntenatalRecord $antenatalRecord)
    {
        $antenatalRecord->delete();
        return redirect()->back()->with('success', 'Record deleted.');
    }
}
