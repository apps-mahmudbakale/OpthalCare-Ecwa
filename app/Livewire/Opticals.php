<?php

namespace App\Livewire;

use App\Models\OpticalRequest;
use App\Models\Patient;
use Livewire\Component;

class Opticals extends Component
{
    public $patient_id;
    public $start;
    public $stop;

    public function dispense($requestId)
    {
        $request = OpticalRequest::with('service')->findOrFail($requestId);

        if ($request->status == 'dispensed') {
            session()->flash('error', 'This item has already been dispensed.');
            return;
        }

        // 1. Verify Payment
        $serviceHandler = new \App\Services\ServiceRequestHandler();
        $serviceName = "Antenatal:" . $request->service->name;
        $paid = $serviceHandler->isBilled($request->service->id, $serviceName, $request->ref);

        if ($paid != '1') {
            session()->flash('error', 'Service Has Not Been Paid For Yet');
            return;
        }

        // 2. Check Inventory
        $item = $request->service;
        if (!$item || $item->qty <= 0) {
            session()->flash('error', 'Out of stock! Please restock before dispensing.');
            return;
        }

        // 3. Subtract Qty and update status
        $item->decrement('qty');
        $request->update(['status' => 'dispensed']);

        session()->flash('success', 'Optical item dispensed successfully!');
    }

    public function render()
    {
        $patients = Patient::all();
        $query = OpticalRequest::with(['patient.user', 'service']);

        if ($this->patient_id) {
            $query->where('patient_id', $this->patient_id);
        }

        if ($this->start) {
            $query->whereDate('created_at', '>=', $this->start);
        }

        if ($this->stop) {
            $query->whereDate('created_at', '<=', $this->stop);
        }

        $opticals = $query->latest()->get();

        return view('livewire.opticals', compact('patients', 'opticals'));
    }
}
