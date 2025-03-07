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
        <!-- Monthly Campaign State -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Specialities</h5>
                    </div>
                    <a class="btn btn-label-dark waves-effect" href="javascript:void(0);" data-bs-toggle="modal"
                        data-bs-target="#new-speciality-modal">New</a>
                </div>
                <div class="card-body">
                    <livewire:specialities />
                </div>
            </div>
        </div>
        <!--/ Monthly Campaign State -->

        <!-- Active Projects -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Consulting Rooms</h5>
                        {{-- <small class="text-muted">Average 72% Completed</small> --}}
                    </div>
                    <a class="btn btn-label-dark waves-effect" href="javascript:void(0);" data-bs-toggle="modal"
                        data-bs-target="#new-consulting-room-modal">New</a>
                </div>
                <div class="card-body">
                    <livewire:consulting-rooms />
                </div>
            </div>
        </div>
        <!-- Active Projects -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Appointment Types</h5>
                    </div>
                    <a class="btn btn-label-dark waves-effect" href="javascript:void(0);" data-bs-toggle="modal"
                        data-bs-target="#new-appointment-type">New</a>
                </div>
                <div class="card-body">
                    <livewire:appointment-types />
                </div>
            </div>
        </div>
        <!-- Active Projects -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Consulting Templates</h5>
                        {{-- <small class="text-muted">Average 72% Completed</small> --}}
                    </div>
                    <a class="btn btn-label-dark waves-effect" href="javascript:void(0);" data-bs-toggle="modal"
                        data-bs-target="#new-consulting-template-modal">New</a>
                </div>
                <div class="card-body">
                    <livewire:consulting-templates />
                </div>
            </div>
        </div>
    </div>
@endsection
