<?php

namespace App\Http\Livewire;

use App\Models\Diagnosis;
use Livewire\Component;

class Diagnoses extends Base
{
  public $sortBy = 'created_at';
  public $patientId;

  protected $listeners = ['deleteDiagnosisRecord' => 'delete'];

  public function mount($patientId)
  {
    $this->patientId = $patientId;
  }
  public function render()
  {
    if ($this->search) {
      $diagnoses = Diagnosis::query()
        ->where('patient_id', $this->patientId)
        ->where('status', 'like', '%' . $this->search . '%')
        ->orWhere('ICD10', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.diagnoses',
        ['diagnoses' => $diagnoses]
      );
    } else {
      $diagnoses = Diagnosis::query()
        ->where('patient_id', $this->patientId)
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.diagnoses',
        ['diagnoses' => $diagnoses]
      );
    }
  }

  public function delete($id)
  {
    $diagnosis = Diagnosis::find($id);
    if ($diagnosis) {
      $diagnosis->delete();
      $this->emit('diagnosisDeleted');
      session()->flash('success', 'Diagnosis Deleted Successfully!');
    }
  }
}
