@extends('layouts/layoutMaster')

@section('title', 'Vital Care Settings')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}" /> --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/quill.snow.css') }}" />
    {{-- <link href="{{ asset('assets/vendor/libs/summernote/summernote.min.css') }}" rel="stylesheet"> --}}
@endsection

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script> --}}
    <script src="{{ asset('assets/js/quill.js') }}"></script>
    <script>
        // var quill = new Quill('#editor', {
        //     theme: 'snow'
        // });
        // var toolbarOptions = [['bold', 'italic', 'underline', 'strike'], ['link', 'image']];
        var toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'], // toggled buttons
            ['blockquote', 'code-block'],

            [{
                'header': 1
            }, {
                'header': 2
            }], // custom button values
            [{
                'list': 'ordered'
            }, {
                'list': 'bullet'
            }],
            [{
                'script': 'sub'
            }, {
                'script': 'super'
            }], // superscript/subscript
            [{
                'indent': '-1'
            }, {
                'indent': '+1'
            }], // outdent/indent
            [{
                'direction': 'rtl'
            }], // text direction

            [{
                'size': ['small', false, 'large', 'huge']
            }], // custom dropdown
            [{
                'header': [1, 2, 3, 4, 5, 6, false]
            }],

            [{
                'color': []
            }, {
                'background': []
            }], // dropdown with defaults from theme
            [{
                'font': []
            }],
            [{
                'align': []
            }],

            ['clean'] // remove formatting button
        ];
        var options = {
            debug: 'info',
            modules: {
                toolbar: toolbarOptions
            },
            placeholder: 'Compose an epic...',
            readOnly: false,
            theme: 'snow'
        };
        var container = document.getElementById('editor');
        var editor = new Quill(container, options);

        editor.on('text-change', (delta, oldDelta, source) => {
            console.log(editor.container.firstChild.innerHTML);
            $('#body').val(editor.container.firstChild.innerHTML);
        })
        var container = document.getElementById('editoredit');
        var editor = new Quill(container, options);

        editor.on('text-change', (delta, oldDelta, source) => {
            console.log(editor.container.firstChild.innerHTML);
            $('#bodyedit').val(editor.container.firstChild.innerHTML);
        })
    </script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/cards-advance.js') }}"></script>
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
    <script src="{{ asset('assets/js/forms-editors.js') }}"></script>
    {{-- <script src="{{asset('assets/js/modal-edit-user.js')}}"></script> --}}
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Consultations Settings</span>
    </h4>

    <div class="row">
        <!-- Specialities Card -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Specialities</h5>
                        <small class="text-muted">Manage medical specialities</small>
                    </div>
                    <a class="btn btn-primary" href="{{ route('app.specialities.index') }}">
                        <i class="ti ti-settings me-1"></i> Manage Specialities
                    </a>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="ti ti-stethoscope ti-lg"></i>
                            </span>
                        </div>
                        <div>
                            <h4 class="mb-0">{{ \App\Models\Speciality::count() }}</h4>
                            <small class="text-muted">Total Specialities</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Consulting Rooms Card -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Consulting Rooms</h5>
                        <small class="text-muted">Manage consultation rooms</small>
                    </div>
                    <a class="btn btn-primary" href="{{ route('app.consulting-rooms.index') }}">
                        <i class="ti ti-settings me-1"></i> Manage Rooms
                    </a>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="ti ti-door ti-lg"></i>
                            </span>
                        </div>
                        <div>
                            <h4 class="mb-0">{{ \App\Models\ConsultingRoom::count() }}</h4>
                            <small class="text-muted">Total Rooms</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Appointment Types Card -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Appointment Types</h5>
                        <small class="text-muted">Manage appointment categories</small>
                    </div>
                    <a class="btn btn-primary" href="{{ route('app.appointment-type.index') }}">
                        <i class="ti ti-settings me-1"></i> Manage Types
                    </a>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded bg-label-info">
                                <i class="ti ti-calendar ti-lg"></i>
                            </span>
                        </div>
                        <div>
                            <h4 class="mb-0">{{ \App\Models\AppointmentType::count() }}</h4>
                            <small class="text-muted">Total Types</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Consulting Templates Card -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Consulting Templates</h5>
                        <small class="text-muted">Manage consultation templates</small>
                    </div>
                    <a class="btn btn-primary" href="{{ route('app.consulting-templates.index') }}">
                        <i class="ti ti-settings me-1"></i> Manage Templates
                    </a>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="ti ti-file-text ti-lg"></i>
                            </span>
                        </div>
                        <div>
                            <h4 class="mb-0">{{ \App\Models\ConsultingTemplate::count() }}</h4>
                            <small class="text-muted">Total Templates</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
