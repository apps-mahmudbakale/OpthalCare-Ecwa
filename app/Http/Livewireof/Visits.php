<?php

namespace App\Http\Liveware;

use App\Models\Visit;
use Livewire\Component;

class Visits extends Base
{
  public $sortBy = 'speciality';
  public $patientId; // Add patientId property to hold the patient ID

  public function mount($patientId)
  {
    $this->patientId = $patientId;
  }

  public function render()
  {
    if ($this->search) {
      $visits = Visit::query()
        ->where('patient_id', $this->patientId)
        ->where('specility', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.visits',
        ['visits' => $visits]
      );
    } else {
      $visits = Visit::query()->where('patient_id', $this->patientId)->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.visits',
        ['visits' => $visits]
      );
    }
  }
}
