@extends('layouts/layoutMaster')

@section('title', 'Procedure Request')

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
                    value="9FTFq3rFz0Gp2pJGsH2GRatBzroRxc6Etrhl62IfNNNSUlXLSWcsZHfHX9Stoe7E">
                <div class="form-group flex-fill">
                    <label class="" for="patient_id">Filter By Patient</label>
                    <select name="patient_id" id="patient_id" class="filter select2-hidden-accessible"
                        data-placeholder="Filter By Patient" data-select2-id="patient_id" tabindex="-1"
                        aria-hidden="true"></select><span class="select2 select2-container select2-container--default"
                        dir="ltr" data-select2-id="1" style="width: 100%;"><span class="selection"><span
                                class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true"
                                aria-expanded="false" tabindex="0" aria-labelledby="select2-patient_id-container"><span
                                    class="select2-selection__rendered" id="select2-patient_id-container" role="textbox"
                                    aria-readonly="true"><span class="select2-selection__placeholder">Filter By
                                        Patient</span></span><span class="select2-selection__arrow" role="presentation"><b
                                        role="presentation"></b></span></span></span><span class="dropdown-wrapper"
                            aria-hidden="true"></span></span>
                </div>
                <div class="form-group flex-fill ml-2">
                    <label class="" for="id_category">Filter By Category</label>
                    <select id="id_category" name="category" class="custom-select form-control filter">
                        <option value="">- All -</option>

                        <option value="1">OPHTHALMIC</option>

                        <option value="2">ENT</option>

                        <option value="4">NEUROSURGERY</option>

                        <option value="5">GENERAL SURGERY</option>

                        <option value="6">DERMATOLOGY</option>

                        <option value="7">EMERGENCY SERVICES</option>

                        <option value="8">UROLOGY</option>

                        <option value="3">DENTAL</option>

                        <option value="9">ORTHOPEDICS</option>

                    </select>
                </div>
                <div class="form-group flex-fill ml-2">
                    <input type="hidden" name="start" class="filter sr-only">
                    <input type="hidden" name="stop" class="filter sr-only">
                    <label for="reportrange">Filter By Request Date</label>
                    <div id="reportrange" class="form-control d-flex custom-select filter">
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
                        <th>Request Date</th>
                        <th>Patient</th>
                        <th>Procedure</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <!-- tr -->

                    <tr>
                        <td class="align-middle"><a href="/procedures/requests/8/">Jan. 13, 2023, 3:53 p.m.</a></td>
                        <td class="align-middle">Umar, Bashar Kwabo [CID000492] </td>
                        <td class="align-middle">Air Syringing</td>
                        <td class="align-middle">ENT</td>
                        <td class="align-middle">Active</td>
                        <td class="align-middle text-right">
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown"
                                    data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                                    <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                                <div class="dropdown-menu dropdown-menu-right">

                                    <a class="lab-request-action- dropdown-item" href="/procedures/requests/8/">
                                        Open Instance
                                    </a>

                                    <button class="dropdown-item" data-toggle="question" data-question="Cancel Request?"
                                        data-remote="/procedures/requests/8/cancel" type="button">
                                        Cancel Procedure
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

                        <span class="page-link" href="javascript:"> 1 - 10 of 111</span>
                    </li>


                    <li class="page-item">
                        <a class="page-link" href="javascript:" data-page="2" data-href="?active=true&amp;page=2">Next
                            <span class="oi oi-arrow-right"></span></a>
                    </li>

                </ul>
                <input type="hidden" class="sr-only filter" name="page" value="1">

            </div>


        </div><!-- /.table-responsive -->

    </div>
@endsection
