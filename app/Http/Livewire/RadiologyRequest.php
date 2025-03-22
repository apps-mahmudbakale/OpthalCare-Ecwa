<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\RadiologyRequest as ImagingRequest;

class RadiologyRequest extends Component
{
  public function render()
  {
    $requests = ImagingRequest::all();
    // dd($requests);
    return view('livewire.radiology-request', ['requests' => $requests]);
  }
}
