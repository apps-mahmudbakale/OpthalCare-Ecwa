@extends('layouts/layoutMaster')

@section('title', 'Antenatal Profile')

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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Antenatal /</span> Record Profile</h4>

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
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">{!! $blood_pressure->container() !!}</div>
                                    <script src="{{ $blood_pressure->cdn() }}"></script>
                                    {{ $blood_pressure->script() }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">{!! $pulse->container() !!}</div>
                                    {{ $pulse->script() }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">{!! $temperature->container() !!}</div>
                                    {{ $temperature->script() }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">{!! $weight->container() !!}</div>
                                    {{ $weight->script() }}
                                </div>
                            </div>
                        </div>
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
@endsection
