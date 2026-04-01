@extends('layouts/layoutMaster')

@section('title', 'Patients')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">App /</span> Patients</h4>

<div class="card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">

        {{-- Filters --}}
        <form method="GET" action="{{ route('app.patients.index') }}" class="d-flex flex-wrap gap-2 align-items-center flex-grow-1">
            <input type="text" name="search" value="{{ $search }}"
                   class="form-control form-control-sm" style="width:200px" placeholder="Search patients...">

            <select name="gender" class="form-select form-select-sm" style="width:130px">
                <option value="">All Genders</option>
                <option value="Male"   {{ $filterGender === 'Male'   ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ $filterGender === 'Female' ? 'selected' : '' }}>Female</option>
            </select>

            <select name="tag_id" class="form-select form-select-sm" style="width:140px">
                <option value="">All Tags</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" {{ $filterTag == $tag->id ? 'selected' : '' }}>{{ $tag->name }}</option>
                @endforeach
            </select>

            <select name="age" class="form-select form-select-sm" style="width:120px">
                <option value="">All Ages</option>
                @for($i = 1; $i <= 100; $i++)
                    <option value="{{ $i }}" {{ $filterAge == $i ? 'selected' : '' }}>{{ $i }} yrs</option>
                @endfor
            </select>

            <button type="submit" class="btn btn-sm btn-primary">Filter</button>
            <a href="{{ route('app.patients.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
        </form>

        {{-- New Patient --}}
        <div class="btn-group">
            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                New Patient
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('app.patients.create') }}">Free Registration (Walk-in/HMO)</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="javascript:void(0);" id="new-patient-code">Paid Registration (Access Code)</a></li>
            </ul>
        </div>
    </div>

    {{-- Patient Cards --}}
    <div class="card-body">
        <div class="row g-4">
            @forelse($patients as $patient)
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="card card-figure is-hoverable h-100">
                    <figure class="figure">
                        <div class="figure-img d-flex justify-content-between" style="overflow:unset">
                            <a href="{{ route('app.patients.show', $patient->id) }}" class="user-avatar user-avatar-xl">
                                <img src="{{ asset($patient->gender == 'Male' ? 'assets/img/user-male-circle.png' : 'assets/img/user-female-circle.png') }}"
                                     alt="" class="{{ $patient->isCheckedInToday() ? 'checked-in' : '' }}">
                            </a>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('app.patients.show', $patient->id) }}">Open Profile</a>
                                    <a class="dropdown-item" href="{{ route('app.patients.edit', $patient->id) }}">Edit Profile</a>
                                    @if($patient->hasPendingCheckIn())
                                        <a class="dropdown-item text-warning" href="javascript:void(0);"
                                           onclick="requestClearanceCode({{ $patient->id }})">Enter Clearance Code</a>
                                    @else
                                        <a class="dropdown-item" href="{{ route('app.patient.checkIn', $patient->id) }}">Check In</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <figcaption class="figure-caption">
                            <h6 class="figure-title">
                                <a href="{{ route('app.patients.show', $patient->id) }}">
                                    {{ $patient->user->firstname }} {{ $patient->middlename }} {{ $patient->user->lastname }}
                                    [{{ app(App\Settings\SystemSettings::class)->number_prefix ?: 'HRN' }}{{ $patient->hospital_no }}]
                                </a>
                            </h6>
                            <p class="text-muted mb-0">{{ $patient->gender }}, {{ $patient->getAge() }}</p>
                            <p class="text-muted mb-0">{{ $patient->phone }}</p>
                            <p class="mb-0">
                                @if($patient->hmoPlan)
                                    <span class="badge bg-info">{{ $patient->hmoPlan->hmo->name ?? 'HMO' }} - {{ $patient->hmoPlan->name }}</span>
                                @else
                                    <span class="badge bg-dark">WALK-IN - Self Pay</span>
                                @endif
                            </p>
                        </figcaption>
                    </figure>
                </div>
            </div>
            @empty
            <div class="col-12 text-center text-muted py-5">
                <i class="ti ti-users ti-lg d-block mb-2"></i> No patients found.
            </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <small class="text-muted">
                Showing {{ $patients->firstItem() ?? 0 }} to {{ $patients->lastItem() ?? 0 }} of {{ $patients->total() }} patients
            </small>
            {{ $patients->links() }}
        </div>
    </div>
</div>

@include('_partials._modals.global-modal')
@endsection

@section('page-script')
<script>
function requestClearanceCode(patientId) {
    Swal.fire({
        title: 'Enter Clearance Code',
        input: 'text',
        inputPlaceholder: 'e.g. CHK-A3F9',
        showCancelButton: true,
        confirmButtonText: 'Submit Code',
        preConfirm: (code) => {
            if (!code) Swal.showValidationMessage('Please enter a clearance code');
            return code;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ url('/app/patient/check-in') }}/${patientId}/approve`;
            form.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <input type="hidden" name="clearance_code" value="${result.value}">`;
            document.body.appendChild(form);
            form.submit();
        }
    });
}

document.addEventListener('click', function(event) {
    if (event.target.id === 'new-patient-code') {
        Swal.fire({
            title: 'Provide Access Code',
            input: 'text',
            inputPlaceholder: 'e.g. OPC-123456',
            confirmButtonText: 'Get Access',
            showLoaderOnConfirm: true,
            preConfirm: async (accessCode) => {
                if (!accessCode) return Swal.showValidationMessage('Please enter an access code');
                try {
                    const res = await fetch(`{{ url('/api/billservices/0/create') }}/${encodeURIComponent(accessCode)}`);
                    const result = await res.json();
                    if (result.success) return result;
                    return Swal.showValidationMessage(`Error: ${result.message}`);
                } catch (e) {
                    Swal.showValidationMessage(`Request failed: ${e}`);
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                const encryptedData = btoa(JSON.stringify(result.value.data));
                window.location.href = `{{ route('app.patients.create') }}?data=${encodeURIComponent(encryptedData)}`;
            }
        });
    }
});
</script>
@endsection
