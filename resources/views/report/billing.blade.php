@extends('layouts/layoutMaster')

@section('title', 'Revenue Report')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/fullcalendar/fullcalendar.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-calendar.css') }}" />
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/fullcalendar/fullcalendar.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
@endsection

@section('page-script')
<script src="{{ asset('assets/js/app-calendar-events.js') }}"></script>
<script src="{{ asset('assets/js/app-calendar.js') }}"></script>
@endsection

@section('content')
<div class="page-section">
  <div class="section-block">
    <h4>Billing Reports</h4>
    <div class="nav-align-top nav-tabs-shadow mb-6">
      <ul class="nav nav-tabs nav-fill" role="tablist">
        <li class="nav-item" role="presentation">
          <button type="button" class="nav-link waves-effect active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-revenue" aria-controls="navs-justified-revenue" aria-selected="true">
            <span class="d-none d-sm-block"><i class="tf-icons ti ti-report-money ti-sm ti-sm me-1_5"></i> Revenue</span>
            <i class="ti ti-report-money ti-sm d-sm-none"></i>
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button type="button" class="nav-link waves-effect" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-cashpoints" aria-controls="navs-justified-cashpoints" aria-selected="true">
            <span class="d-none d-sm-block"><i class="tf-icons ti ti-cash-banknote ti-sm ti-sm me-1_5"></i> Cashpoints</span>
            <i class="ti ti-cash-banknote ti-sm d-sm-none"></i>
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button type="button" class="nav-link waves-effect" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-cashier" aria-controls="navs-justified-cashier" aria-selected="true">
            <span class="d-none d-sm-block"><i class="tf-icons ti ti-clock ti-sm ti-sm me-1_5"></i> Cashier's End of Day</span>
            <i class="ti ti-clock ti-sm d-sm-none"></i>
          </button>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade active show" id="navs-justified-revenue" role="tabpanel">
          <livewire:revenue-report />
        </div>
        <div class="tab-pane fade" id="navs-justified-cashpoints" role="tabpanel">
         <livewire:cashpoint-report />
        </div>
        <div class="tab-pane fade" id="navs-justified-cashier" role="tabpanel">
          <livewire:end-day-report />
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
