<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\IOP as ModelIOP;

class IOP extends Base
{
  public $sortBy = 'created_at';
  public $IOPId;
  public $left;
  public $right;
  public $patientId; // Add patientId property to hold the patient ID

  public function mount($patientId)
  {
    $this->patientId = $patientId;
  }

  public function selectVa(ModelIOP $iop)
  {
    $this->IOPId = $iop->id;
    $this->left = $iop->left_os;
    $this->right = $iop->right_od;

    $this->dispatchBrowserEvent('IOPEditModal');
  }

  public function showVa(ModelIOP $iop)
  {
    $this->IOPId = $iop->id;
    $this->left = $iop->left_os;
    $this->right = $iop->right_od;

    $this->dispatchBrowserEvent('IOPShowModal');
  }

  public function updateVa()
  {
    ModelIOP::where('id', $this->IOPId)->update(['left' => $this->left, 'right' => $this->right]);

    return redirect()->back()->with('success', 'IOP Updated');
  }

  public function render()
  {
    if ($this->search) {
      $iops = ModelIOP::query()
        ->where('patient_id', $this->patientId)
        ->where(function ($query) {
          $query->where('left', 'like', '%' . $this->search . '%')
            ->orWhere('right', 'like', '%' . $this->search . '%');
        })
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate(10);
    } else {
      $iops = ModelIOP::query()
        ->where('patient_id', $this->patientId)
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate(10);
    }

    return view('livewire.i-o-p', ['iops' => $iops]);
  }
}
