@extends('layouts/layoutMaster')

@section('title', 'Procedure Profile')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/quill.snow.css') }}" />
    <link rel="stylesheet" href="{{ asset('easyeditor.css') }}">
@endsection
@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>
@endsection

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/extended-ui-sweetalert2.js') }}"></script>
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Procedure /</span> Request Profile</h4>
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
                        <div
                            class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                            <div class="user-profile-info">
                                <h4>{{ $patient->user->firstname . ' ' . $patient->user->lastname }}</h4>
                                <ul
                                    class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                    <li class="list-inline-item d-flex gap-1">
                                        <span class="badge bg-primary">{{ $patient->gender }}</span>
                                        <span class="badge bg-primary">{{ $patient->getAge() }}</span>
                                        <span class="badge bg-primary">Procedure: {{ $procedureRequest->procedure->name }}</span>
                                        <span class="badge bg-secondary">Status: {{ $procedureRequest->status }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                                    data-bs-toggle="dropdown" data-boundary="viewport" aria-expanded="false"
                                    aria-haspopup="true">
                                    <i class="fa fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu" style="">
                                    <li><a class="dropdown-item"
                                            href="{{ route('app.patients.edit', $patient->id) }}">Edit
                                            Patient</a></li>
                                    <li><a class="dropdown-item" data-toggle="modal"
                                            data-request-url="{{ route('app.appointment.schedule', $patient->id) }}"
                                            data-target="#global-modal-lg">Schedule Appointment</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
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
    <!--/ Header -->
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
                            data-bs-target="#navs-pills-justified-procedure-notes" aria-controls="navs-pills-justified-procedure-notes"
                            aria-selected="true">
                            <i class="tf-icons ti ti-notebook ti-xs me-1"></i> Procedure Notes
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-nursing-note"
                            aria-controls="navs-pills-justified-nursing-note" aria-selected="false" tabindex="-1">
                            <i class="tf-icons ti ti-clipboard-heart ti-xs me-1"></i> Nursing Note
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-procedure-checklist"
                            aria-controls="navs-pills-justified-procedure-checklist" aria-selected="false" tabindex="-1">
                            <i class="tf-icons ti ti-clipboard-list ti-xs me-1"></i> Procedure Checklist
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
                    <!-- Procedure Note Tab -->
                    <div class="tab-pane fade active show" id="navs-pills-justified-procedure-notes" role="tabpanel">
                        <div class="p-3">
                            <button class="btn btn-primary mb-3 float-end" data-bs-toggle="modal" data-bs-target="#modal-progress-note">
                                <i class="ti ti-plus me-1"></i> New Entry
                            </button>
                            <div class="clearfix"></div>
                            <div class="mt-3">
                                @forelse($progressNotes as $item)
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded-circle bg-label-primary d-flex align-items-center justify-content-center fw-bold" style="width:38px;height:38px;">
                                            {{ strtoupper(substr($item->user->firstname,0,1)) }}{{ strtoupper(substr($item->user->lastname,0,1)) }}
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="card border-0 shadow-sm" style="border-left:3px solid #696cff !important;background:#fff !important;">
                                            <div class="card-body py-2 px-3">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="fw-semibold" style="color:#566a7f">{{ $item->user->firstname }} {{ $item->user->lastname }}</span>
                                                    <small style="color:#a1acb8">{{ $item->created_at->format('d M Y, H:i') }}</small>
                                                </div>
                                                <p class="mb-0" style="white-space:pre-wrap;color:#566a7f">{{ $item->note }}</p>
                                            </div>
                                        </div>
                                        @if(!$loop->last)<div style="border-left:2px dashed #d9dbe0;height:16px;margin-left:11px;"></div>@endif
                                    </div>
                                </div>
                                @empty
                                <div class="text-center text-muted py-4"><i class="ti ti-note ti-lg d-block mb-2"></i>No procedure notes yet.</div>
                                @endforelse
                                {{ $progressNotes->links() }}
                            </div>
                        </div>
                    </div>

                    <!-- Nursing Note Tab -->
                    <div class="tab-pane fade" id="navs-pills-justified-nursing-note" role="tabpanel">
                        <div class="p-3">
                            <button class="btn btn-primary mb-3 float-end" data-bs-toggle="modal" data-bs-target="#modal-nursing-note">
                                <i class="ti ti-plus me-1"></i> New Entry
                            </button>
                            <div class="clearfix"></div>
                            <div class="table-responsive mt-3">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr><th>Date</th><th>Recorded By</th><th>Note</th></tr>
                                    </thead>
                                    <tbody>
                                        @forelse($nursingNotes as $item)
                                        <tr>
                                            <td style="white-space:nowrap">{{ $item->created_at->format('d M Y H:i') }}</td>
                                            <td style="white-space:nowrap">{{ $item->user->firstname }} {{ $item->user->lastname }}</td>
                                            <td style="white-space:pre-wrap">{{ $item->note }}</td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="3" class="text-center text-muted py-4">No nursing notes yet.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $nursingNotes->links() }}
                            </div>
                        </div>
                    </div>

                    <!-- Procedure Checklist Tab -->
                    <div class="tab-pane fade" id="navs-pills-justified-procedure-checklist" role="tabpanel">
                        <div class="p-3">
                            <button class="btn btn-primary mb-3 float-end" data-bs-toggle="modal" data-bs-target="#modal-nursing-task">
                                <i class="ti ti-plus me-1"></i> New Entry
                            </button>
                            <div class="clearfix"></div>
                            <div class="table-responsive mt-3">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr><th>Date</th><th>Recorded By</th><th>Task</th><th>Status</th><th></th></tr>
                                    </thead>
                                    <tbody>
                                        @forelse($nursingTasks as $item)
                                        <tr>
                                            <td style="white-space:nowrap">{{ $item->created_at->format('d M Y H:i') }}</td>
                                            <td style="white-space:nowrap">{{ $item->user->firstname }} {{ $item->user->lastname }}</td>
                                            <td style="white-space:pre-wrap">{{ $item->task }}</td>
                                            <td>
                                                <form action="{{ route('app.notes.task.toggle', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-{{ $item->status === 'Completed' ? 'success' : 'warning' }}">
                                                        {{ $item->status }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="{{ route('app.notes.task.destroy', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')">
                                                        <i class="ti ti-trash ti-xs"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="5" class="text-center text-muted py-4">No tasks yet.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $nursingTasks->links() }}
                            </div>
                        </div>
                    </div>

                    <!-- Lab Requests Tab -->
                    <div class="tab-pane fade" id="navs-pills-justified-lab" role="tabpanel">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#new-lab-modal"
                            class="btn btn-primary mb-2 float-end">New Entry</a>
                        <livewire:lab-requests :patientId="$patient->id" />
                    </div>

                    <!-- Imaging Tab -->
                    <div class="tab-pane fade" id="navs-pills-justified-imaging" role="tabpanel">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#new-imaging-modal"
                            class="btn btn-primary mb-2 float-end">New Entry</a>
                        <livewire:radiology-request :patientId="$patient->id" />
                    </div>

                    <!-- Drug Prescriptions Tab -->
                    <div class="tab-pane fade" id="navs-pills-justified-drugs" role="tabpanel">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#new-drugs-modal"
                            class="btn btn-primary mb-2 float-end">New Entry</a>
                        <livewire:drugs-request :patientId="$patient->id" />
                    </div>

                    <div class="tab-pane fade" id="navs-pills-justified-vitals" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        {!! $blood_pressure->container() !!}
                                    </div>
                                    <script src="{{ $blood_pressure->cdn() }}"></script>
                                    {{ $blood_pressure->script() }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        {!! $pulse->container() !!}
                                    </div>
                                    {{ $pulse->script() }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        {!! $temperature->container() !!}
                                    </div>
                                    {{ $temperature->script() }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        {!! $weight->container() !!}
                                    </div>
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
        .nav-scroller {
            position: relative;
            overflow: hidden;
        }

        .nav-scroller-arrow {
            display: none;
        }

        .nav-scroller:hover .nav-scroller-arrow {
            display: block;
        }

        .nav-scroller-arrow:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>

    <script>
        $(document).ready(function() {
            const navScroller = $('.nav-scroller ul');
            const arrowLeft = $('.nav-scroller-arrow-left');
            const arrowRight = $('.nav-scroller-arrow-right');
            const scrollAmount = 200; // Pixels to scroll per click

            function updateArrows() {
                const scrollLeft = navScroller.scrollLeft();
                const maxScroll = navScroller[0].scrollWidth - navScroller[0].clientWidth;
                arrowLeft.prop('disabled', scrollLeft <= 0);
                arrowRight.prop('disabled', scrollLeft >= maxScroll);
            }

            navScroller.on('scroll', updateArrows);
            $(window).on('resize', updateArrows);
            updateArrows();

            arrowLeft.on('click', function() {
                if (!$(this).prop('disabled')) {
                    navScroller.animate({
                        scrollLeft: navScroller.scrollLeft() - scrollAmount
                    }, 300);
                }
            });

            arrowRight.on('click', function() {
                if (!$(this).prop('disabled')) {
                    navScroller.animate({
                        scrollLeft: navScroller.scrollLeft() + scrollAmount
                    }, 300);
                }
            });
        });
    </script>
@endsection
@include('_partials._modals.modal-new-diagnosis')
@include('_partials._modals.modal-new-lab')
@include('_partials._modals.modal-new-drugs')
@include('_partials._modals.modal-new-imaging')
@include('_partials._modals.modal-new-vitals')
@include('_partials._modals.global-modal')

{{-- Progress Note Modal --}}
<div class="modal fade" id="modal-progress-note" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Procedure Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('app.notes.progress.store') }}" method="POST">
                @csrf
                <input type="hidden" name="procedure_request_id" value="{{ $procedureRequest->id }}">
                <div class="modal-body">
                    <label class="form-label">Note</label>
                    <textarea name="note" class="form-control" rows="8" placeholder="Enter procedure note..." required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Note</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Nursing Note Modal --}}
<div class="modal fade" id="modal-nursing-note" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Nursing Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('app.notes.nursing.store') }}" method="POST">
                @csrf
                <input type="hidden" name="procedure_request_id" value="{{ $procedureRequest->id }}">
                <div class="modal-body">
                    <label class="form-label">Note</label>
                    <textarea name="note" class="form-control" rows="8" placeholder="Enter nursing note..." required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Note</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Nursing Task Modal --}}
<div class="modal fade" id="modal-nursing-task" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Checklist Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('app.notes.task.store') }}" method="POST">
                @csrf
                <input type="hidden" name="procedure_request_id" value="{{ $procedureRequest->id }}">
                <div class="modal-body">
                    <label class="form-label">Task Description</label>
                    <textarea name="task" class="form-control" rows="5" placeholder="Enter task details..." required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '[data-request-url][data-target="#global-modal-lg"], .dropdown-item[data-request-url]', function(e) {
            e.preventDefault();
            var requestUrl = $(this).data('request-url');
            if (!requestUrl) return;
            $.ajax({
                url: requestUrl,
                type: 'GET',
                success: function(response) {
                    $('#global-modal .modal-body').html(response);
                    $('#global-modal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>
