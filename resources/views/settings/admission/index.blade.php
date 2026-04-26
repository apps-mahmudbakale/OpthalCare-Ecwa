@extends('layouts/layoutMaster')

@section('title', 'Vital Care Settings')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/cards-advance.js') }}"></script>
    {{-- <script src="{{asset('assets/js/modal-edit-user.js')}}"></script> --}}
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admission Settings</span>
    </h4>

    <div class="row">
        <!-- Wards Card -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Wards</h5>
                        <small class="text-muted">Manage hospital wards</small>
                    </div>
                    <a class="btn btn-primary" href="{{ route('app.wards.index') }}">
                        <i class="ti ti-settings me-1"></i> Manage Wards
                    </a>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="ti ti-building-hospital ti-lg"></i>
                            </span>
                        </div>
                        <div>
                            <h4 class="mb-0">{{ \App\Models\Ward::count() }}</h4>
                            <small class="text-muted">Total Wards</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Beds Card -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Beds</h5>
                        <small class="text-muted">Manage hospital beds</small>
                    </div>
                    <a class="btn btn-primary" href="{{ route('app.beds.index') }}">
                        <i class="ti ti-settings me-1"></i> Manage Beds
                    </a>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="ti ti-bed ti-lg"></i>
                            </span>
                        </div>
                        <div>
                            <h4 class="mb-0">{{ \App\Models\Bed::count() }}</h4>
                            <small class="text-muted">Total Beds</small>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-success me-2">
                            <i class="ti ti-check"></i> {{ \App\Models\Bed::where('available', true)->count() }} Available
                        </small>
                        <small class="text-danger">
                            <i class="ti ti-x"></i> {{ \App\Models\Bed::where('available', false)->count() }} Occupied
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
