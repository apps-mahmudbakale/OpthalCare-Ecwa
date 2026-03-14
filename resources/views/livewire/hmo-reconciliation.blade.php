<div>
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Reports /</span> HMO Reconciliation</h4>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">HMO Plan</label>
                    <select wire:model="planId" class="form-select">
                        <option value="">All Plans</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}">{{ $plan->hmo->name ?? 'N/A' }} - {{ $plan->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">From Date</label>
                    <input type="date" wire:model="dateFrom" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">To Date</label>
                    <input type="date" wire:model="dateTo" class="form-control">
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button wire:click="$set('planId', ''); $set('dateFrom', ''); $set('dateTo', '')" class="btn btn-outline-secondary w-50" title="Reset Filters">
                        <i class="ti ti-refresh"></i>
                    </button>
                    <button wire:click="export" class="btn btn-success w-50" title="Export to Excel">
                        <i class="ti ti-file-spreadsheet"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <span>Total Services</span>
                            <h4 class="mb-0 mt-1">{{ number_format($summary['total_services']) }}</h4>
                        </div>
                        <span class="badge bg-label-primary rounded p-2"><i class="ti ti-list ti-sm"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <span>Total Billed</span>
                            <h4 class="mb-0 mt-1">&#8358;{{ number_format($summary['total_billed'], 2) }}</h4>
                        </div>
                        <span class="badge bg-label-info rounded p-2"><i class="ti ti-file-invoice ti-sm"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <span>Outstanding</span>
                            <h4 class="mb-0 mt-1 text-danger">&#8358;{{ number_format($summary['total_outstanding'], 2) }}</h4>
                        </div>
                        <span class="badge bg-label-danger rounded p-2"><i class="ti ti-alert-triangle ti-sm"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <span>Confirmed Paid</span>
                            <h4 class="mb-0 mt-1 text-success">&#8358;{{ number_format($summary['total_paid'], 2) }}</h4>
                        </div>
                        <span class="badge bg-label-success rounded p-2"><i class="ti ti-circle-check ti-sm"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Billing Details Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Service Details</h5>
            <small class="text-muted">Filter by plan and dates for reconciliation</small>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover table-striped">
                <thead>
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
                <tbody class="table-border-bottom-0">
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
                        <td>
                            <span class="text-info fw-bold">{{ $bill->clearance_code ?? 'N/A' }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No HMO billing records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $bills->links() }}
        </div>
    </div>
</div>
