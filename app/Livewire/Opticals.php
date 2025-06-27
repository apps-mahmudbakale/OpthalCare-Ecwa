<?php

namespace App\Livewire;

use App\Models\Patient;
use Livewire\Component;

class Opticals extends Component
{
    public function render()
    {
      $patients = Patient::all();
        return view('livewire.opticals', compact('patients'));
    }
}
