<?php

namespace App\Livewire;

use App\Exports\DrugsFilledExport;
use App\Models\DrugRequest;
use App\Models\DrugStore;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PharmacyReportFilled extends Component
{
  use WithPagination;

  public $store_id;
  public $startDate;
  public $endDate;

  protected $paginationTheme = 'bootstrap';

  public function updating($field)
  {
    if (in_array($field, ['store_id', 'startDate', 'endDate'])) {
      $this->resetPage();
    }
  }

  public function export(): BinaryFileResponse
  {
    return Excel::download(new DrugsFilledExport($this->store_id, $this->startDate, $this->endDate), 'drugs-filled-report.xlsx');
  }

  public function render()
  {
    $filled = DrugRequest::with(['store', 'patient.user', 'drug'])
      ->where('status', 'filled')
      ->when($this->store_id, fn($q) => $q->where('store_id', $this->store_id))
      ->when($this->startDate, fn($q) => $q->whereDate('created_at', '>=', $this->startDate))
      ->when($this->endDate, fn($q) => $q->whereDate('created_at', '<=', $this->endDate))
      ->orderByDesc('created_at')
      ->paginate(10);

    $stores = DrugStore::all();

    return view('livewire.pharmacy-report-filled', compact('filled', 'stores'));
  }
}
