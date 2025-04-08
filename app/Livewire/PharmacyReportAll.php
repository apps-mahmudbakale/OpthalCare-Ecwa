<?php

namespace App\Livewire;

use App\Exports\DrugsAAllStockExport;
use App\Models\Drug;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PharmacyReportAll extends Component
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
    return Excel::download(new DrugsAAllStockExport($this->store_id), 'drugs-overallstock-report.xlsx');
  }
    public function render()
    {
      $all = Drug::query()
        ->when($this->store_id, function ($query) {
          $query->where('store_id', $this->store_id);
        })
        ->with('store') // eager load the store relationship
        ->paginate(10);
        return view('livewire.pharmacy-report-all', compact('all'));
    }
}
