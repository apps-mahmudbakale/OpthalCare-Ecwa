<?php

namespace App\Livewire;

use App\Models\HmoGroup;
use App\Models\HmoPlan;
use Livewire\Component;

class HmoPlans extends Base
{
    public $plan_id;
    public $hmo_id;
    public $name;
    public $enrollment_amount;
    public $signup_amount;
    public $max_no;
    public $is_insurance;
    public $logo;

    protected $rules = [
        'hmo_id' => 'required|exists:hmo_groups,id',
        'name' => 'required|string|max:255',
        'enrollment_amount' => 'nullable|numeric|min:0',
        'signup_amount' => 'nullable|numeric|min:0',
        'max_no' => 'nullable|integer|min:1',
        'is_insurance' => 'boolean',
    ];



    public function render()
    {
        $query = HmoPlan::query()->with('hmo');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhereHas('hmo', function($q) {
                      $q->where('name', 'like', '%' . $this->search . '%');
                  });
        }

        $plans = $query->orderBy($this->sortBy ?: 'id', $this->sortDirection)
                       ->paginate($this->perPage);

        $hmos = HmoGroup::all();
        
        return view('livewire.hmo-plans', [
            'plans' => $plans,
            'hmos' => $hmos
        ]);
    }
}
