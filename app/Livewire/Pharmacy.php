<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DrugRequest;

class Pharmacy extends Base
{
  public $sortBy = 'created_at';

  public function render()
  {
    $query = DrugRequest::with(['drug', 'patient.user', 'user'])
      ->orderBy($this->sortBy, $this->sortDirection);

    if ($this->search) {
      $query->where('status', 'like', '%' . $this->search . '%');
    }

    $paginated = $query->paginate($this->perPage);

    // Group the paginated collection by request_ref
    $grouped = $paginated->getCollection()->groupBy('request_ref');

    // Create a new paginator instance with the grouped data
    $requests = new \Illuminate\Pagination\LengthAwarePaginator(
      $grouped,
      $paginated->total(),
      $paginated->perPage(),
      $paginated->currentPage(),
      ['path' => request()->url(), 'query' => request()->query()]
    );

    return view('livewire.pharmacy', ['requests' => $requests]);
  }
}
