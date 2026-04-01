@extends('layouts/layoutMaster')
@section('title', 'Procedure Requests')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection
@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">App /</span> Procedure Requests</h4>

<div class="card">
    <div class="card-header border-bottom">
        <form method="GET" action="{{ route('app.procedure-requests.index') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small mb-1">Patient</label>
                <select name="patient_id" class="form-select form-select-sm">
                    <option value="">All Patients</option>
                    @foreach($patients as $p)
                        <option value="{{ $p->id }}" {{ $patientId == $p->id ? 'selected' : '' }}>
                            {{ $p->user->firstname }} {{ $p->user->lastname }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Category</label>
                <select name="category_id" class="form-select form-select-sm">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
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
                <a href="{{ route('app.procedure-requests.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Patient</th>
                    <th>Procedure</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $req)
                @php
                    $badges = ['Pending'=>'bg-label-warning','In Progress'=>'bg-label-info','Completed'=>'bg-label-success','Cancelled'=>'bg-label-danger'];
                @endphp
                <tr>
                    <td>{{ $req->created_at->format('d M Y') }}</td>
                    <td>
                        @if($req->patient)
                            <a href="{{ route('app.patients.show', $req->patient->id) }}">
                                {{ $req->patient->user->firstname ?? '' }} {{ $req->patient->user->lastname ?? '' }}
                            </a>
                        @else N/A @endif
                    </td>
                    <td>{{ $req->procedure->name ?? 'N/A' }}</td>
                    <td>{{ $req->procedure->category->name ?? 'N/A' }}</td>
                    <td><span class="badge {{ $badges[$req->status] ?? 'bg-label-secondary' }}">{{ $req->status }}</span></td>
                    <td class="text-center">
                        <a href="{{ route('app.procedure-requests.show', $req->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="ti ti-eye me-1"></i> View
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-5 text-muted">No procedure requests found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $requests->links() }}</div>
</div>
@endsection
