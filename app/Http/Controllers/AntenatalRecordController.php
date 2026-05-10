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
        // Validation for follow-up visits - ensure there's at least one new visit for this patient
        if ($request->visit_type === 'followup') {
            $hasNewVisit = AntenatalRecord::where('patient_id', $request->patient_id)
                ->where('visit_type', 'new')
                ->exists();
            
            if (!$hasNewVisit) {
                return redirect()->back()->withErrors(['visit_type' => 'A new antenatal visit must be created before follow-up visits.']);
            }
        }

        $request->validate([
            'patient_id'            => 'required|exists:patients,id',
            'visit_type'            => 'required|in:new,followup',
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
            // Follow-up fields
            'height_of_fundus'      => 'nullable|string|max:255',
            'presentation_and_position' => 'nullable|string|max:255',
            'fetal_heart'           => 'nullable|string|max:255',
            'urine'                 => 'nullable|string|max:255',
            'blood_pressure'        => 'nullable|string|max:255',
            'weight'                => 'nullable|numeric|min:0|max:999.99',
            'edema'                 => 'nullable|string|max:255',
            'followup_complaint'    => 'nullable|string',
            'followup_treatment'    => 'nullable|string',
            'followup_notes'        => 'nullable|string',
        ]);

        $record = AntenatalRecord::create([
            'patient_id'            => $request->patient_id,
            'user_id'               => auth()->id(),
            'visit_type'            => $request->visit_type ?? 'new',
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
            // Follow-up fields
            'height_of_fundus'      => $request->height_of_fundus,
            'presentation_and_position' => $request->presentation_and_position,
            'fetal_heart'           => $request->fetal_heart,
            'urine'                 => $request->urine,
            'blood_pressure'        => $request->blood_pressure,
            'weight'                => $request->weight,
            'edema'                 => $request->edema,
            'followup_complaint'    => $request->followup_complaint,
            'followup_treatment'    => $request->followup_treatment,
            'followup_notes'        => $request->followup_notes,
        ]);

        // Bill the patient for the enrolment package if one was selected (only for new visits)
        if ($request->visit_type === 'new' && $request->enrolment_package_id) {
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

        $visitType = $request->visit_type === 'followup' ? 'follow-up' : 'antenatal';
        
        // If enrolling from the antenatal index page, redirect there specifically
        if ($request->visit_type === 'new' && !$request->has('from_patient_profile')) {
            return redirect()->route('app.antenatals.index')->with('success', 'Patient enrolled successfully.');
        }
        
        return redirect()->back()->with('success', ucfirst($visitType) . ' record saved successfully.');
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

    public function update(Request $request, AntenatalRecord $antenatalRecord)
    {
        $request->validate([
            'visit_type'            => 'required|in:new,followup',
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
            // Follow-up fields
            'height_of_fundus'      => 'nullable|string|max:255',
            'presentation_and_position' => 'nullable|string|max:255',
            'fetal_heart'           => 'nullable|string|max:255',
            'urine'                 => 'nullable|string|max:255',
            'blood_pressure'        => 'nullable|string|max:255',
            'weight'                => 'nullable|numeric|min:0|max:999.99',
            'edema'                 => 'nullable|string|max:255',
            'followup_complaint'    => 'nullable|string',
            'followup_treatment'    => 'nullable|string',
            'followup_notes'        => 'nullable|string',
        ]);

        $antenatalRecord->update([
            'visit_type'            => $request->visit_type,
            'complaint'             => $request->complaint,
            'treatment_plan'        => $request->treatment_plan,
            'note'                  => $request->note,
            'visit_date'            => $request->visit_date,
            'gravida'               => $request->gravida,
            'parity'                => $request->parity,
            'last_menstrual_period' => $request->last_menstrual_period,
            'current_pregnancy'     => $request->current_pregnancy,
            'alive'                 => $request->alive,
            'miscarriage'           => $request->miscarriage,
            'enrolment_package_id'  => $request->enrolment_package_id,
            // Follow-up fields
            'height_of_fundus'      => $request->height_of_fundus,
            'presentation_and_position' => $request->presentation_and_position,
            'fetal_heart'           => $request->fetal_heart,
            'urine'                 => $request->urine,
            'blood_pressure'        => $request->blood_pressure,
            'weight'                => $request->weight,
            'edema'                 => $request->edema,
            'followup_complaint'    => $request->followup_complaint,
            'followup_treatment'    => $request->followup_treatment,
            'followup_notes'        => $request->followup_notes,
        ]);

        $visitType = $request->visit_type === 'followup' ? 'follow-up' : 'antenatal';
        return redirect()->back()->with('success', ucfirst($visitType) . ' record updated successfully.');
    }

    public function conclude(Request $request, AntenatalRecord $antenatalRecord)
    {
        $request->validate([
            'conclusion_notes' => 'nullable|string|max:1000',
        ]);

        // Only allow concluding active enrollments
        if ($antenatalRecord->isConcluded()) {
            return redirect()->back()->withErrors(['error' => 'This enrollment is already concluded.']);
        }

        // Only allow concluding new visits (enrollment records)
        if ($antenatalRecord->visit_type !== 'new') {
            return redirect()->back()->withErrors(['error' => 'Only enrollment records can be concluded.']);
        }

        $antenatalRecord->conclude($request->conclusion_notes, auth()->id());

        return redirect()->back()->with('success', 'Antenatal enrollment concluded successfully.');
    }
}
