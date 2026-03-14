<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Billing;
use App\Models\HmoGroup;
use App\Models\HmoWallet;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class HmoBillingList extends Component
{
    use WithPagination;

    public $selectedHmoId = '';
    public $search = '';
    public $selectedBills = [];
    public $clearanceCode = '';
    public $serviceClearanceCodes = [];

    public function settleSelected()
    {
        if (empty($this->selectedBills)) {
            $this->emit('swal', ['type' => 'error', 'message' => 'No bills selected.']);
            return;
        }

        $bills = Billing::whereIn('id', $this->selectedBills)->with('hmoPlan.hmo')->get();
        
        // Ensure all selected bills belong to the same HMO Group for the wallet deduction
        $hmoGroupId = $bills->first()->hmoPlan->hmo_id;
        foreach ($bills as $bill) {
            if ($bill->hmoPlan->hmo_id !== $hmoGroupId) {
                $this->emit('swal', ['type' => 'error', 'message' => 'Selected bills must belong to the same HMO provider.']);
                return;
            }
        }

        $totalAmount = $bills->sum('amount');
        $hmo = HmoGroup::find($hmoGroupId);
        $wallet = $hmo->getWallet();

        if ($wallet->balance < $totalAmount) {
            $this->emit('swal', ['type' => 'error', 'message' => 'Insufficient HMO wallet balance. Please fund the wallet first.']);
            return;
        }

        DB::transaction(function () use ($wallet, $totalAmount, $bills, $hmo) {
            $wallet->debit($totalAmount, "Settlement for " . count($bills) . " bills");
            
            foreach ($bills as $bill) {
                // Determine the code for this specific bill: individual record code OR the bulk override
                $finalCode = $this->serviceClearanceCodes[$bill->id] 
                            ?? ($this->clearanceCode ?: null);

                $bill->update([
                    'status' => 1,
                    'clearance_code' => $finalCode
                ]);
            }
        });

        session()->flash('success', "Successfully settled " . count($bills) . " bills totaling ₦" . number_format($totalAmount, 2));
        $this->reset(['selectedBills', 'clearanceCode', 'serviceClearanceCodes']);
    }

    public function render()
    {
        $hmoGroups = HmoGroup::all();

        $query = Billing::query()
            ->whereNotNull('plan_id')
            ->where('status', 0) // Only unpaid
            ->with(['patient.user', 'hmoPlan.hmo']);

        if ($this->selectedHmoId) {
            $query->whereHas('hmoPlan', function($q) {
                $q->where('hmo_id', $this->selectedHmoId);
            });
        }

        if ($this->search) {
            $query->whereHas('patient.user', function($q) {
                $q->where('firstname', 'like', '%' . $this->search . '%')
                  ->orWhere('lastname', 'like', '%' . $this->search . '%');
            })->orWhere('service', 'like', '%' . $this->search . '%');
        }

        $bills = $query->latest()->paginate(20);

        return view('livewire.hmo-billing-list', compact('hmoGroups', 'bills'))
            ->extends('layouts.layoutMaster')
            ->section('content');
    }
}
