<?php

namespace App\Livewire;

use App\Models\Billing;
use Livewire\Component;

class Billings extends Base
{
  public $sortBy = 'created_at';
  public $patientId; // Add patientId property to hold the patient ID
  
  // Filter properties
  public $statusFilter = 'all'; // all, paid, unpaid
  public $dateFrom = '';
  public $dateTo = '';
  public $serviceFilter = '';

  public function mount($patientId)
  {
    $this->patientId = $patientId;
  }

  public function updatedStatusFilter()
  {
    $this->resetPage();
  }

  public function updatedDateFrom()
  {
    $this->resetPage();
  }

  public function updatedDateTo()
  {
    $this->resetPage();
  }

  public function updatedServiceFilter()
  {
    $this->resetPage();
  }

  public function clearFilters()
  {
    $this->search = '';
    $this->statusFilter = 'all';
    $this->dateFrom = '';
    $this->dateTo = '';
    $this->serviceFilter = '';
    $this->resetPage();
  }

  public function render()
  {
    $query = Billing::query()
      ->where('user_id', $this->patientId)
      ->whereNull('plan_id');

    // Apply search
    if ($this->search) {
      $query->where(function ($q) {
        $q->where('service', 'like', '%' . $this->search . '%')
          ->orWhere('bill_ref', 'like', '%' . $this->search . '%');
      });
    }

    // Apply status filter
    if ($this->statusFilter === 'paid') {
      $query->where('status', 1);
    } elseif ($this->statusFilter === 'unpaid') {
      $query->where('status', 0);
    }

    // Apply date range filter
    if ($this->dateFrom) {
      $query->whereDate('created_at', '>=', $this->dateFrom);
    }
    if ($this->dateTo) {
      $query->whereDate('created_at', '<=', $this->dateTo);
    }

    // Apply service filter
    if ($this->serviceFilter) {
      $query->where('service', 'like', '%' . $this->serviceFilter . '%');
    }

    $billings = $query->orderBy($this->sortBy, $this->sortDirection)
      ->paginate($this->perPage);

    return view('livewire.billings', [
      'billings' => $billings,
      'totalAmount' => $query->sum('amount'),
      'paidAmount' => (clone $query)->where('status', 1)->sum('amount'),
      'unpaidAmount' => (clone $query)->where('status', 0)->sum('amount'),
    ]);
  }
}
