<?php

namespace App\Livewire;

use App\Exports\RadReportExport;
use App\Models\LabRequest;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class RadReport extends Component
{
  use WithPagination;

  public ?int $category_id = null;
  public ?string $status = null;
  public ?string $startDate = null;
  public ?string $endDate = null;

  public function updating($field)
  {
    if (in_array($field, ['category_id', 'status', 'startDate', 'endDate'])) {
      $this->resetPage();
    }
  }

  public function export()
  {
    $query = \App\Models\RadiologyRequest::with(['test.category', 'patient.user'])
      ->latest();

    if ($this->category_id) {
      $query->whereHas('test', fn ($q) => $q->where('category_id', $this->category_id));
    }

    if ($this->status) {
      $query->where('status', $this->status);
    }

    if ($this->startDate) {
      $query->whereDate('created_at', '>=', $this->startDate);
    }
    if ($this->endDate) {
      $query->whereDate('created_at', '<=', $this->endDate);
    }

    $data = $query->get();

    return Excel::download(new RadReportExport($data), 'rad-report.xlsx');
  }

  public function render()
  {
    $query = \App\Models\RadiologyRequest::with(['test.category', 'patient.user'])
      ->latest();

    if ($this->category_id) {
      $query->whereHas('test', fn ($q) => $q->where('category_id', $this->category_id));
    }

    if ($this->status) {
      $query->where('status', $this->status);
    }

    if ($this->startDate) {
      $query->whereDate('created_at', '>=', $this->startDate);
    }
    if ($this->endDate) {
      $query->whereDate('created_at', '<=', $this->endDate);
    }

    $radReports = $query->paginate(10);
    $categories = \App\Models\RadiologyCategory::all();

    return view('livewire.rad-report', compact('radReports', 'categories'));
  }
}
