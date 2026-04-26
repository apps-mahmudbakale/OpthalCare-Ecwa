<?php

namespace App\Livewire;

use App\Exports\CashierSummaryExport;
use App\Models\Payment;
use App\Models\User;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class EndDayReport extends Component
{
  public $cashier;
  public $Date;


  public function getRevenueProperty()
  {
    return Payment::selectRaw('user_id, payment_method, SUM(paying_amount) as total')
      ->when($this->cashier, fn($q) => $q->where('user_id', $this->cashier))
      ->when($this->Date, fn($q) => $q->whereDate('created_at', $this->Date))
      ->groupBy('user_id', 'payment_method')
      ->get()
      ->groupBy('user_id');
  }

  public function export()
  {
    $query = Payment::query()
      ->when($this->cashier, fn($q) => $q->where('user_id', $this->cashier))
      ->when($this->Date, fn($q) => $q->whereDate('created_at', $this->Date));

    $data = $query
      ->selectRaw('user_id, payment_method, SUM(paying_amount) as total')
      ->groupBy('user_id', 'payment_method')
      ->with('user')
      ->get();

    return Excel::download(new CashierSummaryExport($data), 'cashier-summary.xlsx');
  }

  public function render()
  {
    $revenue = $this->revenue;

    // Get only users in the current result set
    $userIds = $revenue->keys()->all();
    $users = \App\Models\User::whereIn('id', $userIds)->get()->keyBy('id');
    return view('livewire.end-day-report', [
        'revenue' => $revenue,
        'cashiers' => $users,
        'allCashiers' => \App\Models\User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'patient');
        })->get(), // for dropdown
      ]
    );
  }
}
