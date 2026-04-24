<?php

namespace App\Livewire;

use App\Models\Billing;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class AllBillings extends Base
{
  public $sortBy = 'created_at';

  public function render()
  {
    $query = Billing::query()->with(['patient.user', 'hmoPlan.hmo']);

    // Apply status filter
    $status = request('status', 'unpaid');
    if ($status === 'paid') {
      $query->where('status', 1);
    } elseif ($status === 'unpaid') {
      $query->where('status', 0);
    }

    // Apply payer filter
    $payer = request('payer', 'all');
    if ($payer === 'self') {
      $query->whereNull('plan_id');
    } elseif ($payer === 'hmo') {
      $query->whereNotNull('plan_id');
    }

    // Apply search
    $search = request('search');
    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('service', 'like', '%' . $search . '%')
          ->orWhere('bill_ref', 'like', '%' . $search . '%')
          ->orWhereHas('patient.user', function ($userQuery) use ($search) {
            $userQuery->where('firstname', 'like', '%' . $search . '%')
              ->orWhere('lastname', 'like', '%' . $search . '%')
              ->orWhere('middlename', 'like', '%' . $search . '%');
          });
      });
    }

    // Apply date range filter
    if (request('date_from')) {
      $query->whereDate('created_at', '>=', request('date_from'));
    }
    if (request('date_to')) {
      $query->whereDate('created_at', '<=', request('date_to'));
    }

    $query->orderBy($this->sortBy, $this->sortDirection);

    $perPage = request('per_page', 10);
    $paginated = $query->paginate($perPage);

    // Group the paginated collection by bill_ref
    $grouped = $paginated->getCollection()->groupBy('bill_ref');

    // Build query parameters for pagination, ensuring all values are strings
    $queryParams = [];
    foreach (request()->except('page') as $key => $value) {
      if (is_array($value)) {
        // Skip arrays or convert them appropriately
        continue;
      }
      $queryParams[$key] = $value;
    }

    // Create a new paginator instance with the grouped data
    $billings = new \Illuminate\Pagination\LengthAwarePaginator(
      $grouped,
      $paginated->total(),
      $paginated->perPage(),
      $paginated->currentPage(),
      [
        'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
        'pageName' => 'page',
      ]
    );

    // Append query parameters
    if (!empty($queryParams)) {
      $billings->appends($queryParams);
    }

    // Calculate summary statistics
    $summaryQuery = Billing::query();
    if ($payer === 'self') {
      $summaryQuery->whereNull('plan_id');
    } elseif ($payer === 'hmo') {
      $summaryQuery->whereNotNull('plan_id');
    }

    return view('livewire.all-billings', [
      'billings' => $billings,
      'totalAmount' => (clone $summaryQuery)->sum('amount'),
      'paidAmount' => (clone $summaryQuery)->where('status', 1)->sum('amount'),
      'unpaidAmount' => (clone $summaryQuery)->where('status', 0)->sum('amount'),
    ]);
  }
}
