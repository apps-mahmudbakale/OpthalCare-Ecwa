<?php

namespace App\Http\Livewire;

use App\Models\Billing;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class AllBillings extends Base
{
  public $sortBy = 'status';

  public function render()
  {
    $query = Billing::query();

    if ($this->search) {
      $query->where('status', 'like', '%' . $this->search . '%');
    }

   $billings = $query->orderBy($this->sortBy, $this->sortDirection)->paginate(10);
    $billings = $billings->getCollection()->groupBy('bill_ref');

    return view('livewire.all-billings', ['billings' => $billings]);
  }
}
