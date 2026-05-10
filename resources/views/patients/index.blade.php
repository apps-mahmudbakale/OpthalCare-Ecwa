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
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="fw-bold py-3 mb-1"><span class="text-muted fw-light">App /</span> Patients</h4>
        <p class="text-muted mb-0">Walk-in patients are excluded by default. Use the filter to view walk-in patients specifically.</p>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <form method="GET" action="{{ route('app.patients.index') }}" class="d-flex flex-wrap gap-2 align-items-end flex-grow-1">
            <input type="text" name="search" value="{{ $search }}" class="form-control form-control-sm" placeholder="Search name, HRN, phone..." style="width:200px;">

            <select name="patient_type" class="form-select form-select-sm" style="width:150px;">
                <option value="">Registered (Default)</option>
                <option value="registered" {{ $filterType === 'registered' ? 'selected' : '' }}>Registered Only</option>
                <option value="walkin" {{ $filterType === 'walkin' ? 'selected' : '' }}>Walk-in Only</option>
            </select>

            <select name="gender" class="form-select form-select-sm" style="width:130px;">
                <option value="">All Genders</option>
                <option value="Male"   {{ $filterGender === 'Male'   ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ $filterGender === 'Female' ? 'selected' : '' }}>Female</option>
            </select>

            <select name="tag" class="form-select form-select-sm" style="width:130px;">
                <option value="">All Tags</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" {{ $filterTag == $tag->id ? 'selected' : '' }}>{{ $tag->name }}</option>
                @endforeach
            </select>

            <select name="hmo_plan_id" class="form-select form-select-sm" style="width:180px;">
                <option value="">All Plans</option>
                @foreach($hmoPlans as $plan)
                    <option value="{{ $plan->id }}" {{ $filterHmo == $plan->id ? 'selected' : '' }}>
                        {{ $plan->hmo->name ?? '' }} — {{ $plan->name }}
                    </option>
                @endforeach
            </select>

            <select name="age" class="form-select form-select-sm" style="width:110px;">
                <option value="">All Ages</option>
                @for($i = 1; $i <= 100; $i++)
                    <option value="{{ $i }}" {{ $filterAge == $i ? 'selected' : '' }}>{{ $i }} yrs</option>
                @endfor
            </select>

            <button type="submit" class="btn btn-sm btn-primary">Filter</button>
            <a href="{{ route('app.patients.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
        </form>

        <div class="btn-group">
            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                New Patient
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('app.patients.create', ['type' => 'registered']) }}">Registered Patient</a></li>
                <li><a class="dropdown-item" href="{{ route('app.patients.create', ['type' => 'walk-in']) }}">Walk-in Patient</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="javascript:void(0);" id="new-patient-code">Paid Registration (Access Code)</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="row g-4">
    @forelse($patients as $patient)
    <div class="col-xl-3 col-lg-4 col-sm-6">
        <div class="card card-figure is-hoverable">
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
                                <a class="dropdown-item text-warning" href="javascript:void(0);" onclick="requestClearanceCode({{ $patient->id }})">
                                    Enter Clearance Code
                                </a>
                            @else
                                <a class="dropdown-item" href="{{ route('app.patient.checkIn', $patient->id) }}">Check In</a>
                            @endif
                            <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="confirmDeletePatient({{ $patient->id }})">Delete Profile</a>
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
                    <p class="text-muted mb-0">
                        {{ $patient->gender }}, {{ $patient->getAge() }}
                        @if($patient->patient_type === 'walkin')
                            <span class="badge bg-label-warning ms-1">Walk-in</span>
                        @endif
                    </p>
                    <p class="text-muted mb-0">{{ $patient->phone }}</p>
                    <p class="mb-0">
                        @if($patient->hmoPlan)
                            <span class="badge bg-info">{{ $patient->hmoPlan->hmo->name ?? 'HMO' }} - {{ $patient->hmoPlan->name }}</span>
                        @else
                            <span class="badge bg-dark">Self Pay</span>
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

<div class="mt-4">{{ $patients->links() }}</div>

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

function confirmDeletePatient(patientId) {
    // First check if patient has records
    fetch(`{{ url('/app/patients') }}/${patientId}`, {
        method: 'DELETE',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.has_records) {
            // Patient has records, show options
            const recordsCount = data.records_count;
            let recordsList = '';
            
            Object.keys(recordsCount).forEach(key => {
                if (recordsCount[key] > 0) {
                    const label = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                    recordsList += `• ${label}: ${recordsCount[key]}\n`;
                }
            });

            Swal.fire({
                title: 'Patient Has Medical Records',
                html: `
                    <div class="text-left">
                        <p>This patient has the following medical records:</p>
                        <div style="background: #f8f9fa; padding: 10px; border-radius: 5px; margin: 10px 0;">
                            <pre style="margin: 0; font-size: 12px;">${recordsList}</pre>
                        </div>
                        <p class="text-danger"><strong>Warning:</strong> Choosing "Delete All" will permanently remove the patient and ALL their medical records. This action cannot be undone.</p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: 'Delete All Records',
                denyButtonText: 'Keep Records (Cancel)',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#dc3545',
                denyButtonColor: '#6c757d',
                cancelButtonColor: '#6c757d',
                width: 600
            }).then((result) => {
                if (result.isConfirmed) {
                    // Force delete with all records
                    performDelete(patientId, true);
                }
            });
        } else if (data.success) {
            // No records, patient deleted successfully
            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                location.reload();
            });
        } else {
            // Error occurred
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: data.message
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'An error occurred while checking patient records.'
        });
    });
}

function performDelete(patientId, forceDelete = false) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `{{ url('/app/patients') }}/${patientId}`;
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'DELETE';
    form.appendChild(methodInput);
    
    if (forceDelete) {
        const forceInput = document.createElement('input');
        forceInput.type = 'hidden';
        forceInput.name = 'force_delete';
        forceInput.value = '1';
        form.appendChild(forceInput);
    }
    
    document.body.appendChild(form);
    
    fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: data.message
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'An error occurred while deleting the patient.'
        });
    });
    
    document.body.removeChild(form);
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
