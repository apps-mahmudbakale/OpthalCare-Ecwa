<?php

namespace App\Livewire;

use App\Models\OpticalRequest;
use App\Models\Patient;
use Livewire\Component;

class Opticals extends Component
{
    public function render()
    {
      $patients = Patient::all();
      $opticals = OpticalRequest::all();
        return view('livewire.opticals', compact('patients', 'opticals'));
    }
}
