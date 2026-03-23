@extends('layouts.layoutMaster')

@section('title', 'HMO Outstanding Bills')

@section('content')
<div>
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">HMO /</span> Outstanding Bills</h4>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(isset($selectedHmo) && $selectedHmo)
        @php $walletBalance = $selectedHmo->wallet->balance ?? 0; @endphp
        <div class="alert {{ $walletBalance < 0 ? 'alert-danger' : 'alert-info' }} mb-3">
            <i class="ti ti-wallet me-1"></i>
            <strong>{{ $selectedHmo->name }}</strong> wallet balance:
            <strong>₦{{ number_format($walletBalance, 2) }}</strong>
            @if($walletBalance < 0)
                — <em>Currently overdrawn. Outstanding will be deducted from next funding.</em>
            @endif
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('app.hmo.billing') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Filter by HMO Provider</label>
                        <select name="hmo_id" class="form-select" onchange="this.form.submit()">
                            <option value="">All Providers</option>
                            @foreach($hmoGroups as $group)
                                <option value="{{ $group->id }}" {{ $selectedHmoId == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Search Patient or Service</label>
                        <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Type to search...">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary w-100">Search</button>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-success w-100" onclick="confirmSettlement()" id="settleSelectedBtn" disabled>
                            <i class="ti ti-check me-1"></i> Settle Selected (<span id="selectedCount">0</span>)
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 40px;">
                            <input type="checkbox" id="selectAll" class="form-check-input">
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
                        <tr>
                            <td>
                                <input type="checkbox" name="selectedBills" value="{{ $bill->id }}" class="form-check-input bill-checkbox">
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
                                <input type="text" name="clearance_codes[{{ $bill->id }}]" 
                                       class="form-control form-control-sm item-clearance-code" 
                                       placeholder="Code" 
                                       style="width: 120px;">
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No outstanding HMO bills found.</td>
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

@section('page-script')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectAllCheckbox = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.bill-checkbox');
        const settleBtn = document.getElementById('settleSelectedBtn');
        const selectedCountSpan = document.getElementById('selectedCount');

        function updateUI() {
            const selectedCount = document.querySelectorAll('.bill-checkbox:checked').length;
            selectedCountSpan.innerText = selectedCount;
            settleBtn.disabled = selectedCount === 0;
            selectAllCheckbox.checked = checkboxes.length > 0 && selectedCount === checkboxes.length;
        }

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', (e) => {
                checkboxes.forEach(cb => {
                    cb.checked = e.target.checked;
                });
                updateUI();
            });
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateUI);
        });

        window.confirmSettlement = () => {
            const selectedCheckboxes = document.querySelectorAll('.bill-checkbox:checked');
            const billIds = Array.from(selectedCheckboxes).map(cb => cb.value);

            if (billIds.length === 0) {
                Swal.fire('Error', 'No bills selected.', 'error');
                return;
            }

            Swal.fire({
                title: 'Confirm Bulk Settlement',
                text: `Are you sure you want to settle ${billIds.length} selected bills using the HMO wallet?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, settle them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    processSettlement(billIds);
                }
            });
        }

        function processSettlement(billIds) {
            const clearanceCodes = {};
            billIds.forEach(id => {
                const input = document.querySelector(`input[name="clearance_codes[${id}]"]`);
                if (input && input.value) {
                    clearanceCodes[id] = input.value;
                }
            });


            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while we process the settlement.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "{{ route('app.hmo-billing.settle') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    bill_ids: billIds,
                    clearance_codes: clearanceCodes
                },
                success: function(response) {
                    const icon = response.overdrawn ? 'warning' : 'success';
                    Swal.fire(response.overdrawn ? 'Settled (Overdrawn)' : 'Success', response.message, icon).then(() => {
                        location.reload(); 
                    });
                },
                error: function(xhr) {
                    let message = 'An error occurred processing the settlement.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    Swal.fire('Error', message, 'error');
                }
            });
        }
    });
</script>
@endsection
@endsection
