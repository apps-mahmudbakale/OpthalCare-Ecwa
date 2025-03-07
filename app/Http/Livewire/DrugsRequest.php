<?php

namespace App\Http\Livewire;

use App\Models\DrugRequest;
use Livewire\Component;

class DrugsRequest extends Base
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
      $requests = DrugRequest::query()
        ->where('patient_id', $this->patientId)
        ->where('status', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.drugs-request',
        ['requests' => $requests]
      );
    } else {
      $requests = DrugRequest::query()
        ->where('patient_id', $this->patientId)
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.drugs-request',
        ['requests' => $requests]
      );
    }
  }
}
