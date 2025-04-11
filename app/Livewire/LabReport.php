<?php

namespace App\Livewire;

use App\Exports\LabReportExport;
use App\Models\LabRequest;
use App\Models\LabCategory;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LabReport extends Component
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
    $query = LabRequest::with('test.category')
      ->selectRaw('test_id, COUNT(*) as request_count')
      ->groupBy('test_id');

    if ($this->category_id) {
      $query->whereHas('test', fn ($q) => $q->where('category_id', $this->category_id));
    }

    if ($this->status) {
      $query->where('status', $this->status);
    }

    if ($this->startDate && $this->endDate) {
      $query->whereBetween(\DB::raw('DATE(created_at)'), [$this->startDate, $this->endDate]);
    } elseif ($this->startDate) {
      $query->whereDate('created_at', $this->startDate);
    }

    $data = $query->get();

    return
      Excel::download(new LabReportExport($data), 'lab-report.xlsx');
  }

  public function render()
  {
    $query = LabRequest::with('test.category')
      ->selectRaw('test_id, COUNT(*) as request_count')
      ->groupBy('test_id');

    if ($this->category_id) {
      $query->whereHas('test', fn ($q) => $q->where('category_id', $this->category_id));
    }

    if ($this->status) {
      $query->where('status', $this->status);
    }

    if ($this->startDate && $this->endDate) {
      $query->whereBetween(DB::raw('DATE(created_at)'), [$this->startDate, $this->endDate]);
    } elseif ($this->startDate) {
      $query->whereDate('created_at', $this->startDate);
    }

    $labReports = $query->paginate(10);
    $categories = LabCategory::all();

    return view('livewire.lab-report', compact('labReports', 'categories'));
  }
}
