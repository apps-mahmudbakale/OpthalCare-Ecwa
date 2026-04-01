@extends('layouts.layoutMaster')
@section('title', 'HMO Reconciliation')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Reports /</span> HMO Reconciliation</h4>

{{-- Filters --}}
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('app.reports.hmo-reconciliation') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">HMO Plan</label>
                <select name="plan_id" class="form-select">
                    <option value="">All Plans</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}" {{ $planId == $plan->id ? 'selected' : '' }}>
                            {{ $plan->hmo->name ?? 'N/A' }} — {{ $plan->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">From Date</label>
                <input type="date" name="date_from" value="{{ $dateFrom }}" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label">To Date</label>
                <input type="date" name="date_to" value="{{ $dateTo }}" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All</option>
                    <option value="0" {{ $status === '0' ? 'selected' : '' }}>Unpaid</option>
                    <option value="1" {{ $status === '1' ? 'selected' : '' }}>Paid</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2 align-items-end">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('app.reports.hmo-reconciliation') }}" class="btn btn-outline-secondary">Clear</a>
            </div>
            <div class="col-md-12 d-flex justify-content-end">
                <a href="{{ route('app.reports.hmo-reconciliation.export', ['plan_id' => $planId, 'date_from' => $dateFrom, 'date_to' => $dateTo, 'status' => $status]) }}"
                   class="btn btn-success">
                    <i class="ti ti-file-spreadsheet me-1"></i> Export
                    @if($planId) <small>(Plan Only)</small> @endif
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Summary Cards --}}
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body d-flex align-items-start justify-content-between">
                <div>
                    <span>Total Services</span>
                    <h4 class="mb-0 mt-1">{{ number_format($summary['total_services']) }}</h4>
                </div>
                <span class="badge bg-label-primary rounded p-2"><i class="ti ti-list ti-sm"></i></span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body d-flex align-items-start justify-content-between">
                <div>
                    <span>Total Billed</span>
                    <h4 class="mb-0 mt-1">&#8358;{{ number_format($summary['total_billed'], 2) }}</h4>
                </div>
                <span class="badge bg-label-info rounded p-2"><i class="ti ti-file-invoice ti-sm"></i></span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body d-flex align-items-start justify-content-between">
                <div>
                    <span>Outstanding</span>
                    <h4 class="mb-0 mt-1 text-danger">&#8358;{{ number_format($summary['total_outstanding'], 2) }}</h4>
                </div>
                <span class="badge bg-label-danger rounded p-2"><i class="ti ti-alert-triangle ti-sm"></i></span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body d-flex align-items-start justify-content-between">
                <div>
                    <span>Confirmed Paid</span>
                    <h4 class="mb-0 mt-1 text-success">&#8358;{{ number_format($summary['total_paid'], 2) }}</h4>
                </div>
                <span class="badge bg-label-success rounded p-2"><i class="ti ti-circle-check ti-sm"></i></span>
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Service Details</h5>
        <small class="text-muted">
            @if($planId)
                Showing: {{ $plans->firstWhere('id', $planId)?->hmo->name ?? '' }} — {{ $plans->firstWhere('id', $planId)?->name ?? '' }}
            @else
                Showing all plans
            @endif
        </small>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Patient</th>
                    <th>HMO Plan</th>
                    <th>Service</th>
                    <th>Qty</th>
                    <th>Amount (&#8358;)</th>
                    <th>Status</th>
                    <th>Clearance Code</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bills as $bill)
                <tr>
                    <td>{{ $bill->created_at->format('M d, Y') }}</td>
                    <td>{{ $bill->patient->user->firstname ?? 'N/A' }} {{ $bill->patient->user->lastname ?? '' }}</td>
                    <td>
                        <small class="text-muted">{{ $bill->hmoPlan->hmo->name ?? 'N/A' }}</small><br>
                        <strong>{{ $bill->hmoPlan->name ?? 'N/A' }}</strong>
                    </td>
                    <td>{{ $bill->service }}</td>
                    <td>{{ $bill->quantity }}</td>
                    <td class="fw-bold">{{ number_format($bill->amount, 2) }}</td>
                    <td>
                        @if($bill->status == 1)
                            <span class="badge bg-success">Paid</span>
                        @else
                            <span class="badge bg-warning">Unpaid</span>
                        @endif
                    </td>
                    <td><span class="text-info fw-bold">{{ $bill->clearance_code ?? 'N/A' }}</span></td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-4 text-muted">No HMO billing records found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $bills->links() }}</div>
</div>
@endsection
