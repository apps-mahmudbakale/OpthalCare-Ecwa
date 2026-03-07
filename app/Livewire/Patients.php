<?php

namespace App\Livewire;

use App\Models\Patient;
use App\Models\Tag;
use Illuminate\Support\Carbon;
use Livewire\WithPagination;

class Patients extends Base
{
  use WithPagination;

  public $sortBy = 'hospital_no';
  public $sortDirection = 'desc';
  public $search = '';
  public $perPage = 10;

  public $filterGender = '';
  public $filterTag = '';
  public $filterAge = '';

  public function render()
  {
    $query = Patient::query()->with('user', 'hmoPlan.hmo');

    if ($this->search) {
      $query->join('users', 'patients.user_id', '=', 'users.id')
        ->where(function($q) {
          $q->where('patients.hospital_no', 'like', '%' . $this->search . '%')
            ->orWhere('patients.phone', 'like', '%' . $this->search . '%')
            ->orWhere('patients.date_of_birth', 'like', '%' . $this->search . '%')
            ->orWhere('users.firstname', 'like', '%' . $this->search . '%')
            ->orWhere('users.lastname', 'like', '%' . $this->search . '%')
            ->orWhere('patients.middlename', 'like', '%' . $this->search . '%');
        })
        ->select('patients.*');
    }

    if ($this->filterGender) {
      $query->where('gender', $this->filterGender);
    }
    if ($this->filterTag) {
      $query->where('tag_id', $this->filterTag);
    }

    if ($this->filterAge) {
      $age = (int) $this->filterAge;
      $fromDate = Carbon::now()->subYears($age + 1)->addDay();
      $toDate = Carbon::now()->subYears($age);
      $query->whereBetween('date_of_birth', [$fromDate, $toDate]);
    }

    $patients = $query->orderBy($this->sortBy, $this->sortDirection)
      ->paginate($this->perPage);

    $tags = Tag::all();
    return view('livewire.patients', [
      'patients' => $patients,
      'tags' => $tags
    ]);
  }
}
