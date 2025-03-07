@extends('layouts/layoutMaster')

@section('title', 'Labouratory Report')

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
    <h4>Labouratory Reports</h4>
    <div class="nav-align-top nav-tabs-shadow mb-6">
      <ul class="nav nav-tabs nav-fill" role="tablist">
        <li class="nav-item" role="presentation">
          <button type="button" class="nav-link waves-effect active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-requests" aria-controls="navs-justified-expired" aria-selected="true"><span class="d-none d-sm-block"><i class="tf-icons ti ti-layout-grid ti-sm ti-sm me-1_5"></i> Requests  Lists </span><i class="ti ti-layout-grid ti-sm d-sm-none"></i></button>
        </li>
        <li class="nav-item" role="presentation"></li>
        <li class="nav-item" role="presentation"></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade active show" id="navs-justified-requests" role="tabpanel">
          <div class="card">
            <!-- .card-header -->
            <div class="card-header">
              <form class="filterForm d-flex justify-content-between">
                <input type="hidden" name="csrfmiddlewaretoken" value="j3cQmVrbruQAyVXWdDbt2X1ZKfgYpbXRucLyrWZeHk1fnN86UIwAJlnBtqtqczVv">
                <div class="form-group flex-fill ml-2">
                  <label class="mb-0" for="id_category">Filter By Category</label>
                  <select id="id_category" name="category_id" class="custom-select form-control filter">
                    <option value="">- All -</option>
                    <option value="22">ALLERGY</option>

                    <option value="35">ANDROLOGY</option>

                    <option value="40">BLOOD</option>

                    <option value="18">BONE TURNOVER</option>

                    <option value="36">CHEMISTRY</option>

                    <option value="14">COAGULATION</option>

                    <option value="28">CSF</option>

                    <option value="27">CYTOGENETICS</option>

                    <option value="25">CYTOLOGY</option>

                    <option value="41">FERTILITY HORMOES</option>

                    <option value="30">FLOW CYTOMETRY</option>

                    <option value="5">GENERAL CHEMISTRY/KIDNEY</option>

                    <option value="1">GENERAL ENDOCRINE</option>

                    <option value="2">GLUCOSE METABOLISM</option>

                    <option value="13">HAEMATOLOGY</option>

                    <option value="21">HEART/MUSCLE</option>

                    <option value="43">HEMATO</option>

                    <option value="37">HEMATOLOGY</option>

                    <option value="19">HISTOLOGY (LARGE BIOPSIES)</option>

                    <option value="16">HISTOLOGY (MEDIUM BIOPSIES)</option>

                    <option value="4">HISTOLOGY (SMALL BIOPSIES)</option>

                    <option value="23">HIV TESTS</option>

                    <option value="24">HPLC DEPARTMENT</option>

                    <option value="20">IMMUNOLOGY</option>

                    <option value="29">IRON STUDIES</option>

                    <option value="26">LIPID METABOLISM</option>

                    <option value="10">LIVER/PANCREAS/GIT</option>

                    <option value="17">MICROBIOLOGY</option>

                    <option value="34">MOLECULAR BIOLOGY (PCR)</option>

                    <option value="31">NUTRITION</option>

                    <option value="38">PARASITOLOGY</option>

                    <option value="7">PATERNITY</option>

                    <option value="11">PHARMACOLOGY/TOXICOLOGY</option>

                    <option value="15">PREGNANCY</option>

                    <option value="42">PUS</option>

                    <option value="6">SEROLOGY</option>

                    <option value="12">SPECIAL HISTOLOGY</option>

                    <option value="8">TB DEPARTMENT</option>

                    <option value="32">THYROID</option>

                    <option value="33">TISSUE TYPING</option>

                    <option value="9">TUMOUR MARKERS</option>

                    <option value="3">URINE</option>

                    <option value="39">VIROLOGY/PCR</option>

                  </select>
                </div>
                <div class="form-group flex-fill ml-2">
                  <label class="mb-0" for="id_status">Filter By Request Status</label>
                  <select id="id_status" name="status" class="custom-select form-control filter">
                    <option value="">- All -</option>
                    <option value="pending">Pending</option>

                    <option value="specimen">Sample Submitted</option>

                    <option value="result_unapproved">Awaiting Result Approval</option>

                    <option value="done">Result Ready</option>

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
                  <button class="btn btn-primary  px-3" style="margin-top: 1.26rem" type="button" id="export-btn">
                    <i class="fa fa-download"></i>
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
                  <th>Investigation</th><th>Category</th><th># of Requests</th>
                </tr>
                </thead>
                <tbody>
                <!-- tr -->

                <tr>

                  <td>PROGESTERONE_SOKOTO (GENERAL ENDOCRINE)</td>
                  <td>GENERAL ENDOCRINE</td>
                  <td>54</td>
                </tr>

                <tr>

                  <td>2H POST PRANDIA(GLUCOSE)_SOKOTO (GLUCOSE METABOLISM)</td>
                  <td>GLUCOSE METABOLISM</td>
                  <td>275</td>
                </tr>

                <tr>

                  <td>5HIAA-24HR URINE (URINE)</td>
                  <td>URINE</td>
                  <td>0</td>
                </tr>

                <tr>

                  <td>ABCESS (HISTOLOGY (SMALL BIOPSIES))</td>
                  <td>HISTOLOGY (SMALL BIOPSIES)</td>
                  <td>0</td>
                </tr>

                <tr>

                  <td>ACE (GENERAL CHEMISTRY/KIDNEY)</td>
                  <td>GENERAL CHEMISTRY/KIDNEY</td>
                  <td>0</td>
                </tr>

                <tr>

                  <td>ACETYLCHOLINE RECEP AB (SEROLOGY)</td>
                  <td>SEROLOGY</td>
                  <td>0</td>
                </tr>

                <tr>

                  <td>ACETYLCHOLINESTERASE (GENERAL CHEMISTRY/KIDNEY)</td>
                  <td>GENERAL CHEMISTRY/KIDNEY</td>
                  <td>0</td>
                </tr>

                <tr>

                  <td>ACETYLCHOLINESTERASE(RBC) (URINE)</td>
                  <td>URINE</td>
                  <td>0</td>
                </tr>

                <tr>

                  <td>ACTH_sokoto (GENERAL ENDOCRINE)</td>
                  <td>GENERAL ENDOCRINE</td>
                  <td>2</td>
                </tr>

                <tr>

                  <td>ADDITIONAL CHILD (PATERNITY)</td>
                  <td>PATERNITY</td>
                  <td>0</td>
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

                    <span class="page-link" href="javascript:"> 1 - 10 of 623</span>
                  </li>


                  <li class="page-item">
                    <a class="page-link" href="javascript:" data-page="2" data-href="?page=2">Next <span class="oi oi-arrow-right"></span></a>
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
