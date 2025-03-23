@extends('layouts/layoutMaster')

@section('title', 'Vital Care Settings')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/cards-advance.js') }}"></script>
    {{-- <script src="{{asset('assets/js/modal-edit-user.js')}}"></script> --}}
    <script src="https://unpkg.com/papaparse@latest/papaparse.min.js"></script>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Settings</span>
    </h4>

    <div class="row">
        <!-- Monthly Campaign State -->
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">System Settings</h5>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="MonthlyCampaign" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                data-bs-target="#editSystem">View/Update</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6>Change System Settings Here</h6>
                    <form action="{{ route('app.update.system.settings') }}" method="POST" enctype="multipart/form-data"
                        class="row">
                        @csrf
                        <div class="form-group col-md-6">
                            Clinic Name
                            <input type="text" name="clinic_name" value="{{ $system->clinic_name }}"
                                class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            Clinic Logo
                            <input type="file" name="logo" value="" class="form-control">
                        </div>
<!--                        <div class="form-group col-md-6">-->
<!--                            Clinic Favicon-->
<!--                            <input type="file" name="favicon" value="" class="form-control">-->
<!--                        </div>-->
                        <div class="form-group col-md-6">
                            Footer
                            <input type="text" class="form-control" name="footer" value="{{ $system->footer }}">
                        </div>
                        <div class="form-group col-md-6">
                            Medical Record Number Prefix
                            <input type="text" class="form-control" name="number_prefix"
                                value="{{ $system->number_prefix }}">
                        </div>
                        <div class="form-group col-md-4">
                            <p></p>
                            <div class="text-light small fw-medium mb-3">Insurrance Providers</div>
                            <label class="switch">
                                <input type="checkbox" name="insurance_providers"
                                    {{ $system->insurance_providers ? 'checked' : '' }} class="switch-input">
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                </span>
                                <span class="switch-label">{{ $system->insurance_providers ? 'ON' : 'OFF' }} </span>
                            </label>
                        </div>
                        <div class="form-group col-md-4">
                            <p></p>
                            <div class="text-light small fw-medium mb-3">Auto Billing</div>
                            <label class="switch">
                                <input type="checkbox" name="auto_bill" {{ $system->auto_bill ? 'checked' : '' }}
                                    class="switch-input">
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                </span>
                                <span class="switch-label">{{ $system->auto_bill ? 'ON' : 'OFF' }} </span>
                            </label>

                        </div>
                        <div class="form-group col-md-4">
                            <p></p>
                            <div class="text-light small fw-medium mb-3">Auto Check-In</div>
                            <label class="switch">
                                <input type="checkbox" name="check_in" {{ $system->check_in ? 'checked' : '' }}
                                    class="switch-input">
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                </span>
                                <span class="switch-label">{{ $system->check_in ? 'ON' : 'OFF' }} </span>
                            </label>

                        </div>
                        <div class="form-group col-md-12">
                            Address
                            <textarea class="form-control" rows="10" name="address">{{ $system->address }}</textarea>
                        </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Departments</h5>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="earningReports" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReports">
                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                data-bs-target="#newDepartment">New Department</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pb-0">
                    <livewire:department />
                </div>
            </div>
        </div>
        <!--/ Earning Reports -->

        <!-- Browser States -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title m-0 me-2">
                        <h5 class="m-0 me-2">Documents</h5>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="employeeList" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="employeeList">
                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                data-bs-target="#newDocument">New Document</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <livewire:document />
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title m-0 me-2">
                        <h5 class="m-0 me-2">ICD</h5>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="employeeList" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="employeeList">
                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                data-bs-target="#new-icd-modal">New ICD</a>
                          <a class="dropdown-item" href="javascript:void(0);" id="import-icd" data-request-url="{{ route('app.icd.create') }}"
                             data-toggle="modal" data-target="#global-modal">Import ICD</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <livewire:i-c-d />
                    @include('_partials._modals.modal-new-icd')
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title m-0 me-2">
                        <h5 class="m-0 me-2">Patient Tags</h5>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="employeeList" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="employeeList">
                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                data-bs-target="#modal-new-tag">New Tag</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <livewire:tags />
                    @include('_partials._modals.modal-new-tag')
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title m-0 me-2">
                        <h5 class="m-0 me-2">Vital Reference</h5>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="employeeList" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="employeeList">
                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                data-bs-target="#modal-new-vital-ref">New Reference</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <livewire:vital-refs />
                    @include('_partials._modals.modal-new-vital-ref')
                </div>
            </div>
        </div>
      <div class="col-xl-6 col-md-6 mb-4">
        <div class="card h-100">
          <div class="card-header d-flex justify-content-between">
            <div class="card-title m-0 me-2">
              <h5 class="m-0 me-2">Payment Methods</h5>
            </div>
            <div class="dropdown">
              <button class="btn p-0" type="button" id="employeeList" data-bs-toggle="dropdown"
                      aria-haspopup="true" aria-expanded="false">
                <i class="ti ti-dots-vertical ti-sm text-muted"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="employeeList">
                <a class="dropdown-item" href="javascript:void(0);" id="add-payment-method"
                   data-request-url="{{ route('app.payments.new-method') }}">Add Payment Method</a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <livewire:payment-methods />
            @include('_partials._modals.modal-new-cash-point')
          </div>
        </div>
      </div>
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title m-0 me-2">
                        <h5 class="m-0 me-2">Cash Points</h5>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="employeeList" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="employeeList">
                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                data-bs-target="#modal-new-cash-point">New Cash Point</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <livewire:cashpoints />
                    @include('_partials._modals.modal-new-cash-point')
                </div>
            </div>
        </div>
        @if ($system->insurance_providers)
            <!-- Sales By Country -->
            <div class="col-xl-12 col-md-12 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">HMO Groups</h5>
                            {{-- <small class="text-muted">Monthly Sales Overview</small> --}}
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="salesByCountry" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesByCountry">
                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                    data-bs-target="#newHmoGroup">New Hmo Group</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <livewire:hmo-groups />
                    </div>
                </div>
            </div>
            <!--/ Sales By Country -->
            <div class="col-xl-12 col-md-12 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">HMO Plans</h5>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="salesByCountry" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesByCountry">
                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                    data-bs-target="#newHmoGroup">New Hmo Group</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <livewire:hmo-groups />
                    </div>
                </div>
            </div>
        @endif
        <!--/ Sales By Country -->
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Religions</h5>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="salesByCountry" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesByCountry">
                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                data-bs-target="#new-religion-modal">New Religion</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <livewire:religions />
                </div>
            </div>
        </div>
        <!--/ Sales By Country -->
        <h2>Tariffs</h2>
        <!--/ Browser States -->
        <div class="col-md-6 col-xl-4 mb-4">

            <div class="card h-100">
                <div class="card-body">
                    <h4 class="mb-2 pb-1">Admissions</h4>
                    <p class="small">Manage Wards, Beds, Routes for Fluid Chart</p>
                    <a href="{{ route('app.settings.admission') }}"
                        class="btn btn-primary w-100 waves-effect waves-light">Open</a>
                </div>
            </div>

        </div>
        <div class="col-md-6 col-xl-4 mb-4">

            <div class="card h-100">
                <div class="card-body">
                    <h4 class="mb-2 pb-1">Ophthicals</h4>
                    <p class="small">Manage Ophthical Tariffs, and Other Data</p>
                    <a href="{{ route('app.settings.antenatal') }}"
                        class="btn btn-primary w-100 waves-effect waves-light">Open</a>
                </div>
            </div>

        </div>
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="mb-2 pb-1">Consultations</h4>
                    <p class="small">Configure Consultation Locations, Manage Specialties, Consultation Documentation
                        Templates</p>
                    <a href="{{ route('app.settings.consultations') }}"
                        class="btn btn-primary w-100 waves-effect waves-light">Open</a>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-6 col-xl-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="mb-2 pb-1">Consumables</h4>
                    <p class="small">Manage Medical Consumables and Stock</p>
                    <a href="{{ route('app.settings.consumables') }}"
                        class="btn btn-primary w-100 waves-effect waves-light">Open</a>
                </div>
            </div>
        </div> --}}
        {{-- <div class="col-md-6 col-xl-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="mb-2 pb-1">Dialysis</h4>
                    <p class="small">Manage Dialysis Locations, Services, Machines, and Other Data</p>
                    <a href="{{ route('app.settings.dialysis') }}"
                        class="btn btn-primary w-100 waves-effect waves-light">Open</a>
                </div>
            </div>
        </div> --}}
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="mb-2 pb-1">Laboratory</h4>
                    <p class="small">Configure Laboratory Locations, Manage Lab Tests, Report Layouts</p>
                    <a href="{{ route('app.settings.laboratory') }}"
                        class="btn btn-primary w-100 waves-effect waves-light">Open</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="mb-2 pb-1">Medical Procedures</h4>
                    <p class="small">Manage Medical Procedures, Locations, Categories</p>
                    <a href="{{ route('app.settings.procedures') }}"
                        class="btn btn-primary w-100 waves-effect waves-light">Open</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="mb-2 pb-1">Pharmacy</h4>
                    <p class="small">Configure Pharmacy Locations, Manage Drugs and Batches and Drug Inventory</p>
                    <a href="{{ route('app.settings.pharmacy') }}"
                        class="btn btn-primary w-100 waves-effect waves-light">Open</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="mb-2 pb-1">Radiology</h4>
                    <p class="small">Configure Radiology Locations, Manage Radiological Investigations, Report Layouts</p>
                    <a href="{{ route('app.settings.radiology') }}"
                        class="btn btn-primary w-100 waves-effect waves-light">Open</a>
                </div>
            </div>
        </div>
    </div>
    @include('_partials/_modals/modal-system-settings')
    @include('_partials._modals.global-modal')
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function() {
    $('#import-icd').on('click', function() {
      var requestUrl = $(this).data('request-url');

      $.ajax({
        url: requestUrl,
        type: 'GET',
        success: function(response) {
          // Assuming the response contains the HTML for the modal content
          $('#global-modal .modal-body').html(response);
          $('#global-modal').modal('show');
        },
        error: function(xhr, status, error) {
          // Handle errors
          console.error(error);
        }
      });
    });
    $('#add-payment-method').on('click', function() {
      var requestUrl = $(this).data('request-url');

      $.ajax({
        url: requestUrl,
        type: 'GET',
        success: function(response) {
          // Assuming the response contains the HTML for the modal content
          $('#global-modal .modal-body').html(response);
          $('#global-modal').modal('show');
        },
        error: function(xhr, status, error) {
          // Handle errors
          console.error(error);
        }
      });
    });
  });
</script>
