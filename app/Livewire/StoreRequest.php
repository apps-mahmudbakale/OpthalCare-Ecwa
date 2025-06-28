<?php

namespace App\Livewire;

use App\Models\DrugRequest;
use Livewire\Component;

class StoreRequest extends Base
{
  public $sortBy = 'created_at';

  public function render()
  {
    $query = \App\Models\StoreRequest::with(['drug', 'store', 'user'])
      ->where('status', 'Pending')
      ->orWhere('status', 'Approved')
      ->orderBy($this->sortBy, $this->sortDirection);

    if ($this->search) {
      $query->where('status', 'like', '%' . $this->search . '%');
    }

    $paginated = $query->paginate($this->perPage);

    // Group the paginated collection by request_ref
    $grouped = $paginated->getCollection()->groupBy('ref');

    // Create a new paginator instance with the grouped data
    $requests = new \Illuminate\Pagination\LengthAwarePaginator(
      $grouped,
      $paginated->total(),
      $paginated->perPage(),
      $paginated->currentPage(),
      ['path' => request()->url(), 'query' => request()->query()]
    );

    return view('livewire.store-request', ['requests' => $requests]);
  }
}
