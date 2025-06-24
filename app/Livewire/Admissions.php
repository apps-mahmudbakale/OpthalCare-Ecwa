<?php

namespace App\Livewire;

use App\Models\Admission;
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
      ->where('status', 'prepared')
      ->paginate('10');


    if ($this->patient_id) {
      $admissions = Admission::with(['patient', 'ward', 'bed', 'procedureRequests'])
        ->where('status', 'pending')
        ->where('admissions.patient_id', $this->patient_id)
        ->paginate('10');

    }

    if ($this->ward_id) {
      $admissions = Admission::with(['patient', 'ward', 'bed', 'procedureRequests'])
        ->where('status', 'pending')
        ->where('admissions.ward_id', $this->ward_id)
        ->paginate('10');
    }



    $patients = Patient::all();
    $wards = Ward::all();

    return view('livewire.admissions', compact('admissions', 'patients', 'wards'));
  }

}
