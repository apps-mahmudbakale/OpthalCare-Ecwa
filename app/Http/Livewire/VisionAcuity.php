<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\VisionAcuity as ModelVisionAcuity;

class VisionAcuity extends Base
{
  public $sortBy = 'created_at';
  public $VaId;
  public $left;
  public $right;
  public $patientId; // Add patientId property to hold the patient ID

  public function mount($patientId)
  {
    $this->patientId = $patientId;
  }

  public function selectVa(ModelVisionAcuity $va)
  {
    $this->VaId = $va->id;
    $this->left = $va->left_os;
    $this->right = $va->right_od;

    $this->dispatchBrowserEvent('VaEditModal');
  }

  public function showVa(ModelVisionAcuity $va)
  {
    $this->VaId = $va->id;
    $this->left = $va->left_os;
    $this->right = $va->right_od;

    $this->dispatchBrowserEvent('VaShowModal');
  }

  public function updateVa()
  {
    ModelVisionAcuity::where('id', $this->VaId)->update(['left_os' => $this->left, 'right_od' => $this->right]);

    return redirect()->back()->with('success', 'VA Updated');
  }

  public function render()
  {
    if ($this->search) {
      $vas = ModelVisionAcuity::query()
        ->where('patient_id', $this->patientId)
        ->where(function ($query) {
          $query->where('left_os', 'like', '%' . $this->search . '%')
            ->orWhere('right_od', 'like', '%' . $this->search . '%');
        })
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate(10);
    } else {
      $vas = ModelVisionAcuity::query()
        ->where('patient_id', $this->patientId)
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate(10);
    }

    return view('livewire.vision-acuity', ['vas' => $vas]);
  }
}
