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
            ->withSum('billings as total_debt', 'amount')
            ->get();

        return view('livewire.hmo-report', compact('hmoPlans'))
            ->extends('layouts.layoutMaster')
            ->section('content');
    }
}
