<?php

namespace App\Livewire;

use App\Models\Billing;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class AllBillings extends Base
{
  public $sortBy = 'status';

  public function render()
  {
    $query = Billing::query()->where('status', 0)->whereNull('plan_id');

    if ($this->search) {
      $query->where('status', 'like', '%' . $this->search . '%');
    }

    $paginated = $query->paginate($this->perPage);

    // Group the paginated collection by request_ref
    $grouped = $paginated->getCollection()->groupBy('bill_ref');

    // Create a new paginator instance with the grouped data
    $billings = new \Illuminate\Pagination\LengthAwarePaginator(
      $grouped,
      $paginated->total(),
      $paginated->perPage(),
      $paginated->currentPage(),
      ['path' => request()->url(), 'query' => request()->query()]
    );

    return view('livewire.all-billings', ['billings' => $billings]);
  }
}
