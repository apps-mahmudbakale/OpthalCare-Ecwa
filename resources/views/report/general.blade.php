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
        <li class="nav-item" role="presentation">
          <button type="button" class="nav-link waves-effect" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-consultaions" aria-controls="navs-justified-consultaions" aria-selected="false" tabindex="-1"><span class="d-none d-sm-block"><i class="tf-icons ti ti-medical-cross ti-sm me-1_5"></i>Consultaions</span><i class="ti ti-medical-cross ti-sm d-sm-none"></i></button>
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
        <div class="tab-pane fade" id="navs-justified-consultaions" role="tabpanel">
          <div class="card">
            <!-- .card-header -->
            <div class="card-header">
              <form class="filterForm d-flex justify-content-between">
                <div class="form-group flex-fill ml-2">
                  <label class="mb-0" for="id_specialty">Filter By Specialization</label>
                  <select id="id_specialty" name="specialization_id" class="custom-select form-control filter">
                    <option value="">- All -</option>
                    <option value="15">....</option>

                    <option value="14">BACK PAIN</option>

                    <option value="22">BASIC MEDICAL CHECK-UP (FEMALE)</option>

                    <option value="18">BASIC MEDICAL CHECK-UP (MALE)</option>

                    <option value="10">CADIOLOGY</option>

                    <option value="33">CADIOLOGY</option>

                    <option value="21">COMPLETE MEDICAL CHECK-UP (MALE)</option>

                    <option value="17">COMPLETE MEDICAL CKECH-UP (FEMALE)</option>

                    <option value="24">COMPREHENSIVE MEDICAL CHECK-UP (FEMALE)</option>

                    <option value="20">COMPREHENSIVE MEDICAL CHECK-UP (MALE)</option>

                    <option value="16">DENTAL SURGEON</option>

                    <option value="29">DERMATOLOGIST</option>

                    <option value="37">ENDOCRINOLOGIST</option>

                    <option value="6">ENT</option>

                    <option value="23">EXECUTE MEDICAL CHECK-UP (FEMALE)</option>

                    <option value="19">EXECUTIVE MEDICAL CHECK-UP (MALE)</option>

                    <option value="2">GASTROENTROLOGIST</option>

                    <option value="1">GENERAL CONSULTATION</option>

                    <option value="12">GENERAL SURGEON</option>

                    <option value="3">GYNAECOLOGIST</option>

                    <option value="11">NEPHROLOGY</option>

                    <option value="9">NEUROLOGY</option>

                    <option value="4">NUERO PAEDIATRICS</option>

                    <option value="13">Neurosurgeon</option>

                    <option value="38">ONCOLOGIST</option>

                    <option value="7">OPHTHALMOLOGY</option>

                    <option value="39">OPTHALMOLOGY</option>

                    <option value="26">ORTHOPAEDICS</option>

                    <option value="31">PAEDIATRIC SURGEON</option>

                    <option value="32">PEDIATRICS</option>

                    <option value="28">PLASTIC SURGEON</option>

                    <option value="25">PSYCHIATRY</option>

                    <option value="35">Physiotherapy</option>

                    <option value="5">RADIOLOGIST</option>

                    <option value="27">RHEUMATOLIGIST</option>

                    <option value="30">SPINE SURGEON</option>

                    <option value="40">STAFF CONSULTATION</option>

                    <option value="34">UROLOGIST</option>

                    <option value="8">UROLOGY</option>

                    <option value="36">UROLOGY (DIS)</option>

                  </select>
                </div>
                <div class="form-group flex-fill ml-2">
                  <label class="mb-0" for="id_doctor">Filter By Doctor</label>
                  <select id="id_doctor" name="doctor_id" class="custom-select form-control filter">
                    <option value="">- All -</option>
                    <option value="15">Mustapha Bature</option>

                    <option value="19">Dr. Halimat Hassan Amin</option>

                    <option value="3">Abbas Nagwari</option>

                    <option value="14">DR ALI YAROKO</option>

                    <option value="2">Shamsuddeen Aliyu</option>

                    <option value="79">Fahd Hassan</option>

                    <option value="17">Abdulqadir Ibrahim</option>

                    <option value="24">ALIYU DR MUHAMMAD KOKO</option>

                    <option value="40">Fatima Raji</option>

                    <option value="12">Muhammadu Shuaibu</option>

                    <option value="9">ZAYYANU USMAN</option>

                    <option value="65">Abubakar Sadiq Muhammad</option>

                    <option value="64">Abdulkadir Usman</option>

                    <option value="70">Murtala Ahmad</option>

                    <option value="118">BUHARI USMAN HAMZAT</option>

                    <option value="72">Habibu Bunza</option>

                    <option value="52">Muawiyya Zagga Usman</option>

                    <option value="61">AHMAD ABUBAKAR</option>

                    <option value="69">abdullahi ibrahim augie</option>

                    <option value="43">NDUBUIZU GODWIN</option>

                    <option value="53">Sahabi Abubakar Muhammad</option>

                    <option value="88">Namadina Abubakar</option>

                    <option value="94">Ashafa BirninGwari Isa</option>

                    <option value="117">HABIBA SAIDU</option>

                    <option value="108">Abubakar Sadeeq Fawa</option>

                    <option value="102">Musa Umar Tambuwal</option>

                    <option value="109">PHYSIOTHERAPIST PHYSIOTHERAPIST</option>

                    <option value="96">Dr. sanusi Saidu</option>

                    <option value="83">Usman MohammadBello</option>

                    <option value="87">Abdullahi Nuhu</option>

                    <option value="86">Lukman Olalekan Ajiboye</option>

                    <option value="85">NASIRU DANKIRI</option>

                    <option value="136">UMAR MUKTAR</option>

                    <option value="66">abdulaziz aminu</option>

                    <option value="119">Isah Shehu</option>

                    <option value="138">Abdul Baba</option>

                    <option value="135">IBRAHIM BAKALE</option>

                    <option value="123">LEAH NDI SYLVESTER</option>

                    <option value="134">Nuhu Maishanu</option>

                    <option value="144">Dr Adeshina Yusuf</option>

                    <option value="141">GALADIMA ABDULLAHI BELLO</option>

                    <option value="133">BATULA MUAZU</option>

                    <option value="159">bashar muhammad goronyo</option>

                    <option value="157">ABDUL,AZIZ HABIBU</option>

                    <option value="163">amina abubakar abdullahi</option>

                  </select>
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
                  <button class="btn btn-primary px-3 text-nowrap" style="margin-top: 1.26rem" type="button" id="export-btn">
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
                  <th>Patient</th>
                  <th>Clinic/Specialty</th>
                  <th>Date of Visit</th>
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


            </div><!-- /.table-responsive -->
          </div>
          <script>
            jQuery(function ($) {
              var start = moment();
              var end = moment();

              function cb(start, end) {
                $('.tab-pane.active.show #reportrange span').html(start.format('MM/D/YYYY') + ' - ' + end.format('MM/D/YYYY'));
                $('.tab-pane.active.show [name="start"].filter').val(start.format("YYYY-MM-DD"));
                $('.tab-pane.active.show [name="stop"].filter').val(end.format("YYYY-MM-DD"));
              }



              $('.tab-pane.active.show #reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                  'Today': [moment(), moment()],
                  'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                  'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                  'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                  'This Month': [moment().startOf('month'), moment().endOf('month')],
                  'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
              }, cb).on('apply.daterangepicker', function (ev, picker) {
                $('.tab-pane.active.show [name="start"].filter').val(picker.startDate.format("YYYY-MM-DD"));
                $('.tab-pane.active.show [name="stop"].filter').val(picker.endDate.format("YYYY-MM-DD"));
                processFilter();
              });

              cb(start, end, "");

              var formatDisplay = function (patient) {
                if (patient.loading) {
                  return patient.text;
                }
                return '<div class="media">' + '<div class="user-avatar mr-2"><img src="/assets/images/avatars/unknown-profile.jpg" /></div>' + '<div class="media-body">' + '<h6 class="my-0">' + patient.full_name + (patient.folder_number ? ' [' + patient.folder_number + ']' : '') + '</h6> <ul class="list-inline small text-muted">' + '<li class="list-inline-item">Gender: ' + patient._gender + '</li>' + '<li class="list-inline-item">Primary Billing Plan: ' + patient.plan_primary + '</li>' + '<li class="list-inline-item">Age: ' + patient.age + '</li>' + '<li class="list-inline-item">Phone: ' + patient.phone_numbers.join(', ') + '</li>' + '</ul>' + '</div></div>';
              };

              var formatSelection = function (patient) {
                if (patient !== undefined && patient.full_name) {
                  return '<div class="user-avatar user-avatar-xs mr-2"><img src="/assets/images/avatars/unknown-profile.jpg" /></div>' + patient.full_name || patient.text;
                } else {
                  return patient ? patient.text : "Select ..."; //the placeholder when nothing is selected
                }
              };

              $('.tab-pane.active.show [name="patient_id"]').select2({
                allowClear: true,
                placeholder: "Select a Patient",
                minimumInputLength: 3,
                ajax: {
                  url: '/api/v1/patient/',
                  dataType: 'json',
                  delay: 900,
                  data: function data(params) {
                    return {
                      query: params.term, // search term
                      page: params.page
                    };
                  },
                  processResults: function processResults(data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;
                    return {
                      results: data.objects,
                      pagination: { //todo: program the api for the pagination function
                        more: params.page * 10 < data.meta.total_count
                      }
                    };
                  },
                  //cache: true
                },
                escapeMarkup: function escapeMarkup(markup) {
                  return markup;
                },
                templateResult: formatDisplay,
                templateSelection: formatSelection
              }).on('select2:select', function (e) {
                var data = e.params.data;
              }).on('select2:clear', function (e) {
                //var data = e.params.data;
                $('.modal.shown form select[data-select2-id]').empty().trigger('select2:clear');
              });

              $(document).on('click', '[data-toggle="question"][data-remote]', function (e) {
                e.preventDefault();
                var question = $(this).data().question, url = $(this).data().remote;
                swalWithBootstrapButtons.fire({
                  title: 'Are you sure?',
                  text: question,
                  showCancelButton: true,
                  confirmButtonText: 'Yes!'
                }).then((result) => {
                  if (result.value) {
                    $.getJSON(url).then(function (e) {
                      if (e.status === 'success') {
                        $('[href^="#requests"].active').removeClass('active').tab('show');
                      } else {
                        swalWithBootstrapButtons.fire({
                          text: 'An error occurred',
                          icon: 'error',
                          showCancelButton: false,
                        })
                      }
                    });
                  }
                })
              }).on('click', '.has-outstanding', function (e) {
                e.preventDefault();
                var outstanding = $(this).data('value');
                swalWithBootstrapButtons.fire({
                  title: null,
                  html: 'Patient has an outstanding balance of ₦' + outstanding,
                  icon: 'error'
                })
              });

              $(document).off('click', '.pagination > .page-item > .page-link').on('click', '.pagination > .page-item > .page-link', function (e) {
                e.preventDefault();
                $('.pagination + [name="page"]').val($(this).data('page'));
                processFilter();

              });

              $(document).off('click', '#export-btn').on('click', '#export-btn', function (e) {
                let filters = $('.filterForm').serializeArray();
                _.remove(filters, function (n) {
                  return (n.name === 'start') || (n.name === 'stop')
                });
                filters.push({
                  name: 'create_time__range',
                  value: [$('.tab-pane.active.show [name="start"].filter').val(), $('.tab-pane.active.show [name="stop"].filter').val()]
                });
                let model = 'PatientVisit';
                let app = 'main';
                let fields_map = {
                  'Clinic': 'appointment__clinic__name',
                  'Specialty': 'appointment__specialty__name',
                  'Status': 'status',
                  'Date of Visit': 'create_time',
                  'Doctor ': 'consultationnote__create_uid__first_name',
                  'Doctor Last Name': 'consultationnote__create_uid__last_name'
                }
                // todo: the date filtering does not work
                exportReport(filters, app, model, fields_map);
              })
            })
          </script>

        </div>
      </div>

    </div>
  </div><!-- /metric row -->
</div>
@endsection
