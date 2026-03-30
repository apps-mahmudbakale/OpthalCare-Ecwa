@extends('layouts/layoutMaster')

@section('title', 'Admissions')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Hospital /</span> Admissions</h4>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card text-center h-100">
            <div class="card-body py-3">
                <div class="badge rounded-pill bg-label-primary p-2 mb-2"><i class="ti ti-bed ti-sm"></i></div>
                <h4 class="mb-0">{{ $activeCount }}</h4>
                <small class="text-muted">Active</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center h-100">
            <div class="card-body py-3">
                <div class="badge rounded-pill bg-label-success p-2 mb-2"><i class="ti ti-logout ti-sm"></i></div>
                <h4 class="mb-0">{{ $dischargedCount }}</h4>
                <small class="text-muted">Discharged</small>
            </div>
        </div>
    </div>
</div>

<div class="card">
    {{-- Tabs --}}
    <div class="card-header pb-0">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a href="{{ request()->fullUrlWithQuery(['tab' => 'active', 'page' => 1]) }}"
                   class="nav-link {{ $tab === 'active' ? 'active' : '' }}">
                    <i class="ti ti-bed me-1"></i> Active
                    <span class="badge bg-primary ms-1">{{ $activeCount }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ request()->fullUrlWithQuery(['tab' => 'discharged', 'page' => 1]) }}"
                   class="nav-link {{ $tab === 'discharged' ? 'active' : '' }}">
                    <i class="ti ti-logout me-1"></i> Discharged
                    <span class="badge bg-success ms-1">{{ $dischargedCount }}</span>
                </a>
            </li>
        </ul>
    </div>

    {{-- Filters --}}
    <div class="card-header border-bottom">
        <form method="GET" action="{{ route('app.admissions.index') }}" class="row g-2 align-items-end">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <div class="col-12 col-md-4">
                <label class="form-label small mb-1">Search Patient</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text"><i class="ti ti-search"></i></span>
                    <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="First or last name...">
                </div>
            </div>
            <div class="col-6 col-md-3">
                <label class="form-label small mb-1">Ward</label>
                <select name="ward_id" class="form-select form-select-sm">
                    <option value="">All Wards</option>
                    @foreach($wards as $ward)
                        <option value="{{ $ward->id }}" {{ $ward_id == $ward->id ? 'selected' : '' }}>{{ $ward->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-3">
                <label class="form-label small mb-1">Patient</label>
                <select name="patient_id" class="form-select form-select-sm">
                    <option value="">All Patients</option>
                    @foreach($patients as $p)
                        <option value="{{ $p->id }}" {{ $patient_id == $p->id ? 'selected' : '' }}>
                            {{ $p->user->firstname }} {{ $p->user->lastname }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-2 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-primary w-100">Filter</button>
                <a href="{{ route('app.admissions.index', ['tab' => $tab]) }}" class="btn btn-sm btn-outline-secondary w-100">Clear</a>
            </div>
        </form>
    </div>

    {{-- Active Table --}}
    @if($tab === 'active')
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="min-width:180px">Patient</th>
                    <th style="min-width:140px">Ward</th>
                    <th style="min-width:80px">Bed</th>
                    <th style="min-width:110px">Admitted</th>
                    <th style="min-width:90px">Status</th>
                    <th style="min-width:80px" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admissions as $admission)
                @php
                    $badges = ['pending'=>'bg-label-warning','prepared'=>'bg-label-info','billed'=>'bg-label-primary','active'=>'bg-label-success'];
                    $badge = $badges[$admission->status] ?? 'bg-label-secondary';
                @endphp
                <tr>
                    <td>
                        <span class="fw-semibold">{{ $admission->patient->user->firstname ?? '' }} {{ $admission->patient->user->lastname ?? '' }}</span>
                        <br><small class="text-muted">{{ $admission->patient->hospital_no ?? '' }}</small>
                    </td>
                    <td>{{ $admission->ward->name ?? 'N/A' }}</td>
                    <td>{{ $admission->bed->name ?? 'N/A' }}</td>
                    <td>{{ $admission->created_at->format('d M Y') }}</td>
                    <td><span class="badge {{ $badge }}">{{ ucfirst($admission->status) }}</span></td>
                    <td class="text-center">
                        <a href="{{ route('app.admissions.show', $admission->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="ti ti-eye me-1"></i> View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="ti ti-inbox ti-lg d-block mb-2"></i> No active admissions found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif

    {{-- Discharged Table --}}
    @if($tab === 'discharged')
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="min-width:180px">Patient</th>
                    <th style="min-width:140px">Ward</th>
                    <th style="min-width:80px">Bed</th>
                    <th style="min-width:110px">Admitted</th>
                    <th style="min-width:110px">Discharged On</th>
                    <th style="min-width:80px" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admissions as $admission)
                <tr>
                    <td>
                        <span class="fw-semibold">{{ $admission->patient->user->firstname ?? '' }} {{ $admission->patient->user->lastname ?? '' }}</span>
                        <br><small class="text-muted">{{ $admission->patient->hospital_no ?? '' }}</small>
                    </td>
                    <td>{{ $admission->ward->name ?? 'N/A' }}</td>
                    <td>{{ $admission->bed->name ?? 'N/A' }}</td>
                    <td>{{ $admission->created_at->format('d M Y') }}</td>
                    <td>{{ $admission->discharged_at ? \Carbon\Carbon::parse($admission->discharged_at)->format('d M Y') : 'N/A' }}</td>
                    <td class="text-center">
                        <a href="{{ route('app.admissions.show', $admission->id) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="ti ti-eye me-1"></i> View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="ti ti-inbox ti-lg d-block mb-2"></i> No discharged admissions found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif

    <div class="card-footer">
        {{ $admissions->links() }}
    </div>
</div>
@endsection
