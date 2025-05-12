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
    return Payment::selectRaw('cashpoint_id, SUM(paying_amount) as total_revenue')
      ->when($this->cashier, fn($q) => $q->where('user_id', $this->cashier))
      ->when($this->cashpoint, fn($q) => $q->where('cashpoint_id', $this->cashpoint))
      ->when($this->Date, fn($q) => $q->whereDate('created_at', $this->Date))
      ->groupBy('cashpoint_id')
      ->with('cashPoint')
      ->get();
  }


  public function export()
  {
    $data = Payment::selectRaw('cashpoint_id, SUM(paying_amount) as total_revenue')
      ->when($this->cashier, fn($q) => $q->where('user_id', $this->cashier))
      ->when($this->cashpoint, fn($q) => $q->where('cashpoint_id', $this->cashpoint))
      ->when($this->Date, fn($q) => $q->whereDate('created_at', $this->Date))
      ->groupBy('cashpoint_id')
      ->with('cashPoint')
      ->get();

    return Excel::download(new CashpointExport($data), 'cashpoint-report.xlsx');
  }

  public function render()
  {
    return view('livewire.cashpoint-report', [
      'revenue' => $this->revenue,
    ]);
  }

}
