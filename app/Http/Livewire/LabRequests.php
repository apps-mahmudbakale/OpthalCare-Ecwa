<?php

namespace App\Http\Livewire;

use App\Models\LabRequest;
use Livewire\Component;

class LabRequests extends Base
{
  public $sortBy = 'created_at';
  public $patientId;

  protected $listeners = ['deleteRequest' => 'delete'];

  public function mount($patientId)
  {
    $this->patientId = $patientId;
  }
  public function render()
  {
    $requests = LabRequest::query()
      ->where('patient_id', $this->patientId)
      ->with('test')
      ->orderBy($this->sortBy, $this->sortDirection)
      ->paginate($this->perPage);
    return view('livewire.lab-requests', ['requests' => $requests]);
  }

  public function delete($id)
  {
    $request = LabRequest::find($id);
    if ($request) {
      $request->delete();
      $this->emit('labRequestDeleted');
      session()->flash('success', 'Lab Request Deleted Successfully!');
    }
  }
}
