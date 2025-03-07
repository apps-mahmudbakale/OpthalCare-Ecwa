<?php

namespace App\Http\Livewire;

use App\Models\HmoGroup;
use App\Models\HmoPlan;
use Livewire\Component;

class HmoPlans extends Base
{
    public $sortBy = 'id';
    public $hmo_id;
    public $hmo_name;
    public $enrollment_amount;
    public $signup_amount;
    public $max_no;
    public $is_insurance;
    public $logo;

    public function selectPlan($id)
    {
        $plan = HmoPlan::find($id);
        $this->hmo_id = $plan->hmo_id;
        $this->enrollment_amount = $plan->enrollment_amount;
        $this->signup_amount = $plan->signup_amount;
        $this->max_no = $plan->max_no;
        $this->is_insurance = $plan->is_insurance;
        $this->dispatchBrowserEvent('HmoPlanEditModal');
    }

    public function updatePlan()
    {
        HmoPlan::where('id', $this->HmoId)->update([
            'hmo_id' => $this->hmo_id,
            'enrollment_amount' => $this->enrollment_amount,
            'signup_amount' => $this->signup_amount,
            'is_insurance' => $this->is_insurance
        ]);

        redirect()->route('app.settings.index')->with('success', 'HMO Plan Updated');
    }

    public function render()
    {
        if ($this->search) {
            $plans = HmoPlan::query()
                ->where('name', 'like', '%' . $this->search . '%')
                ->paginate(10);

            return view(
                'livewire.hmo-plans',
                ['plans' => $plans]
            );
        } else {
            $plans = HmoPlan::query()
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate($this->perPage);
            $hmos = HmoGroup::all();
            return view(
                'livewire.hmo-plans',
                ['plans' => $plans, 'hmos' =>$hmos]
            );
        }
    }
}
