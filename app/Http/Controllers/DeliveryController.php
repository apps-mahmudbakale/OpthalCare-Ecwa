<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Patient;
use App\Models\AntenatalRecord;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'antenatal_record_id' => 'nullable|exists:antenatal_records,id',
            'delivery_date' => 'required|date',
            'delivery_type' => 'required|in:normal,cesarean,assisted,vacuum,forceps',
            'presentation' => 'nullable|in:vertex,breech,transverse,compound',
            'gestation_weeks' => 'nullable|integer|min:0|max:50',
            'gestation_days' => 'nullable|integer|min:0|max:6',
            'labor_onset' => 'nullable|date',
            'labor_duration_hours' => 'nullable|integer|min:0',
            'labor_duration_minutes' => 'nullable|integer|min:0|max:59',
            'labor_complications' => 'nullable|string',
            'baby_gender' => 'nullable|in:male,female',
            'birth_weight' => 'nullable|numeric|min:0|max:10',
            'birth_length' => 'nullable|integer|min:0|max:100',
            'head_circumference' => 'nullable|integer|min:0|max:100',
            'apgar_1_min' => 'nullable|integer|min:0|max:10',
            'apgar_5_min' => 'nullable|integer|min:0|max:10',
            'baby_condition' => 'nullable|string',
            'baby_complications' => 'nullable|string',
            'placenta_delivery' => 'nullable|in:complete,incomplete,retained',
            'placenta_weight' => 'nullable|numeric|min:0',
            'placenta_condition' => 'nullable|string',
            'maternal_condition' => 'nullable|string',
            'blood_loss' => 'nullable|numeric|min:0',
            'perineal_condition' => 'nullable|string',
            'complications' => 'nullable|string',
            'immediate_care' => 'nullable|string',
            'medications_given' => 'nullable|string',
            'feeding_plan' => 'nullable|string',
            'delivery_notes' => 'nullable|string',
            'recommendations' => 'nullable|string',
        ]);

        $delivery = Delivery::create([
            'patient_id' => $request->patient_id,
            'antenatal_record_id' => $request->antenatal_record_id,
            'user_id' => auth()->id(),
            'delivery_date' => $request->delivery_date,
            'delivery_type' => $request->delivery_type,
            'presentation' => $request->presentation,
            'gestation_weeks' => $request->gestation_weeks,
            'gestation_days' => $request->gestation_days,
            'labor_onset' => $request->labor_onset,
            'labor_duration_hours' => $request->labor_duration_hours,
            'labor_duration_minutes' => $request->labor_duration_minutes,
            'labor_complications' => $request->labor_complications,
            'baby_gender' => $request->baby_gender,
            'birth_weight' => $request->birth_weight,
            'birth_length' => $request->birth_length,
            'head_circumference' => $request->head_circumference,
            'apgar_1_min' => $request->apgar_1_min,
            'apgar_5_min' => $request->apgar_5_min,
            'baby_condition' => $request->baby_condition,
            'baby_complications' => $request->baby_complications,
            'placenta_delivery' => $request->placenta_delivery,
            'placenta_weight' => $request->placenta_weight,
            'placenta_condition' => $request->placenta_condition,
            'maternal_condition' => $request->maternal_condition,
            'blood_loss' => $request->blood_loss,
            'perineal_condition' => $request->perineal_condition,
            'complications' => $request->complications,
            'immediate_care' => $request->immediate_care,
            'medications_given' => $request->medications_given,
            'feeding_plan' => $request->feeding_plan,
            'delivery_notes' => $request->delivery_notes,
            'recommendations' => $request->recommendations,
        ]);

        return redirect()->back()->with('success', 'Delivery record saved successfully.');
    }

    public function show(Delivery $delivery)
    {
        $delivery->load(['patient.user', 'antenatalRecord', 'user']);
        return view('deliveries.show', compact('delivery'));
    }

    public function destroy(Delivery $delivery)
    {
        $delivery->delete();
        return redirect()->back()->with('success', 'Delivery record deleted successfully.');
    }
}
