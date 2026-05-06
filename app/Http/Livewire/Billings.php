<?php

namespace App\Http\Livewire;

use App\Models\Billing;
use Livewire\Component;

class Billings extends Base
{
  public $sortBy = 'created_at';
  public $patientId; // Add patientId property to hold the patient ID

  public function mount($patientId)
  {
    $this->patientId = $patientId;
  }
  public function render()
  {
    // Get patient to check if they have HMO
    $patient = \App\Models\Patient::find($this->patientId);
    
    // If patient has HMO plan, don't show bills in patient profile (they go to HMO billing)
    if ($patient && $patient->hmo_plan_id) {
      return view('livewire.billings', ['billings' => collect(), 'isHmoPatient' => true]);
    }

    if ($this->search) {
      $billings = Billing::query()
        ->where('user_id', $this->patientId)
        ->whereNull('plan_id') // Only show self-pay bills
        ->where('status', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.billings',
        ['billings' => $billings, 'isHmoPatient' => false]
      );
    } else {
      $billings = Billing::query()
        ->where('user_id', $this->patientId)
        ->whereNull('plan_id') // Only show self-pay bills
        ->where('status', false)
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.billings',
        ['billings' => $billings, 'isHmoPatient' => false]
      );
    }
  }
}
