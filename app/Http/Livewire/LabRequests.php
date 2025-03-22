<?php

namespace App\Http\Livewire;

use App\Models\LabRequest;
use Livewire\Component;

class LabRequests extends Component
{
  public function render()
  {
    $requests = LabRequest::all();
    return view('livewire.lab-requests', ['requests' => $requests]);
  }
}
