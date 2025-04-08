<?php

namespace App\Livewire;

use App\Exports\DrugsExpiredExport;
use App\Exports\DrugsLowStockExport;
use App\Models\Drug;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PharmacyReportLow extends Component
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
    return Excel::download(new DrugsLowStockExport($this->store_id), 'drugs-low-stock-report.xlsx');
  }
    public function render()
    {
      $lowstock = Drug::whereColumn('quantity', '<=', 'threshold')
      ->when($this->store_id, function ($query) {
      $query->where('store_id', $this->store_id);
    })
      ->paginate(10);
        return view('livewire.pharmacy-report-low', compact('lowstock'));
    }
}
