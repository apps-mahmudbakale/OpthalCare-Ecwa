<?php

namespace App\Http\Liveware;

use App\Models\Patient;
use Livewire\WithPagination;

class Patients extends Base
{
  use WithPagination;

  public $sortBy = 'hospital_no';
  public $sortDirection = 'desc';
  public $search = '';
  public $perPage = 10;

  public function render()
  {
    $query = Patient::query();

    if ($this->search) {
      $query->join('users', 'patients.user_id', '=', 'users.id')
        ->where('patients.hospital_no', 'like', '%' . $this->search . '%')
        ->orWhere('users.firstname', 'like', '%' . $this->search . '%')
        ->orWhere('users.lastname', 'like', '%' . $this->search . '%')
        ->select('patients.*');  // Select only the patients columns to avoid ambiguity
    }

    $patients = $query->orderBy($this->sortBy, $this->sortDirection)
      ->paginate($this->perPage);

    return view('livewire.patients', [
      'patients' => $patients
    ]);
  }
}
