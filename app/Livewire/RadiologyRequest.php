<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\RadiologyRequest as ImagingRequest;

class RadiologyRequest extends Base
{
  public $sortBy = 'created_at';
  public $patientId; // Add patientId property to hold the patient ID

  public function mount($patientId)
  {
    $this->patientId = $patientId;
  }
  public function render()
  {
    $requests = ImagingRequest::query()
    ->where('patient_id', $this->patientId)
    ->orderBy($this->sortBy, $this->sortDirection)
    ->paginate($this->perPage);
    // dd($requests);
    return view('livewire.radiology-request', ['requests' => $requests]);
  }
}
