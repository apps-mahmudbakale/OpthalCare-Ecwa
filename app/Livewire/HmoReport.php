<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\HmoPlan;

class HmoReport extends Component
{
    public function render()
    {
        $hmoPlans = HmoPlan::with(['hmo'])
            ->withCount('patients as enrollees_count')
            ->withCount('billings as services_enjoyed_count')
            ->withSum('billings as total_billed', 'amount')
            ->withSum(['billings as outstanding_balance' => function ($q) {
                $q->where('status', 0);
            }], 'amount')
            ->withSum(['billings as total_paid' => function ($q) {
                $q->where('status', 1);
            }], 'amount')
            ->get();

        $totals = [
            'enrollees'   => $hmoPlans->sum('enrollees_count'),
            'services'    => $hmoPlans->sum('services_enjoyed_count'),
            'billed'      => $hmoPlans->sum('total_billed'),
            'outstanding' => $hmoPlans->sum('outstanding_balance'),
            'paid'        => $hmoPlans->sum('total_paid'),
        ];

        return view('livewire.hmo-report', compact('hmoPlans', 'totals'))
            ->extends('layouts.layoutMaster')
            ->section('content');
    }
}
