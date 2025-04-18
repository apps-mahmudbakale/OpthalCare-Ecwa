<?php

namespace App\Livewire;

use App\Models\LabRequest;
use Livewire\Component;

class LabRequests extends Base
{
  public $sortBy = 'created_at';
  public $patientId; // Add patientId property to hold the patient ID

  public function mount($patientId)
  {
    $this->patientId = $patientId;
  }
  public function render()
  {
    $requests = LabRequest::query()
      ->where('patient_id', $this->patientId)
      ->orderBy($this->sortBy, $this->sortDirection)
      ->paginate($this->perPage);
    return view('livewire.lab-requests', ['requests' => $requests]);
  }
}
