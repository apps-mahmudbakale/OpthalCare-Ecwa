<div>
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Reports /</span> HMO Analytics & Debt Report</h4>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">HMO Plans Overview</h5>
            <div>
                <!-- Future export buttons can go here -->
            </div>
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
                            <th>Services Enjoyed</th>
                            <th>Total Debt Billed (&#8358;)</th>
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
                                <td class="fw-bold {{ $plan->total_debt > 0 ? 'text-danger' : 'text-success' }}">
                                    {{ number_format($plan->total_debt, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No HMO Plans Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
