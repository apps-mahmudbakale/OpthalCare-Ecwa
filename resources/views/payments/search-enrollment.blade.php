@extends('layouts/layoutMaster')

@section('title', 'Reprint Enrollment Receipts')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Payments /</span> Reprint Enrollment Receipts</h4>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Search Paid Enrollments</h5>
    </div>
    <div class="card-body">
        <!-- Search Form -->
        <form method="GET" action="{{ route('app.payments.search-enrollment') }}" class="mb-4">
            <div class="row g-3">
                <div class="col-md-8">
                    <input type="text" 
                           name="search" 
                           value="{{ $search }}" 
                           class="form-control" 
                           placeholder="Search by name, access code, or phone...">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="ti ti-search me-1"></i> Search
                    </button>
                    <a href="{{ route('app.payments.search-enrollment') }}" class="btn btn-outline-secondary">
                        <i class="ti ti-x me-1"></i> Clear
                    </a>
                </div>
            </div>
        </form>

        <!-- Results Info -->
        @if($enrollments->total() > 0)
        <div class="alert alert-info">
            <i class="ti ti-info-circle me-1"></i>
            Showing {{ $enrollments->firstItem() }} to {{ $enrollments->lastItem() }} of {{ $enrollments->total() }} paid enrollments
        </div>
        @endif

        <!-- Enrollments Table -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Access Code</th>
                        <th>Enrollment Date</th>
                        <th>Amount Paid</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enrollments as $enrollment)
                    <tr>
                        <td>
                            <strong>{{ $enrollment->first_name }} {{ $enrollment->middle_name ?? '' }} {{ $enrollment->last_name }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-label-primary">{{ $enrollment->accesscode }}</span>
                        </td>
                        <td>{{ $enrollment->created_at->format('M d, Y g:i A') }}</td>
                        <td>&#8358;{{ number_format($enrollment->billing->amount ?? 0, 2) }}</td>
                        <td class="text-center">
                            <a href="{{ route('app.payments.reprint-enrollment', $enrollment->id) }}" 
                               target="_blank"
                               class="btn btn-sm btn-primary">
                                <i class="ti ti-printer me-1"></i> Reprint Receipt
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <i class="ti ti-file-search ti-lg text-muted mb-2 d-block"></i>
                            <p class="text-muted mb-0">
                                @if($search)
                                    No enrollments found matching "{{ $search }}"
                                @else
                                    No paid enrollments found. Start searching to find enrollment receipts.
                                @endif
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($enrollments->hasPages())
        <div class="mt-3 d-flex justify-content-center">
            {{ $enrollments->appends(['search' => $search])->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
