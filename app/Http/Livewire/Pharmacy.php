<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\DrugRequest;

class Pharmacy extends Base
{
  public $sortBy = 'created_at';

  public function render()
  {
    if ($this->search) {
      $requests = DrugRequest::query()
        ->where('status', 'like', '%' . $this->search . '%')
        ->paginate(10);

      return view(
        'livewire.pharmacy',
        ['requests' => $requests]
      );
    } else {
      $requests = DrugRequest::query()
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
      return view(
        'livewire.pharmacy',
        ['requests' => $requests]
      );
    }
  }
}
