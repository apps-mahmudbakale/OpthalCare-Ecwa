@extends('layouts/layoutMaster')

@section('title', 'Admission Request')

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
    <div class="card">

        <!-- .card-header -->
        <div class="card-header ">
            <form method="post" class="filterForm d-flex justify-content-between flex-fill">
                <input type="hidden" name="csrfmiddlewaretoken"
                    value="lnr6cDC6aTnlpOdsTlfsTkDxkrx4LsYuF9PMSCTGoGuOhKrxjApe1RpDI91GCuZu">
                <div class="form-group flex-fill">
                    <label class="" for="patient_id">Filter By Patient</label>
                    <select name="patient_id" id="patient_id" class="form-control filter select2-hidden-accessible"
                        title="" data-placeholder="Filter by Patient" data-select2-id="patient_id" tabindex="-1"
                        aria-hidden="true"></select><span class="select2 select2-container select2-container--default"
                        dir="ltr" data-select2-id="2" style="width: 100%;"><span class="selection"><span
                                class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true"
                                aria-expanded="false" title="" tabindex="0"
                                aria-labelledby="select2-patient_id-container"><span class="select2-selection__rendered"
                                    id="select2-patient_id-container" role="textbox" aria-readonly="true"><span
                                        class="select2-selection__placeholder">Filter by Patient</span></span><span
                                    class="select2-selection__arrow" role="presentation"><b
                                        role="presentation"></b></span></span></span><span class="dropdown-wrapper"
                            aria-hidden="true"></span></span>
                </div>
                <div class="form-group flex-fill ml-2">
                    <label class="" for="ward_id">Filter By Ward</label>
                    <select name="ward_id" id="ward_id" class="custom-select form-control filter">
                        <option value="">- All -</option>

                        <option value="3">ACCIDENT &amp; EMERGENCY</option>

                        <option value="5">FEMALE AMINITY</option>

                        <option value="2">FEMALE WARD</option>

                        <option value="6">MALE AMINITY</option>

                        <option value="1">MALE WARD</option>

                        <option value="4">PEDIATRIC WARD</option>

                    </select>
                </div>

            </form>
        </div><!-- /.card-header -->
        <!-- .table-responsive -->
        <div class="table-responsive">
            <!-- .table -->
            <table class="table table-striped-">
                <!-- thead -->
                <thead>
                    <tr>
                        <th>Date Admitted</th>
                        <th>Patient</th>
                        <th>Ward</th>
                        <th>Bed</th>
                        <th class="align-middle text-right">*</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- tr -->

                    <tr>
                        <td class="align-middle">Oct. 30, 2023, 12:30 p.m.</td>
                        <td class="align-middle">
                            <a href="/admissions/requests/32">Alh, Umar Majo [CID020106]</a>
                        </td>
                        <td class="align-middle">MALE WARD</td>
                        <td class="align-middle">- -</td>
                        <td class="align-middle text-right">
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown"
                                    data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                                    <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="/admissions/requests/32">Open Instance</a>

                                    <button class="dropdown-item" data-remote="/admissions/requests/32/assign-bed"
                                        data-toggle="modal" data-target="#blankModal">
                                        Assign Bed
                                    </button>

                                </div>
                            </div>

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
@endsection
