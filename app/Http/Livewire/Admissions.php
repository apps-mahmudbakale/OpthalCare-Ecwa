<?php

namespace App\Http\Livewire;

use App\Models\Admission;
use App\Models\Antenatal;
use App\Models\Patient;
use App\Models\Ward;
use Livewire\Component;

class Admissions extends Component
{
  public $patient_id;
  public $ward_id;

  public function render()
  {
    $admissions = Admission::with(['patient', 'ward', 'bed', 'procedureRequests'])
    ->where('status', 'pending')
    ->where('status', 'prepared');
    if ($this->patient_id) {
      $admissions->where('patient_id', $this->patient_id);
    }
    if ($this->ward_id) {
      $admissions->where('ward_id', $this->ward_id);
    }
    $admissions->get();
    $patients = Patient::all();
    $wards = Ward::all();

    return view('livewire.admissions', compact('admissions', 'patients', 'wards'));
  }
}
