@extends('layouts.layoutMaster')

@section('title', 'Wallet History — {{ $hmo->name }}')

@section('content')
<div>
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">HMO / <a href="{{ route('app.hmo.finance') }}">Finance</a> /</span>
        {{ $hmo->name }} — Transaction History
    </h4>

    @php $balance = $hmo->wallet->balance ?? 0; @endphp
    <div class="alert {{ $balance < 0 ? 'alert-danger' : 'alert-success' }} mb-4">
        Current Wallet Balance:
        <strong>₦{{ number_format($balance, 2) }}</strong>
        @if($balance < 0) — <em>Outstanding debt, will be cleared on next funding.</em> @endif
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Transactions</h5>
            <a href="{{ route('app.hmo.finance') }}" class="btn btn-sm btn-outline-secondary">
                <i class="ti ti-arrow-left me-1"></i> Back
            </a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Reference</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $tx)
                        <tr>
                            <td>{{ $tx->created_at->format('d M, Y H:i') }}</td>
                            <td>
                                @if($tx->type === 'credit')
                                    <span class="badge bg-label-success">Credit</span>
                                @else
                                    <span class="badge bg-label-danger">Debit</span>
                                @endif
                            </td>
                            <td class="fw-bold">₦{{ number_format($tx->amount, 2) }}</td>
                            <td>{{ $tx->description }}</td>
                            <td><small class="text-muted">{{ $tx->reference ?? '-' }}</small></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">No transactions found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">{{ $transactions->links() }}</div>
    </div>
</div>
@endsection
