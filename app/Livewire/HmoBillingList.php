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
    public $selectAll = false;

    public function updatingSearch() { $this->resetPage(); }
    public function updatingSelectedHmoId() { $this->resetPage(); }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedBills = Billing::query()
                ->whereNotNull('plan_id')
                ->where('status', 0)
                ->when($this->selectedHmoId, function($q) {
                    $q->whereHas('hmoPlan', function($sq) {
                        $sq->where('hmo_id', $this->selectedHmoId);
                    });
                })
                ->when($this->search, function($q) {
                    $q->whereHas('patient.user', function($sq) {
                        $sq->where('firstname', 'like', '%' . $this->search . '%')
                          ->orWhere('lastname', 'like', '%' . $this->search . '%');
                    })->orWhere('service', 'like', '%' . $this->search . '%');
                })
                ->pluck('id')
                ->map(fn($id) => (string) $id)
                ->toArray();
        } else {
            $this->selectedBills = [];
        }
    }

    public function settleSelected()
    {
        if (empty($this->selectedBills)) {
            $this->emit('swal', ['type' => 'error', 'message' => 'No bills selected.']);
            return;
        }

        if ($this->processSettlement($this->selectedBills)) {
            $this->reset(['selectedBills', 'clearanceCode', 'serviceClearanceCodes', 'selectAll']);
        }
    }

    public function settleSingle($billId)
    {
        if ($this->processSettlement([$billId])) {
            $this->reset(['serviceClearanceCodes']); // Clear the specific code if successful
        }
    }

    private function processSettlement($billIds)
    {
        $bills = Billing::whereIn('id', $billIds)->with(['hmoPlan.hmo', 'patient.user'])->get();
        
        if ($bills->isEmpty()) return false;

        // Ensure all selected bills belong to the same HMO Group for the wallet deduction
        $hmoGroupId = $bills->first()->hmoPlan->hmo_id;
        foreach ($bills as $bill) {
            if ($bill->hmoPlan->hmo_id !== $hmoGroupId) {
                $this->emit('swal', ['type' => 'error', 'message' => 'Selected bills must belong to the same HMO provider.']);
                return false;
            }
        }

        $totalAmount = $bills->sum('amount');
        $hmo = HmoGroup::find($hmoGroupId);
        $wallet = $hmo->getWallet();

        if ($wallet->balance < $totalAmount) {
            $this->emit('swal', ['type' => 'error', 'message' => 'Insufficient HMO wallet balance. Please fund the wallet first.']);
            return false;
        }

        try {
            DB::transaction(function () use ($wallet, $totalAmount, $bills, $hmo) {
                $wallet->debit($totalAmount, "Settlement for " . count($bills) . " bills");
                
                foreach ($bills as $bill) {
                    // Determine the code for this specific bill: individual record code OR the bulk override
                    $individualCode = $this->serviceClearanceCodes[$bill->id] ?? null;
                    $finalCode = !empty($individualCode) ? $individualCode : ($this->clearanceCode ?: null);

                    if (empty($finalCode)) {
                        $patientName = $bill->patient->user->firstname ?? 'Unknown Patient';
                        throw new \Exception("Clearance code is required for service: " . $bill->service . " (Patient: " . $patientName . ")");
                    }

                    $bill->update([
                        'status' => 1,
                        'clearance_code' => $finalCode
                    ]);
                }
            });

            $this->emit('swal', [
                'type' => 'success', 
                'message' => "Successfully settled " . count($bills) . " bills totaling ₦" . number_format($totalAmount, 2)
            ]);
            return true;
        } catch (\Exception $e) {
            $this->emit('swal', ['type' => 'error', 'message' => $e->getMessage()]);
            return false;
        }
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
