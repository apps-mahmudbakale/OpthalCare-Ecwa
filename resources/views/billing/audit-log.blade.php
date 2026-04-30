@extends('layouts/layoutMaster')

@section('title', 'Billing Audit Log')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Billing /</span> Audit Log</h4>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Billing Activity Tracking</h5>
        <small class="text-muted">Track who created billing records</small>
    </div>
    
    <div class="card-body">
        <!-- Filters -->
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <label class="form-label">Staff Member</label>
                <select name="user_id" class="form-select">
                    <option value="">All Staff</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->firstname }} {{ $user->lastname }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-2">
                <label class="form-label">Source</label>
                <select name="created_from" class="form-select">
                    <option value="">All Sources</option>
                    <option value="manual_billing" {{ request('created_from') == 'manual_billing' ? 'selected' : '' }}>Manual Billing</option>
                    <option value="auto" {{ request('created_from') == 'auto' ? 'selected' : '' }}>Automatic</option>
                    <option value="api" {{ request('created_from') == 'api' ? 'selected' : '' }}>API</option>
                </select>
            </div>
            
            <div class="col-md-2">
                <label class="form-label">From Date</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            
            <div class="col-md-2">
                <label class="form-label">To Date</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">Filter</button>
                <a href="{{ route('app.billing.audit-log') }}" class="btn btn-outline-secondary">Clear</a>
            </div>
        </form>

        <!-- Audit Log Table -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date/Time</th>
                        <th>Staff Member</th>
                        <th>Patient</th>
                        <th>Service</th>
                        <th>Amount</th>
                        <th>Source</th>
                        <th>IP Address</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($billings as $billing)
                        <tr>
                            <td>
                                <small>{{ $billing->created_at->format('M d, Y') }}</small><br>
                                <small class="text-muted">{{ $billing->created_at->format('h:i A') }}</small>
                            </td>
                            <td>
                                @if($billing->createdBy)
                                    <strong>{{ $billing->createdBy->firstname }} {{ $billing->createdBy->lastname }}</strong><br>
                                    <small class="text-muted">{{ $billing->createdBy->email }}</small>
                                @else
                                    <span class="text-muted">Unknown</span>
                                @endif
                            </td>
                            <td>
                                @if($billing->patient && $billing->patient->user)
                                    <strong>{{ $billing->patient->user->firstname }} {{ $billing->patient->user->lastname }}</strong><br>
                                    <small class="text-muted">{{ $billing->patient->hospital_no }}</small>
                                @else
                                    <span class="text-muted">Unknown Patient</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $billing->service }}</strong><br>
                                <small class="text-muted">Ref: {{ $billing->bill_ref }}</small>
                            </td>
                            <td>
                                <strong>₦{{ number_format($billing->amount, 2) }}</strong><br>
                                <span class="badge bg-{{ $billing->status ? 'success' : 'warning' }}">
                                    {{ $billing->status ? 'Paid' : 'Unpaid' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $billing->created_from ?? 'manual')) }}</span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $billing->created_ip ?? 'N/A' }}</small>
                            </td>
                            <td>
                                @if($billing->creation_notes)
                                    <small>{{ Str::limit($billing->creation_notes, 50) }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                No billing activities found for the selected criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $billings->withQueryString()->links() }}
        </div>
    </div>
</div>

@endsection