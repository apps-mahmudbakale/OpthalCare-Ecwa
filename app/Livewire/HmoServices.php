<?php

namespace App\Livewire;

use App\Models\HmoPlan;
use App\Models\HmoService;
use App\Models\Service;
use Livewire\Component;

class HmoServices extends Base
{
    public $plan_id;
    public $service_id;
    public $price;
    public $editing_id = null;

    protected $listeners = ['manageServices' => 'loadPlan'];

    public function loadPlan($plan_id)
    {
        $this->plan_id = $plan_id;
        $this->reset(['service_id', 'price', 'editing_id']);
        $this->dispatchBrowserEvent('HmoServicesModal');
    }

    public function addService()
    {
        $this->validate([
            'service_id' => 'required|exists:services,id',
            'price' => 'required|numeric|min:0',
        ]);

        // Check if service already exists for this plan
        $exists = HmoService::where('plan_id', $this->plan_id)
            ->where('service_id', $this->service_id)
            ->exists();

        if ($exists) {
            $this->addError('service_id', 'This service is already added to this plan.');
            return;
        }

        HmoService::create([
            'plan_id' => $this->plan_id,
            'service_id' => $this->service_id,
            'price' => $this->price,
        ]);

        $this->reset(['service_id', 'price']);
        session()->flash('success', 'Service added successfully.');
    }

    public function editService($id)
    {
        $hmoService = HmoService::findOrFail($id);
        $this->editing_id = $id;
        $this->service_id = $hmoService->service_id;
        $this->price = $hmoService->price;
    }

    public function updateService()
    {
        $this->validate([
            'price' => 'required|numeric|min:0',
        ]);

        HmoService::where('id', $this->editing_id)->update([
            'price' => $this->price,
        ]);

        $this->reset(['editing_id', 'service_id', 'price']);
        session()->flash('success', 'Service price updated.');
    }

    public function removeService($id)
    {
        HmoService::destroy($id);
        session()->flash('success', 'Service removed from plan.');
    }

    public function cancelEdit()
    {
        $this->reset(['editing_id', 'service_id', 'price']);
    }

    public function render()
    {
        $plan = $this->plan_id ? HmoPlan::find($this->plan_id) : null;
        $assignedServices = $this->plan_id 
            ? HmoService::where('plan_id', $this->plan_id)
                ->with('service')
                ->get()
            : collect();

        $allServices = Service::orderBy('name')->get();

        return view('livewire.hmo-services', [
            'plan' => $plan,
            'assignedServices' => $assignedServices,
            'allServices' => $allServices,
        ]);
    }
}
