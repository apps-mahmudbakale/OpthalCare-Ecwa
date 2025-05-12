<?php

namespace App\Livewire;

use App\Exports\RevenueReportExport;
use App\Models\CashPoint;
use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class RevenueReport extends Component
{
  use WithPagination;

  public $service = '';
  public $cashpoint = '';
  public $method = '';
  public $Date = '';


  public function updated($property)
  {
    $this->resetPage(); // This works only if WithPagination is used
  }

  public function export()
  {
    $query = Payment::with(['billing', 'cashPoint'])
      ->when($this->service, function ($q) {
        $q->whereHas('billing', function ($query) {
          // Extract only part before the colon
          $query->whereRaw("LOWER(SUBSTRING_INDEX(service, ':', 1)) = ?", [strtolower($this->service)]);
        });
      })
      ->when($this->cashpoint, fn($q) => $q->where('cashpoint_id', $this->cashpoint))
      ->when($this->method, fn($q) => $q->where('payment_method', $this->method))
      ->when($this->Date, fn($q) => $q->whereDate('created_at', $this->Date));

    $data = $query->get();

    return Excel::download(new RevenueReportExport($data), 'revenue-report.xlsx');
  }

  public function render()
  {
    $query = Payment::query()->with(['billing', 'cashPoint']);
    if ($this->service) {
      $query->whereHas('billing', function ($q) {
        $q->whereRaw("LOWER(SUBSTRING_INDEX(service, ':', 1)) = ?", [strtolower($this->service)]);
      });
    }

    if ($this->cashpoint) {
      $query->where('cashpoint_id', $this->cashpoint);
    }

    if ($this->method) {
      $query->where('payment_method', $this->method);
    }

    if ($this->Date) {
      $query->whereDate('created_at', $this->Date);
    }
    return view('livewire.revenue-report', [
      'revenue' => $query->paginate(10),
      'cashPoints' => CashPoint::all(),
    ]);
  }
}
