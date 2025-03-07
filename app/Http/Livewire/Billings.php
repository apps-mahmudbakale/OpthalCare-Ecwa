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
    if ($this->search) {
      $billings = Billing::query()
        ->where('user_id', $this->patientId)
        ->where('status', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.billings',
        ['billings' => $billings]
      );
    } else {
      $billings = Billing::query()
        ->where('user_id', $this->patientId)
        ->where('status', false)
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.billings',
        ['billings' => $billings]
      );
    }
  }
}
