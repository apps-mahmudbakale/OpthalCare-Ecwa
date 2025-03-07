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
    <h4>Procedure Reports</h4>

    <form class="filterForm d-flex justify-content-between">
      <input type="hidden" name="csrfmiddlewaretoken" value="mGF9TyxoJ8dcDRBUfNhYQbSTbMGcN3c53yLRO06sQLRSTCTtZneZwul6MeBgsAT0">
      <div class="form-group flex-fill ml-2-">
        <label class="mb-0" for="location_id">Filter By Theatre</label>
        <select id="location_id" name="location_id" class="custom-select form-control filter">
          <option value="">- All -</option>
          <option value="22">A &amp; E THEATER</option>

          <option value="23">LABOUR WARD THEATER</option>

          <option value="19">MAIN THEATER</option>

        </select>
      </div>
      <div class="form-group flex-fill ml-2">
        <label class="mb-0" for="id_category">Filter By Category</label>
        <select id="id_category" name="category_id" class="custom-select form-control filter">
          <option value="">- All -</option>
          <option value="1">Surgical</option>

          <option value="23">DIALYSIS</option>

          <option value="24">PHYSIOTHERAPY</option>

          <option value="25">UPPER GI ENDOSCOPY</option>

          <option value="26">COLONOSCOPY</option>

          <option value="27">Oncology</option>

          <option value="28">Oxygen Plant</option>

          <option value="29">ICU UNIT</option>

          <option value="10">GENERAL SURGERY</option>

          <option value="11">UROLOGY</option>

          <option value="12">OBSTETRICS AND GYNAECOLOGY</option>

          <option value="13">INTERMEDIATE PROCEDURES</option>

          <option value="14">MINOR PROCEDURES &amp; OTHER SERVICES</option>

          <option value="15">ENT PROCEDURES</option>

          <option value="16">OPTICAL PROCEDURES</option>

          <option value="17">ORTHOPAEDIC AND PLASTIC SURGERY PROCEDURES</option>

          <option value="18">DENTAL PROCEDURES</option>

          <option value="19">CARDIOTHORACIC PROCEDURES</option>

          <option value="20">NEUROLOGY PROCEDURES</option>

          <option value="21">Pediatrics</option>

          <option value="22">FAMILY PLANNING SERVICE</option>

        </select>
      </div>
      <div class="form-group flex-fill ml-2 no-label">
        <div class="custom-control custom-control-inline custom-checkbox mt-1">
          <input title="" type="checkbox" name="done-in-theatre" id="done-in-theatre" class="custom-control-input filter">
          <label class="custom-control-label" for="done-in-theatre">Done in Theatre?</label>
        </div>
      </div>
      <div class="form-group flex-fill ml-2">
        <input type="hidden" name="start" class="filter sr-only">
        <input type="hidden" name="stop" class="filter sr-only">
        <label for="reportrange" class="mb-0">Filter By Procedure Date</label>
        <div id="reportrange" class="form-control d-flex custom-select">
          <i class="mt-1 fa fa-calendar"></i>&nbsp;
          <span>03/7/2025 - 03/7/2025</span>
        </div>
      </div>
      <div class="form-group flex-fill- ml-3 no-label">
        <button class="btn btn-primary mt-n1 px-3" type="button" id="export-btn">
          <i class="fa fa-download"></i> Export to File
        </button>
      </div>
    </form>
  </div><!-- /metric row -->
</div>
@endsection
