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
    protected $listeners = ['refresh' => '$refresh'];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingSelectedHmoId() { $this->resetPage(); }

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
