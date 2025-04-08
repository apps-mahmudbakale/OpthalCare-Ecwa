@extends('layouts/layoutMaster')

@section('title', 'Pharmacy Report')

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
  <div class="section-block"><!-- metric row -->
    <h4>Pharmacy Reports</h4>
    <div class="nav-align-top nav-tabs-shadow mb-6">
      <ul class="nav nav-tabs nav-fill" role="tablist">
        <li class="nav-item" role="presentation">
          <button type="button" class="nav-link waves-effect active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-expired" aria-controls="navs-justified-expired" aria-selected="true"><span class="d-none d-sm-block"><i class="tf-icons ti ti-calendar ti-sm ti-sm me-1_5"></i> Expired </span><i class="ti ti-calendar ti-sm d-sm-none"></i></button>
        </li>
        <li class="nav-item" role="presentation">
          <button type="button" class="nav-link waves-effect" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-low-stock" aria-controls="navs-justified-low-stock" aria-selected="false" tabindex="-1"><span class="d-none d-sm-block"><i class="tf-icons ti ti-clock ti-sm me-1_5"></i> Low Stock</span><i class="ti ti-clock ti-sm d-sm-none"></i></button>
        </li>
        <li class="nav-item" role="presentation">
          <button type="button" class="nav-link waves-effect" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-all" aria-controls="navs-justified-all" aria-selected="false" tabindex="-1"><span class="d-none d-sm-block"><i class="tf-icons ti ti-layout-grid ti-sm me-1_5"></i> Overall Stock</span><i class="ti ti-layout-grid ti-sm d-sm-none"></i></button>
        </li>
        <li class="nav-item" role="presentation">
          <button type="button" class="nav-link waves-effect" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-prescribed" aria-controls="navs-justified-prescribed" aria-selected="false" tabindex="-1"><span class="d-none d-sm-block"><i class="tf-icons ti ti-medical-cross ti-sm me-1_5"></i>Prescribed</span><i class="ti ti-medical-cross ti-sm d-sm-none"></i></button>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade active show" id="navs-justified-expired" role="tabpanel">
          <livewire:pharmacy-report-expired />
        </div>
        <div class="tab-pane fade" id="navs-justified-low-stock" role="tabpanel">
          <livewire:pharmacy-report-low />
        </div>
        <div class="tab-pane fade" id="navs-justified-all" role="tabpanel">
        <livewire:pharmacy-report-all />
        </div>
        <div class="tab-pane fade" id="navs-justified-prescribed" role="tabpanel">
          <div class="card">
            <!-- .card-header -->
            <div class="card-header">
              <form class="filterForm d-flex justify-content-between">
                <input type="hidden" name="csrfmiddlewaretoken" value="eQ92rqAvoFZoS7D8QiKj9wKCCUxIH1B4pZIKwr8yEva3HZOixn5qQU6el5KaupzI">
                <div class="form-group flex-fill ml-2">
                  <label class="mb-0" for="location_id">Filter By Location</label>
                  <select id="location_id" name="location_id" class="custom-select form-control filter">
                    <option value="">- All -</option>
                    <option value="18">SOKOTO DIAGNOSTIC CENTRE</option>

                  </select>
                </div>
                <div class="form-group flex-fill ml-2">
                  <label class=" mb-0" for="status_id">Filter By Prescription Status</label>
                  <select id="status_id" name="status" class="custom-select form-control filter">
                    <option value="">- All -</option>
                    <option value="pending">Pending</option>

                    <option value="packaged">Packaged</option>

                    <option value="done">Collected</option>

                    <option value="cancelled">Cancelled</option>

                  </select>
                </div>
                <div class="form-group flex-fill ml-2">
                  <input type="hidden" name="start" class="filter sr-only">
                  <input type="hidden" name="stop" class="filter sr-only">
                  <label for="reportrange" class="mb-0">Filter By Request Date</label>
                  <div id="reportrange" class="form-control d-flex custom-select">
                    <i class="mt-1 fa fa-calendar"></i>&nbsp;
                    <span class="text-nowrap">11/24/2024 - 11/24/2024</span>
                  </div>
                </div>
                <div class="form-group flex-fill- ml-3 no-label">
                  <button class="btn btn-primary mt-n1 px-3" type="button" id="export-btn">
                    <i class="fa fa-download"></i> Export to File
                  </button>
                </div>
              </form>
            </div><!-- /.card-header -->
            <!-- .table-responsive -->
            <div class="table-responsive">
              <!-- .table -->
              <table class="table table-sm- table-striped">
                <!-- thead -->
                <thead>
                <tr>
                  <th>Location</th>
                  <th class="text-right"># Requests</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                <!-- tr -->

                <tr>
                  <td class="align-middle">SOKOTO DIAGNOSTIC CENTRE</td>
                  <td class="text-right">2,022</td>
                  <td class="align-middle text-right">

                  </td>
                </tr>

                </tbody><!-- /tbody -->
              </table><!-- /.table -->
              <hr class="my-2">


              <div class="d-flex justify-content-around">

                <ul class="pagination">

                  <li class="page-item disabled">
                    <a class="page-link" href="javascript:"><span class="oi oi-arrow-left"></span> Previous</a>
                  </li>


                  <li class="page-item active">

                    <span class="page-link" href="javascript:"> 1 - 1 of 1</span>
                  </li>


                  <li class="page-item disabled">
                    <a class="page-link" href="javascript:">Next <span class="oi oi-arrow-right"></span></a>
                  </li>

                </ul>
                <input type="hidden" class="sr-only filter" name="page" value="1">

              </div>

            </div><!-- /.table-responsive -->
          </div>
        </div>
      </div>
    </div>

  </div>
</div><!-- /metric row -->
</div>
@endsection
