@extends('layouts/layoutMaster')

@section('title', 'General Report')

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
    <h4>General Report</h4>
    <div class="nav-align-top nav-tabs-shadow mb-6">
      <ul class="nav nav-tabs nav-fill" role="tablist">
        <li class="nav-item" role="presentation">
          <button type="button" class="nav-link waves-effect active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-visits" aria-controls="navs-justified-visit" aria-selected="true"><span class="d-none d-sm-block"><i class="tf-icons ti ti-calendar ti-sm ti-sm me-1_5"></i> Visits </span><i class="ti ti-calendar ti-sm d-sm-none"></i></button>
        </li>
        <li class="nav-item" role="presentation">
          <button type="button" class="nav-link waves-effect" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-diagnoses" aria-controls="navs-justified-diagnoses" aria-selected="false" tabindex="-1"><span class="d-none d-sm-block"><i class="tf-icons ti ti-stethoscope ti-sm me-1_5"></i> Diagnoses</span><i class="ti ti-stethoscope ti-sm d-sm-none"></i></button>
        </li>
        <li class="nav-item" role="presentation">
          <button type="button" class="nav-link waves-effect" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-admission" aria-controls="navs-justified-admission" aria-selected="false" tabindex="-1"><span class="d-none d-sm-block"><i class="tf-icons ti ti-bed ti-sm me-1_5"></i> Admissions</span><i class="ti ti-bed ti-sm d-sm-none"></i></button>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade active show" id="navs-justified-visits" role="tabpanel">
          <div class="card">
            <div class="card-header">
              <form action="" class="filterForm d-flex justify-content-between">
                <div class="form-group flex-fill mr-2">
                  <label class="mb-0" for="id_clinic">Filter By Service</label>
                  <select id="id_clinic" name="clinic_id" class="custom-select form-control filter">
                    <option value="">- All -</option>
                    <option value="1">DIAGNOSTICS</option>

                    <option value="3">GENERAL CONSULTATION</option>

                    <option value="4">MEDICAL CHECK-UP</option>

                    <option value="6">PSYCHIATRY</option>

                    <option value="5">RETAINERSHIP</option>

                    <option value="2">SPECIALIST CLINIC</option>

                  </select>
                </div>
                <div class="form-group flex-fill mr-2">
                  <label class="mb-0" for="id_clinic">Filter By Status</label>
                  <select id="id_status" name="status" class="custom-select form-control filter">
                    <option value="">- All -</option>
                    <option value="scheduled">Scheduled</option>

                    <option value="missed">Missed</option>

                    <option value="active">Checked In</option>

                    <option value="done">Completed</option>

                    <option value="cancelled">Cancelled</option>

                  </select>
                </div>

                <div class="form-group flex-fill mr-2">
                  <input type="hidden" name="start" class="filter sr-only" value="2024-11-24">
                  <input type="hidden" name="stop" class="filter sr-only" value="2024-11-24">
                  <label for="reportrange" class="mb-0">Filter By Visit Date</label>
                  <div id="reportrange" class="form-control d-flex custom-select">
                    <i class="mt-1 fa fa-calendar"></i>&nbsp;
                    <span class="text-nowrap">11/24/2024 - 11/24/2024</span>
                  </div>
                </div>
                <div class="form-group flex-fill- ml-3 no-label">
                  <button class="btn btn-primary px-3" style="margin-top: 1.26rem;" type="button" id="export-btn">
                    <i class="fa fa-download"></i> Export to File
                  </button>
                </div>

              </form>
            </div>
            <div class="table-responsive">

              <!-- .table -->
              <table class="table table-sm- table-striped">
                <!-- thead -->
                <thead>

                <tr>
                  <th>Service</th>
                  <th>Patient</th>
                  <th>Date</th>
                  <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <!-- tr -->

                <tr>
                  <td colspan="4">
                    <div class="alert-warning alert">No Records to Display at the moment</div>
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

                    <span class="page-link" href="javascript:"> 0 - 0 of 0</span>
                  </li>


                  <li class="page-item disabled">
                    <a class="page-link" href="javascript:">Next <span class="oi oi-arrow-right"></span></a>
                  </li>

                </ul>
                <input type="hidden" class="sr-only filter" name="page" value="1">

              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="navs-justified-diagnoses" role="tabpanel">
          <div class="card" data-select2-id="5">
            <!-- .card-header -->
            <div class="card-header">
              <form class="filterForm d-flex justify-content-between">
                <input type="hidden" name="csrfmiddlewaretoken" value="T9xfm6WZ0x7CSeF5aTDp0rCI1tD0kQOB4i6Xr7u2gnihH6QfRYYwHPYkKEQs7eMf">
                <div class="form-group flex-fill ml-2-" data-select2-id="4">
                  <label class="mb-0" for="id_diagnosis">Filter By Case</label>
                  <select id="id_diagnosis" name="diagnosis_id" class="custom-select form-control filter select2-hidden-accessible" data-select2-id="id_diagnosis" tabindex="-1" aria-hidden="true">
                    <option value="" data-select2-id="1">- All -</option>
                  </select><span class="select2 select2-container select2-container--default select2-container--below select2-container--focus" dir="ltr" data-select2-id="2" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-id_diagnosis-container"><span class="select2-selection__rendered" id="select2-id_diagnosis-container" role="textbox" aria-readonly="true"><span class="select2-selection__placeholder">Browse ICD10 Collection ...</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                </div>

                <div class="form-group flex-fill ml-2">
                  <input type="hidden" name="start" class="filter sr-only" value="2024-11-24">
                  <input type="hidden" name="stop" class="filter sr-only" value="2024-11-24">
                  <label for="reportrange" class="mb-0">Filter By Date</label>
                  <div id="reportrange" class="form-control d-flex custom-select">
                    <i class="mt-1 fa fa-calendar"></i>&nbsp;
                    <span class="text-nowrap">11/24/2024 - 11/24/2024</span>
                  </div>
                </div>
                <div class="form-group flex-fill- ml-3 no-label">
                  <button class="btn btn-primary px-3" style="margin-top: 1.26rem;" type="button" id="export-btn">
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
                  <th>Date</th><th>Case</th><th>Status</th><th>Patient</th>
                </tr>
                </thead>
                <tbody>
                <!-- tr -->

                <tr>
                  <td colspan="4">
                    <div class="alert-warning alert">No Records to Display at the moment</div>
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

                    <span class="page-link" href="javascript:"> 0 - 0 of 0</span>
                  </li>


                  <li class="page-item disabled">
                    <a class="page-link" href="javascript:">Next <span class="oi oi-arrow-right"></span></a>
                  </li>

                </ul>
                <input type="hidden" class="sr-only filter" name="page" value="1">

              </div>


            </div><!-- /.table-responsive -->
          </div
        </div>
      </div>
        <div class="tab-pane fade" id="navs-justified-admission" role="tabpanel">
          <div class="card">
            <!-- .card-header -->
            <div class="card-header">
              <form class="filterForm d-flex justify-content-between">
                <input type="hidden" name="csrfmiddlewaretoken" value="gzZVLY5UxBuum7yNuXIG123VvvvlYnLFrIyDQZDXNrF9bZJXb23NIqpxeGINLLJj">
                <div class="form-group flex-fill">
                  <label class="mb-0" for="id_ward">Filter By Wards</label>
                  <select id="id_ward" name="ward_id" class="custom-select form-control filter">
                    <option value="">- All -</option>
                    <option value="3">ACCIDENT &amp; EMERGENCY</option>

                    <option value="5">FEMALE AMINITY</option>

                    <option value="2">FEMALE WARD</option>

                    <option value="6">MALE AMINITY</option>

                    <option value="1">MALE WARD</option>

                    <option value="4">PEDIATRIC WARD</option>

                  </select>
                </div>
                <div class="form-group flex-fill ml-2">
                  <label class="mb-0" for="id_status">Filter By Status</label>
                  <select id="id_status" name="status" class="custom-select form-control filter">
                    <option value="">- All -</option>
                    <option value="active">Active</option>

                    <option value="discharged">Discharged</option>

                  </select>
                </div>
                <div class="form-group flex-fill ml-2">
                  <input type="hidden" name="start" class="filter sr-only" value="2024-11-24">
                  <input type="hidden" name="stop" class="filter sr-only" value="2024-11-24">
                  <label for="reportrange" class="mb-0">Filter By Admission Date</label>
                  <div id="reportrange" class="form-control d-flex custom-select">
                    <i class="mt-1 fa fa-calendar"></i>&nbsp;
                    <span class="text-nowrap">11/24/2024 - 11/24/2024</span>
                  </div>
                </div>
                <div class="form-group flex-fill- ml-3 no-label">
                  <button class="btn btn-primary px-3 text-nowrap" style="margin-top: 1.26rem;" type="button" id="export-btn">
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
                  <th>Patient</th><th>Ward</th><th>Date of Admission</th><th>Length of Stay</th>
                </tr>
                </thead>
                <tbody>
                <!-- tr -->

                <tr>
                  <td colspan="4">
                    <div class="alert-warning alert">No Records to Display at the moment</div>
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

                    <span class="page-link" href="javascript:"> 0 - 0 of 0</span>
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
  </div><!-- /metric row -->
</div>
@endsection
