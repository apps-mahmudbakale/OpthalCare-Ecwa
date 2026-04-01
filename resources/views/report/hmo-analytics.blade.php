@extends('layouts.layoutMaster')
@section('title', 'HMO Analytics')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Reports /</span> HMO Analytics & Debt Report</h4>

{{-- Filter --}}
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('app.reports.hmo') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Filter by HMO Group</label>
                <select name="hmo_id" class="form-select">
                    <option value="">All HMO Groups</option>
                    @foreach($hmoGroups as $group)
                        <option value="{{ $group->id }}" {{ $hmoId == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
                <a href="{{ route('app.reports.hmo') }}" class="btn btn-outline-secondary w-100">Clear</a>
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
                    <span>Total Enrollees</span>
                    <h4 class="mb-0 mt-1">{{ number_format($totals['enrollees']) }}</h4>
                    <small class="text-muted">Across filtered plans</small>
                </div>
                <span class="badge bg-label-primary rounded p-2"><i class="ti ti-users ti-sm"></i></span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body d-flex align-items-start justify-content-between">
                <div>
                    <span>Total Billed</span>
                    <h4 class="mb-0 mt-1">&#8358;{{ number_format($totals['billed'], 2) }}</h4>
                    <small class="text-muted">All services</small>
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
                    <h4 class="mb-0 mt-1 text-danger">&#8358;{{ number_format($totals['outstanding'], 2) }}</h4>
                    <small class="text-muted">Unpaid balance</small>
                </div>
                <span class="badge bg-label-danger rounded p-2"><i class="ti ti-alert-triangle ti-sm"></i></span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body d-flex align-items-start justify-content-between">
                <div>
                    <span>Total Paid</span>
                    <h4 class="mb-0 mt-1 text-success">&#8358;{{ number_format($totals['paid'], 2) }}</h4>
                    <small class="text-muted">Settled bills</small>
                </div>
                <span class="badge bg-label-success rounded p-2"><i class="ti ti-circle-check ti-sm"></i></span>
            </div>
        </div>
    </div>
</div>

{{-- Plans Table --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">HMO Plans Breakdown</h5>
        <a href="{{ route('app.reports.hmo-reconciliation') }}" class="btn btn-sm btn-outline-primary">
            <i class="ti ti-file-analytics me-1"></i> Reconciliation Report
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>HMO Group</th>
                    <th>Plan Name</th>
                    <th>Enrollees</th>
                    <th>Services</th>
                    <th>Total Billed (&#8358;)</th>
                    <th>Outstanding (&#8358;)</th>
                    <th>Paid (&#8358;)</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($hmoPlans as $plan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $plan->hmo->name ?? 'N/A' }}</strong></td>
                    <td>
                        {{ $plan->name }}
                        @if($plan->is_insurance)
                            <span class="badge bg-label-success ms-1">Insured</span>
                        @endif
                    </td>
                    <td><span class="badge bg-label-primary">{{ $plan->enrollees_count }}</span></td>
                    <td>{{ $plan->services_enjoyed_count }}</td>
                    <td class="fw-bold">{{ number_format($plan->total_billed ?? 0, 2) }}</td>
                    <td class="fw-bold {{ ($plan->outstanding_balance ?? 0) > 0 ? 'text-danger' : 'text-success' }}">
                        {{ number_format($plan->outstanding_balance ?? 0, 2) }}
                    </td>
                    <td class="text-success">{{ number_format($plan->total_paid ?? 0, 2) }}</td>
                    <td>
                        <a href="{{ route('app.reports.hmo-reconciliation', ['plan_id' => $plan->id]) }}"
                           class="btn btn-sm btn-outline-secondary" title="View reconciliation for this plan">
                            <i class="ti ti-eye ti-xs"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center py-4 text-muted">No HMO plans found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
