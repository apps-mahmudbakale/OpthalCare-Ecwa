<div>
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">HMO /</span> Outstanding Bills</h4>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Filter by HMO Provider</label>
                    <select wire:model="selectedHmoId" class="form-select">
                        <option value="">All Providers</option>
                        @foreach($hmoGroups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Search Patient or Service</label>
                    <input type="text" wire:model="search" class="form-control" placeholder="Type to search...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Clearance Code (Optional)</label>
                    <input type="text" wire:model.defer="clearanceCode" class="form-control mb-2" placeholder="Enter Authorization Code">
                    <button class="btn btn-success w-100" onclick="confirmSettlement()" wire:loading.attr="disabled" @if(empty($selectedBills)) disabled @endif>
                        <i class="ti ti-check me-1"></i> Settle Selected ({{ count($selectedBills) }})
                    </button>
                    <div wire:loading wire:target="settleSelected" class="mt-1 small text-success">
                        <span class="spinner-border spinner-border-sm me-1"></span> Processing Settlement...
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 40px;">
                            <input type="checkbox" wire:model="selectAll" class="form-check-input">
                        </th>
                        <th>Date</th>
                        <th>Patient</th>
                        <th>HMO Provider / Plan</th>
                        <th>Service</th>
                        <th>Amount</th>
                        <th>Clearance Code</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($bills as $bill)
                        <tr wire:key="billing-row-{{ $bill->id }}">
                            <td>
                                <input type="checkbox" wire:model="selectedBills" value="{{ $bill->id }}" class="form-check-input">
                            </td>
                            <td>{{ $bill->created_at->format('M d, Y') }}</td>
                            <td>
                                <strong>{{ $bill->patient->user->firstname ?? 'N/A' }} {{ $bill->patient->user->lastname ?? '' }}</strong>
                                <br><small class="text-muted">HRN: {{ $bill->patient->hospital_no }}</small>
                            </td>
                            <td>
                                <span class="text-primary">{{ $bill->hmoPlan->hmo->name ?? 'N/A' }}</span><br>
                                <small>{{ $bill->hmoPlan->name ?? 'N/A' }}</small>
                            </td>
                            <td>{{ $bill->service }}</td>
                            <td><strong>₦{{ number_format($bill->amount, 2) }}</strong></td>
                            <td>
                                <input type="text" wire:model.defer="serviceClearanceCodes.{{ $bill->id }}" 
                                       class="form-control form-control-sm" 
                                       placeholder="Code" 
                                       style="width: 120px;">
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No outstanding HMO bills found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $bills->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.livewire.on('swal', (data) => {
                Swal.fire({
                    icon: data.type,
                    title: data.type === 'error' ? 'Oops...' : 'Success',
                    text: data.message,
                });
            });

            window.confirmSettlement = () => {
                Swal.fire({
                    title: 'Confirm Settlement',
                    text: "Are you sure you want to settle the selected bills using the HMO wallet?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, settle them!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.settleSelected();
                    }
                });
            }
        });
    </script>
</div>
