@extends('layouts/layoutMaster')
@section('title', 'Billings')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection
@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">App /</span> Billings</h4>

<div class="card">
    <div class="card-header border-bottom">
        <form method="GET" action="{{ route('app.billing.index') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small mb-1">Search Service</label>
                <input type="text" name="search" value="{{ $search }}" class="form-control form-control-sm" placeholder="Service name...">
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Unpaid (default)</option>
                    <option value="0" {{ $status === 0 ? 'selected' : '' }}>Unpaid</option>
                    <option value="1" {{ $status === 1 ? 'selected' : '' }}>Paid</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">From</label>
                <input type="date" name="date_from" value="{{ $dateFrom }}" class="form-control form-control-sm">
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">To</label>
                <input type="date" name="date_to" value="{{ $dateTo }}" class="form-control form-control-sm">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                <a href="{{ route('app.billing.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Patient</th>
                    <th>Service</th>
                    <th>Amount (₦)</th>
                    <th>Status</th>
                    <th>Ref</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($billings as $bill)
                <tr>
                    <td>{{ $bill->created_at->format('d M Y') }}</td>
                    <td>
                        @if($bill->patient)
                            <a href="{{ route('app.patients.show', $bill->patient->id) }}">
                                {{ $bill->patient->user->firstname ?? '' }} {{ $bill->patient->user->lastname ?? '' }}
                            </a>
                        @else N/A @endif
                    </td>
                    <td>{{ $bill->service }}</td>
                    <td class="fw-bold">{{ number_format($bill->amount, 2) }}</td>
                    <td>
                        @if($bill->status == 1)
                            <span class="badge bg-success">Paid</span>
                        @else
                            <span class="badge bg-warning">Unpaid</span>
                        @endif
                    </td>
                    <td><small class="text-muted">{{ $bill->bill_ref }}</small></td>
                    <td class="text-center">
                        <a href="{{ route('app.billing.show', $bill->bill_ref) }}" class="btn btn-sm btn-outline-primary">
                            <i class="ti ti-eye ti-xs"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-5 text-muted">No billing records found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $billings->links() }}</div>
</div>
@endsection
