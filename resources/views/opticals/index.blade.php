@extends('layouts/layoutMaster')

@section('title', 'Pharmacy Requests')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<!-- Row Group CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}">
<!-- Form Validation -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />

@endsection

@section('page-script')
<script src="{{ asset('assets/js/extended-ui-sweetalert2.js') }}"></script>
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<!-- Flat Picker -->
<script src="{{ asset('assets/js/theme.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<!-- Form Validation -->
<script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<div class="card">
  <div class="nav-align-top nav-tabs-shadow mb-6">
    <ul class="nav nav-tabs nav-fill" role="tablist">
      <li class="nav-item" role="presentation">
        <button type="button" class="nav-link waves-effect active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-expired" aria-controls="navs-justified-expired" aria-selected="true"><span class="d-none d-sm-block"><i class="tf-icons ti ti-calendar ti-sm ti-sm me-1_5"></i> Patients Requests </span><i class="ti ti-calendar ti-sm d-sm-none"></i></button>
      </li>
      <li class="nav-item" role="presentation">
        <button type="button" class="nav-link waves-effect" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-low-stock" aria-controls="navs-justified-low-stock" aria-selected="false" tabindex="-1"><span class="d-none d-sm-block"><i class="tf-icons ti ti-clock ti-sm me-1_5"></i> Optical Requests</span><i class="ti ti-clock ti-sm d-sm-none"></i></button>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane fade active show" id="navs-justified-expired" role="tabpanel">
        <livewire:opticals />
      </div>
      <div class="tab-pane fade" id="navs-justified-low-stock" role="tabpanel">
        <livewire:opticals />
      </div>
    </div>
  </div>

</div>
@endsection
