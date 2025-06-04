<?php

namespace App\Livewire;

use App\Models\Admission;
use Livewire\Component;

class Admissions extends Component
{
  public function render()
  {
    $admissions = Admission::with(['patient', 'ward', 'bed'])
      ->where('status', 'active')
      ->get();

    return view('livewire.admissions', compact('admissions'));
  }
}
