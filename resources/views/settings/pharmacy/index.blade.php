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
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/cards-advance.js') }}"></script>
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
    <script src="{{ asset('assets/js/forms-editors.js') }}"></script>
    {{-- <script src="{{asset('assets/js/modal-edit-user.js')}}"></script> --}}
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pharmacy Settings</span>
    </h4>

    <div class="row">
        <!-- Monthly Campaign State -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Drugs Category</h5>
                    </div>
                    <a class="btn btn-label-dark waves-effect" href="javascript:void(0);" data-bs-toggle="modal"
                        data-bs-target="#new-drugs-category-modal">New</a>
                </div>
                <div class="card-body">
                    <livewire:drug-category />
                </div>
            </div>
        </div>
        <!--/  Monthly Campaign State -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Drugs Store</h5>
                        {{-- <small class="text-muted">Average 72% Completed</small> --}}
                    </div>
                    <a class="btn btn-label-dark waves-effect" href="javascript:void(0);" data-bs-toggle="modal"
                        data-bs-target="#new-drugs-store-modal">New</a>

                </div>
                <div class="card-body">
                    <livewire:drugs-store />
                </div>
            </div>
        </div>
        <!-- Active Projects -->
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Drugs Lists</h5>
                        {{-- <small class="text-muted">Average 72% Completed</small> --}}
                    </div>
                    <div class="btn-group" role="group">
                        <a class="btn btn-label-dark waves-effect" href="javascript:void(0);" data-bs-toggle="modal"
                            data-bs-target="#new-add-drugs-modal">New</a>
                        <a class="btn btn-label-dark waves-effect" href="javascript:void(0);" data-bs-toggle="modal"
                            data-bs-target="#new-speciality-modal">Downlaod List</a>
                        <a class="btn btn-label-dark waves-effect" href="javascript:void(0);" data-bs-toggle="modal"
                            data-bs-target="#new-speciality-modal">Import Drugs</a>
                    </div>

                </div>
                <div class="card-body">
                    <livewire:drugs />
                </div>
            </div>
        </div>
    </div>
@endsection
