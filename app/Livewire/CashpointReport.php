<?php

namespace App\Livewire;

use App\Exports\CashpointExport;
use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class CashpointReport extends Component
{
  use WithPagination;

  public $cashier;
  public $cashpoint;
  public $Date;

  protected $paginationTheme = 'bootstrap';

  public function updatingCashier() { $this->resetPage(); }
  public function updatingCashpoint() { $this->resetPage(); }
  public function updatingDate() { $this->resetPage(); }

  public function getRevenueProperty()
  {
    return Payment::with(['billing', 'cashPoint'])
      ->when($this->cashier, fn($q) => $q->where('user_id', $this->cashier))
      ->when($this->cashpoint, fn($q) => $q->where('cashpoint_id', $this->cashpoint))
      ->when($this->Date, fn($q) => $q->whereDate('created_at', $this->Date))
      ->latest()
      ->paginate(15);
  }

  public function export()
  {
    $query = Payment::with(['billing', 'cashPoint'])
      ->when($this->cashier, fn($q) => $q->where('user_id', $this->cashier))
      ->when($this->cashpoint, fn($q) => $q->where('cash_point_id', $this->cashpoint))
      ->when($this->Date, fn($q) => $q->whereDate('created_at', $this->Date));

    $data = $query->get();

    return Excel::download(new CashpointExport($data), 'cashpoint-report.xlsx');
  }

  public function render()
  {
    return view('livewire.cashpoint-report', [
      'revenue' => $this->revenue,
    ]);
  }

}
