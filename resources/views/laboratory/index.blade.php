@extends('layouts/layoutMaster')
@section('title', 'Laboratory')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection
@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">App /</span> Laboratory Requests</h4>

<div class="card">
    <div class="card-header border-bottom">
        <form method="GET" action="{{ route('app.lab.index') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small mb-1">Search Patient / Test</label>
                <input type="text" name="search" value="{{ $search }}" class="form-control form-control-sm" placeholder="Name or test...">
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    <option value="Pending"            {{ $status === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Specimen Collected" {{ $status === 'Specimen Collected' ? 'selected' : '' }}>Specimen Collected</option>
                    <option value="Result Ready"       {{ $status === 'Result Ready' ? 'selected' : '' }}>Result Ready</option>
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
                <a href="{{ route('app.lab.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Patient</th>
                    <th>Test</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($labRequests as $req)
                @php
                    $badges = ['Pending'=>'bg-label-warning','Specimen Collected'=>'bg-label-info','Result Ready'=>'bg-label-success'];
                @endphp
                <tr>
                    <td>{{ $req->created_at->format('d M Y') }}<br><small class="text-muted">{{ $req->created_at->format('h:i A') }}</small></td>
                    <td>
                        @if($req->patient)
                            <a href="{{ route('app.patients.show', $req->patient->id) }}">
                                {{ $req->patient->user->firstname ?? '' }} {{ $req->patient->user->lastname ?? '' }}
                            </a>
                        @else N/A @endif
                    </td>
                    <td>{{ $req->test->name ?? 'N/A' }}</td>
                    <td>{{ $req->priority ?? '-' }}</td>
                    <td><span class="badge {{ $badges[$req->status] ?? 'bg-label-secondary' }}">{{ $req->status }}</span></td>
                    <td class="text-center">
                        <div class="btn-group">
                            @if($req->status === 'Pending')
                                <a href="{{ route('app.lab.specimen', $req->id) }}" class="btn btn-sm btn-outline-info" title="Collect Specimen">
                                    <i class="ti ti-test-pipe ti-xs"></i>
                                </a>
                            @endif
                            @if($req->status === 'Specimen Collected')
                                <a href="{{ route('app.lab.show', $req->id) }}" class="btn btn-sm btn-outline-primary" title="Add Result">
                                    <i class="ti ti-edit ti-xs"></i>
                                </a>
                            @endif
                            @if($req->status === 'Result Ready')
                                <a href="{{ route('app.lab.print.result', $req->id) }}" target="_blank" class="btn btn-sm btn-outline-success" title="Print Result">
                                    <i class="ti ti-printer ti-xs"></i>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-5 text-muted">No lab requests found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $labRequests->links() }}</div>
</div>
@endsection
