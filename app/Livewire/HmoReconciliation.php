<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Billing;
use App\Models\HmoPlan;
use App\Exports\HmoReconciliationExport;
use Maatwebsite\Excel\Facades\Excel;

class HmoReconciliation extends Component
{
    use WithPagination;

    public $planId = '';
    public $dateFrom = '';
    public $dateTo = '';

    public function export()
    {
        return Excel::download(new HmoReconciliationExport($this->planId, $this->dateFrom, $this->dateTo), 'hmo-reconciliation-report.xlsx');
    }

    public function updatingPlanId() { $this->resetPage(); }
    public function updatingDateFrom() { $this->resetPage(); }
    public function updatingDateTo() { $this->resetPage(); }

    public function render()
    {
        $plans = HmoPlan::with('hmo')->get();

        $query = Billing::query()
            ->whereNotNull('plan_id')
            ->with(['patient.user', 'hmoPlan.hmo']);

        if ($this->planId) {
            $query->where('plan_id', $this->planId);
        }

        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        $bills = $query->latest()->paginate(20);

        // Summary totals for filtered results
        $summaryQuery = Billing::query()
            ->whereNotNull('plan_id');

        if ($this->planId) {
            $summaryQuery->where('plan_id', $this->planId);
        }
        if ($this->dateFrom) {
            $summaryQuery->whereDate('created_at', '>=', $this->dateFrom);
        }
        if ($this->dateTo) {
            $summaryQuery->whereDate('created_at', '<=', $this->dateTo);
        }

        $summary = [
            'total_billed' => (clone $summaryQuery)->sum('amount'),
            'total_outstanding' => (clone $summaryQuery)->where('status', 0)->sum('amount'),
            'total_paid' => (clone $summaryQuery)->where('status', 1)->sum('amount'),
            'total_services' => (clone $summaryQuery)->count(),
        ];

        return view('livewire.hmo-reconciliation', compact('plans', 'bills', 'summary'))
            ->extends('layouts.layoutMaster')
            ->section('content');
    }
}
