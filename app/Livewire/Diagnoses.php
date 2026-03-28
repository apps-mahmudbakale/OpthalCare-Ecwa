<?php

namespace App\Livewire;

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
    $query = Diagnosis::query()->where('patient_id', $this->patientId);

    if ($this->search) {
      $query->where(function ($q) {
        $q->where('status', 'like', '%' . $this->search . '%')
          ->orWhere('history', 'like', '%' . $this->search . '%')
          ->orWhere('assessment', 'like', '%' . $this->search . '%')
          ->orWhereHas('ICD', function ($q) {
            $q->where('number', 'like', '%' . $this->search . '%')
              ->orWhere('name', 'like', '%' . $this->search . '%');
          });
      });
    }

    $diagnoses = $query->orderBy($this->sortBy, $this->sortDirection)
      ->paginate($this->perPage);

    return view('livewire.diagnoses', ['diagnoses' => $diagnoses]);
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
