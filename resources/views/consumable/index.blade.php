@extends('layouts/layoutMaster')

@section('title', 'Consumables Request')

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
        <div class="card-header">
            <form class="filterForm d-flex justify-content-between">
                <input type="hidden" name="csrfmiddlewaretoken"
                    value="dqupTaMQUIkgkGUwRJW0hZxIc6uBOkyvxcS5z93q8vrJcC8BhY6MpwjOAOYdFmzv">
                <div class="form-group flex-fill">
                    <label class="" for="patient_id">Filter By Patient</label>
                    <select name="patient_id" id="patient_id" class="form-control select2-hidden-accessible" title=""
                        data-placeholder="Filter by Patient" data-select2-id="patient_id" tabindex="-1"
                        aria-hidden="true"></select><span class="select2 select2-container select2-container--default"
                        dir="ltr" data-select2-id="1" style="width: 100%;"><span class="selection"><span
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
                    <label class="" for="location_id">Filter By Location</label>
                    <select id="location_id" name="location_id" class="custom-select form-control">
                        <option value="">- All -</option>
                        <option value="9">CLINICS</option>

                        <option value="10">DENTAL</option>

                        <option value="21">EEG</option>

                        <option value="23">ENDOSCOPY</option>

                        <option value="19">LABORATORY</option>

                        <option value="8">NEUROLOGY</option>

                        <option value="22">OPHTHALMIC</option>

                        <option value="11">RADIOLOGY</option>

                        <option value="20">WORDS</option>

                    </select>
                </div>
                <div class="form-group flex-fill ml-2">
                    <input type="hidden" name="start" class="filter sr-only">
                    <input type="hidden" name="stop" class="filter sr-only">
                    <label for="reportrange">Filter By Request Date</label>
                    <div id="reportrange" class="form-control d-flex custom-select">
                        <i class="mt-1 fa fa-calendar"></i>&nbsp;
                        <span>12/15/2023 - 12/15/2023</span>
                    </div>
                </div>
            </form>
        </div><!-- /.card-header -->
        <!-- .table-responsive -->
        <div class="table-responsive">
            <!-- .table -->
            <table class="table">
                <!-- thead -->
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Patient</th>
                        <th>Item</th>
                        <th>Requester</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <!-- tr -->

                    <tr>
                        <td colspan="6">
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
@endsection
