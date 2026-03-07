<div>
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Reports /</span> HMO Analytics & Debt Report</h4>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Total Enrollees</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ number_format($totals['enrollees']) }}</h4>
                            </div>
                            <small>Across all plans</small>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="ti ti-users ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Total Billed</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">&#8358;{{ number_format($totals['billed'], 2) }}</h4>
                            </div>
                            <small>All services</small>
                        </div>
                        <span class="badge bg-label-info rounded p-2">
                            <i class="ti ti-file-invoice ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Outstanding</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2 text-danger">&#8358;{{ number_format($totals['outstanding'], 2) }}</h4>
                            </div>
                            <small>Unpaid balance</small>
                        </div>
                        <span class="badge bg-label-danger rounded p-2">
                            <i class="ti ti-alert-triangle ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Total Paid</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2 text-success">&#8358;{{ number_format($totals['paid'], 2) }}</h4>
                            </div>
                            <small>Settled bills</small>
                        </div>
                        <span class="badge bg-label-success rounded p-2">
                            <i class="ti ti-circle-check ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Plans Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">HMO Plans Breakdown</h5>
            <a href="{{ route('app.reports.hmo-reconciliation') }}" class="btn btn-sm btn-outline-primary">
                <i class="ti ti-file-analytics me-1"></i> Reconciliation Report
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>HMO Group</th>
                            <th>Plan Name</th>
                            <th>Enrollees</th>
                            <th>Services</th>
                            <th>Total Billed (&#8358;)</th>
                            <th>Outstanding (&#8358;)</th>
                            <th>Paid (&#8358;)</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($hmoPlans as $plan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $plan->hmo->name ?? 'N/A' }}</strong>
                                </td>
                                <td>{{ $plan->name }}
                                    @if($plan->is_insurance)
                                        <span class="badge bg-label-success ms-1">Insured</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-label-primary">{{ $plan->enrollees_count }}</span>
                                </td>
                                <td>{{ $plan->services_enjoyed_count }}</td>
                                <td class="fw-bold">{{ number_format($plan->total_billed ?? 0, 2) }}</td>
                                <td class="fw-bold {{ ($plan->outstanding_balance ?? 0) > 0 ? 'text-danger' : 'text-success' }}">
                                    {{ number_format($plan->outstanding_balance ?? 0, 2) }}
                                </td>
                                <td class="text-success">{{ number_format($plan->total_paid ?? 0, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No HMO Plans Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
