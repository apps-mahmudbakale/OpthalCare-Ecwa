@extends('layouts/layoutMaster')

@section('title', 'Antenatal Record Profile')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />
@endsection
@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
@endsection

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('app.antenatals.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                <i class="ti ti-arrow-left me-1"></i> Back to Antenatal List
            </a>
            <div>
                <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Antenatal /</span> Record Profile</h4>
                <p class="text-muted mb-0 small">Complete antenatal record for documentation and follow-up tracking</p>
            </div>
        </div>
    </div>

    <!-- Header -->
    <div class="row">
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <div class="col-12">
            <div class="card mb-4">
                <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                    <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto user-avatar user-avatar-xl">
                        <img src="{{ $patient->gender == 'Male' ? asset('assets/img/user-male-circle.png') : asset('assets/img/user-female-circle.png') }}"
                            alt="user image" class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img">
                    </div>
                    <div class="flex-grow-1 mt-3 mt-sm-5">
                        <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                            <div class="user-profile-info">
                                <h4>{{ $patient->user->firstname . ' ' . $patient->user->lastname }}</h4>
                                <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                    <li class="list-inline-item d-flex gap-1">
                                        <span class="badge bg-primary">{{ $patient->gender }}</span>
                                        <span class="badge bg-primary">{{ $patient->getAge() }}</span>
                                        <span class="badge bg-info">Visit: {{ $record->visit_date ? $record->visit_date->format('M d, Y') : $record->created_at->format('M d, Y') }}</span>
                                        @if($record->visit_type === 'new')
                                            <span class="badge bg-{{ $record->isActive() ? 'success' : 'secondary' }}">
                                                {{ $record->isActive() ? 'Active Enrollment' : 'Concluded Enrollment' }}
                                            </span>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                                    data-bs-toggle="dropdown" data-boundary="viewport" aria-expanded="false"
                                    aria-haspopup="true">
                                    <i class="fa fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('app.patients.edit', $patient->id) }}">Edit Patient</a></li>
                                    <li><a class="dropdown-item" data-toggle="modal"
                                            data-request-url="{{ route('app.appointment.schedule', $patient->id) }}"
                                            data-target="#global-modal-lg">Schedule Appointment</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item"
                                            data-request-url="{{ route('app.patient.fund.wallet', $patient->id) }}"
                                            data-target="#global-modal-lg">Fund Wallet</a></li>
                                    @if($record->visit_type === 'new' && $record->isActive())
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-warning" href="#" data-bs-toggle="modal" data-bs-target="#conclude-enrollment-modal">
                                            <i class="ti ti-check-circle me-1"></i>
                                            Conclude Enrollment
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($record->visit_type === 'new' && $record->isConcluded())
    <!-- Concluded Enrollment Information -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info">
                <div class="d-flex align-items-center">
                    <i class="ti ti-info-circle me-2"></i>
                    <div class="flex-grow-1">
                        <strong>Enrollment Concluded</strong>
                        <p class="mb-0 mt-1">
                            This antenatal enrollment was concluded on 
                            <strong>{{ $record->concluded_at->format('M d, Y \a\t g:i A') }}</strong>
                            by <strong>{{ $record->concludedBy?->firstname }} {{ $record->concludedBy?->lastname }}</strong>
                        </p>
                        @if($record->conclusion_notes)
                        <div class="mt-2">
                            <small class="text-muted">Notes:</small>
                            <p class="mb-0 mt-1">{{ $record->conclusion_notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Patient balances -->
    <div class="row g-4">
        <div class="col-lg-6 col-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="badge rounded-pill p-2 bg-label-success mb-2">
                        <i class="ti ti-briefcase ti-sm"></i>
                    </div>
                    <h5 class="card-title mb-2">{{ number_format($wallet_balance) }}</h5>
                    <small>Wallet Balance</small>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-6 mb-4">
            <a href="{{ route('app.billing.index') }}">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="badge rounded-pill p-2 bg-label-danger mb-2">
                            <i class="ti ti-briefcase ti-sm"></i>
                        </div>
                        <h5 class="card-title mb-2">{{ number_format($outstanding_balance) }}</h5>
                        <small>Outstanding Balance</small>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Record Detail Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center">
                    <i class="ti ti-baby-carriage me-2 text-primary"></i>
                    <h5 class="card-title mb-0">Obstetric History</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm mb-0">
                        <tr><td class="text-muted">Gravida</td><td>{{ $record->gravida ?? '—' }}</td></tr>
                        <tr><td class="text-muted">Parity</td><td>{{ $record->parity ?? '—' }}</td></tr>
                        <tr><td class="text-muted">Alive</td><td>{{ $record->alive ?? '—' }}</td></tr>
                        <tr><td class="text-muted">Miscarriage</td><td>{{ $record->miscarriage ?? '—' }}</td></tr>
                        <tr><td class="text-muted">LMP</td><td>{{ $record->last_menstrual_period ? $record->last_menstrual_period->format('M d, Y') : '—' }}</td></tr>
                        <tr><td class="text-muted">Current Pregnancy</td><td>{{ $record->current_pregnancy ?? '—' }}</td></tr>
                        <tr><td class="text-muted">Package</td><td>{{ $record->enrolmentPackage?->name ?? '—' }}</td></tr>
                        <tr><td class="text-muted">HMO Plan</td><td>{{ $record->hmoPlan?->name ?? '—' }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center">
                    <i class="ti ti-stethoscope me-2 text-primary"></i>
                    <h5 class="card-title mb-0">Complaint</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $record->complaint ?? 'No complaint recorded.' }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center">
                    <i class="ti ti-clipboard-list me-2 text-success"></i>
                    <h5 class="card-title mb-0">Treatment Plan</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $record->treatment_plan ?? 'No treatment plan recorded.' }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center">
                    <i class="ti ti-notebook me-2 text-info"></i>
                    <h5 class="card-title mb-0">Notes</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $record->note ?? 'No notes recorded.' }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($record->visit_type === 'followup')
    <!-- Follow-up Information Cards -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info">
                <i class="ti ti-info-circle me-2"></i>
                <strong>Follow-up Visit</strong> - This is a follow-up antenatal visit
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center">
                    <i class="ti ti-ruler me-2 text-primary"></i>
                    <h5 class="card-title mb-0">Physical Examination</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm mb-0">
                        <tr><td class="text-muted">Fundus Height</td><td>{{ $record->height_of_fundus ?? '—' }}</td></tr>
                        <tr><td class="text-muted">Presentation</td><td>{{ $record->presentation_and_position ?? '—' }}</td></tr>
                        <tr><td class="text-muted">Fetal Heart</td><td>{{ $record->fetal_heart ?? '—' }}</td></tr>
                        <tr><td class="text-muted">Urine</td><td>{{ $record->urine ?? '—' }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center">
                    <i class="ti ti-activity me-2 text-success"></i>
                    <h5 class="card-title mb-0">Vital Signs</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm mb-0">
                        <tr><td class="text-muted">Blood Pressure</td><td>{{ $record->blood_pressure ?? '—' }}</td></tr>
                        <tr><td class="text-muted">Weight</td><td>{{ $record->weight ? $record->weight . ' kg' : '—' }}</td></tr>
                        <tr><td class="text-muted">Edema</td><td>{{ $record->edema ?? '—' }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center">
                    <i class="ti ti-stethoscope me-2 text-primary"></i>
                    <h5 class="card-title mb-0">Follow-up Complaint</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $record->followup_complaint ?? 'No complaint recorded.' }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center">
                    <i class="ti ti-clipboard-list me-2 text-success"></i>
                    <h5 class="card-title mb-0">Follow-up Treatment</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $record->followup_treatment ?? 'No treatment recorded.' }}</p>
                </div>
            </div>
        </div>
        @if($record->followup_notes)
        <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <i class="ti ti-notebook me-2 text-info"></i>
                    <h5 class="card-title mb-0">Follow-up Notes</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $record->followup_notes }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- Tabs -->
    <div class="row">
        <div class="col-md-12">
            <div class="nav-scroller position-relative">
                <button class="nav-scroller-arrow nav-scroller-arrow-left btn btn-sm btn-icon btn-light"
                    style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); z-index: 10;">
                    <i class="ti ti-chevron-left"></i>
                </button>
                <ul class="nav nav-pills flex-column flex-sm-row mb-4" role="tablist"
                    style="overflow-x: auto; white-space: nowrap; padding: 0 40px;">
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-all-visits" aria-controls="navs-pills-justified-all-visits"
                            aria-selected="true">
                            <i class="tf-icons ti ti-list ti-xs me-1"></i> All Antenatal Visits
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-followup" aria-controls="navs-pills-justified-followup"
                            aria-selected="false" tabindex="-1">
                            <i class="tf-icons ti ti-calendar-check ti-xs me-1"></i> Follow Up
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-lab" aria-controls="navs-pills-justified-lab"
                            aria-selected="false" tabindex="-1">
                            <i class="tf-icons ti ti-microscope ti-xs me-1"></i> Lab Requests
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-imaging" aria-controls="navs-pills-justified-imaging"
                            aria-selected="false" tabindex="-1">
                            <i class="tf-icons ti ti-photo ti-xs me-1"></i> Imaging
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-drugs" aria-controls="navs-pills-justified-drugs"
                            aria-selected="false" tabindex="-1">
                            <i class="tf-icons ti ti-prescription ti-xs me-1"></i> Drug Prescriptions
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-vitals" aria-controls="navs-pills-justified-vitals"
                            aria-selected="false" tabindex="-1">
                            <i class="tf-icons ti ti-activity-heartbeat ti-xs me-1"></i> Vitals
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-delivery" aria-controls="navs-pills-justified-delivery"
                            aria-selected="false" tabindex="-1">
                            <i class="tf-icons ti ti-baby-carriage ti-xs me-1"></i> Delivery
                        </button>
                    </li>
                </ul>
                <button class="nav-scroller-arrow nav-scroller-arrow-right btn btn-sm btn-icon btn-light"
                    style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); z-index: 10;">
                    <i class="ti ti-chevron-right"></i>
                </button>
            </div>
            <div class="card">
                <div class="tab-content">
                    <!-- All Visits Tab -->
                    <div class="tab-pane fade active show" id="navs-pills-justified-all-visits" role="tabpanel">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#new-antenatal-record-modal"
                            class="btn btn-primary mb-2 float-end">New Visit</a>
                        <livewire:antenatal-records :patientId="$patient->id" />
                    </div>

                    <!-- Follow Up Tab -->
                    <div class="tab-pane fade" id="navs-pills-justified-followup" role="tabpanel">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#new-followup-modal"
                            class="btn btn-primary mb-2 float-end">New Follow Up</a>
                        <livewire:antenatal-followups :patientId="$patient->id" />
                    </div>

                    <!-- Lab Requests Tab -->
                    <div class="tab-pane fade" id="navs-pills-justified-lab" role="tabpanel">
                        <a href="" data-bs-toggle="modal" data-bs-target="#new-lab-modal"
                            class="btn btn-primary mb-2 float-end">New Entry</a>
                        <livewire:lab-requests :patientId="$patient->id" />
                    </div>

                    <!-- Imaging Tab -->
                    <div class="tab-pane fade" id="navs-pills-justified-imaging" role="tabpanel">
                        <a href="" data-bs-toggle="modal" data-bs-target="#new-imaging-modal"
                            class="btn btn-primary mb-2 float-end">New Entry</a>
                        <livewire:radiology-request :patientId="$patient->id" />
                    </div>

                    <!-- Drug Prescriptions Tab -->
                    <div class="tab-pane fade" id="navs-pills-justified-drugs" role="tabpanel">
                        <a href="" data-bs-toggle="modal" data-bs-target="#new-drugs-modal"
                            class="btn btn-primary mb-2 float-end">New Entry</a>
                        <livewire:drugs-request :patientId="$patient->id" />
                    </div>

                    <!-- Vitals Tab -->
                    <div class="tab-pane fade" id="navs-pills-justified-vitals" role="tabpanel">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#new-vitals-modal"
                            class="btn btn-primary mb-2 float-end">New Entry</a>
                        
                        <!-- Vitals History -->
                        <div class="mb-4">
                            <h5 class="mb-3">Vital Signs History</h5>
                            <livewire:antenatal-vitals :patientId="$patient->id" />
                        </div>

                        <!-- Charts -->
                        <div class="mb-4">
                            <h5 class="mb-3">Vital Signs Charts</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">Blood Pressure Trend</h6>
                                        </div>
                                        <div class="card-body">{!! $blood_pressure->container() !!}</div>
                                        <script src="{{ $blood_pressure->cdn() }}"></script>
                                        {{ $blood_pressure->script() }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">Pulse Trend</h6>
                                        </div>
                                        <div class="card-body">{!! $pulse->container() !!}</div>
                                        {{ $pulse->script() }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">Temperature Trend</h6>
                                        </div>
                                        <div class="card-body">{!! $temperature->container() !!}</div>
                                        {{ $temperature->script() }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">Weight Trend</h6>
                                        </div>
                                        <div class="card-body">{!! $weight->container() !!}</div>
                                        {{ $weight->script() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Tab -->
                    <div class="tab-pane fade" id="navs-pills-justified-delivery" role="tabpanel">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#new-delivery-modal"
                            class="btn btn-primary mb-2 float-end">New Delivery Record</a>
                        <livewire:delivery-records :patientId="$patient->id" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .nav-scroller { position: relative; overflow: hidden; }
        .nav-scroller-arrow { display: none; }
        .nav-scroller:hover .nav-scroller-arrow { display: block; }
        .nav-scroller-arrow:disabled { opacity: 0.5; cursor: not-allowed; }
    </style>

    <script>
        $(document).ready(function() {
            const navScroller = $('.nav-scroller ul');
            const arrowLeft = $('.nav-scroller-arrow-left');
            const arrowRight = $('.nav-scroller-arrow-right');
            const scrollAmount = 200;

            function updateArrows() {
                const scrollLeft = navScroller.scrollLeft();
                const maxScroll = navScroller[0].scrollWidth - navScroller[0].clientWidth;
                arrowLeft.prop('disabled', scrollLeft <= 0);
                arrowRight.prop('disabled', scrollLeft >= maxScroll);
            }

            navScroller.on('scroll', updateArrows);
            $(window).on('resize', updateArrows);
            updateArrows();

            arrowLeft.on('click', function() { if (!$(this).prop('disabled')) { navScroller.animate({ scrollLeft: navScroller.scrollLeft() - scrollAmount }, 300); } });
            arrowRight.on('click', function() { if (!$(this).prop('disabled')) { navScroller.animate({ scrollLeft: navScroller.scrollLeft() + scrollAmount }, 300); } });
        });
    </script>
    @include('_partials._modals.global-modal')
    @include('_partials._modals.modal-new-lab', ['patientId' => $patient->id, 'patient' => $patient])
    @include('_partials._modals.modal-new-imaging', ['patientId' => $patient->id, 'patient' => $patient])
    @include('_partials._modals.modal-new-drugs', ['patientId' => $patient->id, 'patient' => $patient])
    @include('_partials._modals.modal-new-delivery', ['patientId' => $patient->id, 'patient' => $patient, 'record' => $record])
    @include('_partials._modals.modal-new-antenatal-vitals', ['patient' => $patient, 'record' => $record])
    @include('_partials._modals.modal-new-followup', ['patientId' => $patient->id, 'patient' => $patient])
    @include('_partials._modals.modal-new-antenatal-record', ['patientId' => $patient->id, 'patient' => $patient])
    @if($record->visit_type === 'new')
        @include('_partials._modals.modal-conclude-enrollment', ['patient' => $patient, 'record' => $record])
    @endif
@endsection
