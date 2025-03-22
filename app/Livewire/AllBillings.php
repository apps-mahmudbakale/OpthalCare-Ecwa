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
    $query = Billing::query();

    if ($this->search) {
      $query->where('status', 'like', '%' . $this->search . '%');
    }

    $billings = $query->where('status', false)->select('id','status', 'user_id', DB::raw('SUM(amount) as total_amount'))
      ->orderBy($this->sortBy, $this->sortDirection)
      ->groupBy('id','status', 'user_id')
      ->paginate($this->perPage);

    return view('livewire.all-billings', ['billings' => $billings]);
  }
}
