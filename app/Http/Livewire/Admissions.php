<?php

namespace App\Http\Livewire;

use App\Models\Admission;
use App\Models\Antenatal;
use Livewire\Component;

class Admissions extends Component
{
    public function render()
    {
        $admissiions = Admission::all();
        return view('livewire.admissions', compact('admissions'));
    }
}
