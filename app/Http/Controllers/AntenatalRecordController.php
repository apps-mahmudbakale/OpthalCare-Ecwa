<?php

namespace App\Http\Controllers;

use App\Charts\BloodPressureChart;
use App\Charts\PulseChart;
use App\Charts\TemperatureChart;
use App\Charts\WeightChart;
use App\Models\AntenatalPackage;
use App\Models\AntenatalRecord;
use App\Models\Billing;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AntenatalRecordController extends Controller
{
    public function index()
    {
        return view('antenatal.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id'            => 'required|exists:patients,id',
            'complaint'             => 'nullable|string',
            'treatment_plan'        => 'nullable|string',
            'note'                  => 'nullable|string',
            'visit_date'            => 'nullable|date',
            'gravida'               => 'nullable|integer|min:0',
            'parity'                => 'nullable|integer|min:0',
            'last_menstrual_period' => 'nullable|date',
            'current_pregnancy'     => 'nullable|string|max:255',
            'alive'                 => 'nullable|integer|min:0',
            'miscarriage'           => 'nullable|integer|min:0',
            'enrolment_package_id'  => 'nullable|exists:antenatal_packages,id',
        ]);

        $record = AntenatalRecord::create([
            'patient_id'            => $request->patient_id,
            'user_id'               => auth()->id(),
            'complaint'             => $request->complaint,
            'treatment_plan'        => $request->treatment_plan,
            'note'                  => $request->note,
            'visit_date'            => $request->visit_date ?? now()->toDateString(),
            'gravida'               => $request->gravida,
            'parity'                => $request->parity,
            'last_menstrual_period' => $request->last_menstrual_period,
            'current_pregnancy'     => $request->current_pregnancy,
            'alive'                 => $request->alive,
            'miscarriage'           => $request->miscarriage,
            'enrolment_package_id'  => $request->enrolment_package_id,
        ]);

        // Bill the patient for the enrolment package if one was selected
        if ($request->enrolment_package_id) {
            $package = AntenatalPackage::find($request->enrolment_package_id);

            if ($package && $package->price > 0) {
                Billing::create([
                    'service'    => 'antenatal:' . $package->name,
                    'service_id' => $package->id,
                    'user_id'    => $request->patient_id,
                    'quantity'   => 1,
                    'amount'     => $package->price,
                    'bill_ref'   => strtoupper(Str::random(6)),
                    'payer_id'   => auth()->id(),
                    'plan_id'    => null,
                    'status'     => 0, // unpaid — cashier will collect
                ]);
            }
        }

        return redirect()->back()->with('success', 'Antenatal record saved successfully.');
    }

    public function show(BloodPressureChart $chart, PulseChart $pulse, TemperatureChart $temperature, WeightChart $weight, AntenatalRecord $antenatalRecord)
    {
        $patient = Patient::findOrFail($antenatalRecord->patient_id);
        $wallet_balance = $patient->wallet ? $patient->wallet->balance : 0;
        $outstanding_balance = Billing::where('user_id', $patient->id)
                                      ->where('status', 0)
                                      ->whereNull('plan_id') // Exclude HMO bills
                                      ->sum('amount');

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
