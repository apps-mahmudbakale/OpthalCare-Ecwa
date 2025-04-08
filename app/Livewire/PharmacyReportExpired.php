<?php

namespace App\Livewire;

use App\Exports\DrugsExpiredExport;
use App\Models\Drug;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PharmacyReportExpired extends Component
{
  use WithPagination;

  public $store_id;

  protected $paginationTheme = 'bootstrap'; // Use this if you're using Bootstrap pagination

  public function updatingStoreId()
  {
    $this->resetPage(); // Reset to first page when filter changes
  }

  public function export(): BinaryFileResponse
  {
    return Excel::download(new DrugsExpiredExport($this->store_id), 'drugs-expired-report.xlsx');
  }

  public function render()
  {
    $expired = Drug::where('expiry_date', '<=', now()->toDateString())
      ->when($this->store_id, function ($query) {
        $query->where('store_id', $this->store_id);
      })
      ->paginate(10);

    return view('livewire.pharmacy-report-expired', compact('expired'));
  }
}
