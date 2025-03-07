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
          <div class="card">
            <!-- .card-header -->
            <div class="card-header">
              <form class="filterForm d-flex justify-content-between">
                <input type="hidden" name="csrfmiddlewaretoken" value="XPx19Rc8gKIcOTQb0MWG5sRB7E3jkMn38Y6JeSKbwATRDL1lHRhNMQddQPgL7alH">
                <div class="form-group flex-fill ml-2-">
                  <label class="mb-0" for="location_id">Filter By Location</label>
                  <select id="location_id" name="batch__location__id" class="custom-select form-control filter">
                    <option value="">- All -</option>
                    <option value="18">SOKOTO DIAGNOSTIC CENTRE</option>

                  </select>
                </div>

                <div class="form-group flex-fill- ml-3 no-label">
                  <button class="btn btn-primary px-3" style="margin-top: 1.26rem" type="button" id="export-btn">
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
                  <th>Drug/Generic</th>
                  <th class="text-right">Quantity</th>
                  <th>Date Expired</th>
                  <th>Location</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                <!-- tr -->

                <tr>
                  <td class="align-middle">Augmentin 625 (625) [Amoxicillin/clavulanic Acid]</td>
                  <td class="text-right">0</td>
                  <td class="align-middle">Feb. 1, 2023</td>
                  <td class="align-middle">SOKOTO DIAGNOSTIC CENTRE</td>
                  <td class="align-middle text-right">
                    <div class="dropdown">
                      <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                      <div class="dropdown-menu dropdown-menu-right">


                      </div>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td class="align-middle">Augmentin 625 (625) [Amoxicillin/clavulanic Acid]</td>
                  <td class="text-right">0</td>
                  <td class="align-middle">Nov. 1, 2024</td>
                  <td class="align-middle">SOKOTO DIAGNOSTIC CENTRE</td>
                  <td class="align-middle text-right">
                    <div class="dropdown">
                      <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                      <div class="dropdown-menu dropdown-menu-right">


                      </div>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td class="align-middle">Augmentin 625 (625) [Amoxicillin/clavulanic Acid]</td>
                  <td class="text-right">0</td>
                  <td class="align-middle">Feb. 1, 2024</td>
                  <td class="align-middle">SOKOTO DIAGNOSTIC CENTRE</td>
                  <td class="align-middle text-right">
                    <div class="dropdown">
                      <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                      <div class="dropdown-menu dropdown-menu-right">


                      </div>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td class="align-middle">Augmentin 1g (1G) [Amoxicillin/clavulanic Acid]</td>
                  <td class="text-right">0</td>
                  <td class="align-middle">Feb. 2, 2023</td>
                  <td class="align-middle">SOKOTO DIAGNOSTIC CENTRE</td>
                  <td class="align-middle text-right">
                    <div class="dropdown">
                      <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                      <div class="dropdown-menu dropdown-menu-right">


                      </div>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td class="align-middle">Augmentin 1g (1G) [Amoxicillin/clavulanic Acid]</td>
                  <td class="text-right">0</td>
                  <td class="align-middle">Jan. 1, 2024</td>
                  <td class="align-middle">SOKOTO DIAGNOSTIC CENTRE</td>
                  <td class="align-middle text-right">
                    <div class="dropdown">
                      <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                      <div class="dropdown-menu dropdown-menu-right">


                      </div>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td class="align-middle">Augmentin 1g (1G) [Amoxicillin/clavulanic Acid]</td>
                  <td class="text-right">0</td>
                  <td class="align-middle">Aug. 31, 2023</td>
                  <td class="align-middle">SOKOTO DIAGNOSTIC CENTRE</td>
                  <td class="align-middle text-right">
                    <div class="dropdown">
                      <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                      <div class="dropdown-menu dropdown-menu-right">


                      </div>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td class="align-middle">Ciprotab (500mg) [ciprofloxacin]</td>
                  <td class="text-right">0</td>
                  <td class="align-middle">Feb. 3, 2023</td>
                  <td class="align-middle">SOKOTO DIAGNOSTIC CENTRE</td>
                  <td class="align-middle text-right">
                    <div class="dropdown">
                      <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                      <div class="dropdown-menu dropdown-menu-right">


                      </div>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td class="align-middle">Ciprotab (500mg) [ciprofloxacin]</td>
                  <td class="text-right">0</td>
                  <td class="align-middle">April 30, 2024</td>
                  <td class="align-middle">SOKOTO DIAGNOSTIC CENTRE</td>
                  <td class="align-middle text-right">
                    <div class="dropdown">
                      <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                      <div class="dropdown-menu dropdown-menu-right">


                      </div>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td class="align-middle">Emgyl (400mg) [metronidazole]</td>
                  <td class="text-right">0</td>
                  <td class="align-middle">Feb. 2, 2023</td>
                  <td class="align-middle">SOKOTO DIAGNOSTIC CENTRE</td>
                  <td class="align-middle text-right">
                    <div class="dropdown">
                      <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                      <div class="dropdown-menu dropdown-menu-right">


                      </div>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td class="align-middle">Emgyl (400mg) [metronidazole]</td>
                  <td class="text-right">5</td>
                  <td class="align-middle">Aug. 31, 2024</td>
                  <td class="align-middle">SOKOTO DIAGNOSTIC CENTRE</td>
                  <td class="align-middle text-right">
                    <div class="dropdown">
                      <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                      <div class="dropdown-menu dropdown-menu-right">


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

                    <span class="page-link" href="javascript:"> 1 - 10 of 251</span>
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
        <div class="tab-pane fade" id="navs-justified-low-stock" role="tabpanel">
          <div class="card">
            <!-- .card-header -->
            <div class="card-header">
              <form class="filterForm d-flex justify-content-between">
                <input type="hidden" name="csrfmiddlewaretoken" value="Dtas4EWHvoAdIHbdzg2difH2oiPytyfhOCJa9FuKLeLSxzmnglnkZD3E7t20gWdV">
                <div class="form-group flex-fill ml-2-">
                  <label class="mb-0" for="location_id">Filter By Location</label>
                  <select id="location_id" name="batch__location__id" class="custom-select form-control filter">
                    <option value="">- All -</option>
                    <option value="18">SOKOTO DIAGNOSTIC CENTRE</option>

                  </select>
                </div>

                <div class="form-group flex-fill- ml-3 no-label">
                  <button class="btn btn-primary  px-3" style="margin-top: 1.26rem" type="button" id="export-btn">
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
                  <th>Drug/Generic</th>
                  <th class="text-right">Quantity</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                <!-- tr -->

                <tr>
                  <td class="align-middle">Volten [Diclofenac]</td>
                  <td class="text-right">0</td>
                  <td class="align-middle text-right">
                    <div class="dropdown">
                      <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                      <div class="dropdown-menu dropdown-menu-right">


                      </div>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td class="align-middle">Dexamethasone [Dexamethersone]</td>
                  <td class="text-right">0</td>
                  <td class="align-middle text-right">
                    <div class="dropdown">
                      <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                      <div class="dropdown-menu dropdown-menu-right">


                      </div>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td class="align-middle">Gonadil-f [Tribulus/zinc/vitamin E/Selenium]</td>
                  <td class="text-right">0</td>
                  <td class="align-middle text-right">
                    <div class="dropdown">
                      <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                      <div class="dropdown-menu dropdown-menu-right">


                      </div>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td class="align-middle">Cifixine [Cifixine]</td>
                  <td class="text-right">0</td>
                  <td class="align-middle text-right">
                    <div class="dropdown">
                      <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                      <div class="dropdown-menu dropdown-menu-right">


                      </div>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td class="align-middle">Treviamet [Sitagliptin/metformin]</td>
                  <td class="text-right">0</td>
                  <td class="align-middle text-right">
                    <div class="dropdown">
                      <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                      <div class="dropdown-menu dropdown-menu-right">


                      </div>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td class="align-middle">Devon Catheter [Consumable]</td>
                  <td class="text-right">0</td>
                  <td class="align-middle text-right">
                    <div class="dropdown">
                      <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                      <div class="dropdown-menu dropdown-menu-right">


                      </div>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td class="align-middle">Murnisik [Doxylamine/Pyridoxine/Folicacid]</td>
                  <td class="text-right">0</td>
                  <td class="align-middle text-right">
                    <div class="dropdown">
                      <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                      <div class="dropdown-menu dropdown-menu-right">


                      </div>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td class="align-middle">Bethanechol [Bethanechol chloride]</td>
                  <td class="text-right">0</td>
                  <td class="align-middle text-right">
                    <div class="dropdown">
                      <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                      <div class="dropdown-menu dropdown-menu-right">


                      </div>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td class="align-middle">Albendazole [Albendazole]</td>
                  <td class="text-right">0</td>
                  <td class="align-middle text-right">
                    <div class="dropdown">
                      <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                      <div class="dropdown-menu dropdown-menu-right">


                      </div>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td class="align-middle">Papaverine [Papaverine]</td>
                  <td class="text-right">0</td>
                  <td class="align-middle text-right">
                    <div class="dropdown">
                      <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                      <div class="dropdown-menu dropdown-menu-right">


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

                    <span class="page-link" href="javascript:"> 1 - 10 of 185</span>
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
      <div class="tab-pane fade" id="navs-justified-all" role="tabpanel">
        <div class="card">
          <!-- .card-header -->
          <div class="card-header">
            <form class="filterForm d-flex justify-content-between">
              <input type="hidden" name="csrfmiddlewaretoken" value="eoQrrh0Fb3gbr530oE9TjFkVXLzmi3JCpxp9wiyIrTrQgXea5Ju003GxGWMO5rHg">
              <div class="form-group flex-fill ml-2-">
                <label class="mb-0" for="location_id">Filter By Location</label>
                <select id="location_id" name="batch__location__id" class="custom-select form-control filter">
                  <option value="">- All -</option>
                  <option value="18">SOKOTO DIAGNOSTIC CENTRE</option>

                </select>
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
                <th>Drug/Generic</th>
                <th class="text-right">Quantity</th>
                <th></th>
              </tr>
              </thead>
              <tbody>
              <!-- tr -->

              <tr>
                <td class="align-middle">Volten [Diclofenac]</td>
                <td class="text-right">0</td>
                <td class="align-middle text-right">
                  <div class="dropdown">
                    <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                      <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                    <div class="dropdown-menu dropdown-menu-right">


                    </div>
                  </div>
                </td>
              </tr>

              <tr>
                <td class="align-middle">Vicryl 3/0 [Consumable]</td>
                <td class="text-right">12</td>
                <td class="align-middle text-right">
                  <div class="dropdown">
                    <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                      <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                    <div class="dropdown-menu dropdown-menu-right">


                    </div>
                  </div>
                </td>
              </tr>

              <tr>
                <td class="align-middle">Nylon 2/0 [Consumable]</td>
                <td class="text-right">12</td>
                <td class="align-middle text-right">
                  <div class="dropdown">
                    <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                      <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                    <div class="dropdown-menu dropdown-menu-right">


                    </div>
                  </div>
                </td>
              </tr>

              <tr>
                <td class="align-middle">Dexamethasone [Dexamethersone]</td>
                <td class="text-right">0</td>
                <td class="align-middle text-right">
                  <div class="dropdown">
                    <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                      <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                    <div class="dropdown-menu dropdown-menu-right">


                    </div>
                  </div>
                </td>
              </tr>

              <tr>
                <td class="align-middle">Neurovite forte [multivitamin /supplement]</td>
                <td class="text-right">1</td>
                <td class="align-middle text-right">
                  <div class="dropdown">
                    <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                      <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                    <div class="dropdown-menu dropdown-menu-right">


                    </div>
                  </div>
                </td>
              </tr>

              <tr>
                <td class="align-middle">Diazepen roch [Diazepam]</td>
                <td class="text-right">5</td>
                <td class="align-middle text-right">
                  <div class="dropdown">
                    <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                      <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                    <div class="dropdown-menu dropdown-menu-right">


                    </div>
                  </div>
                </td>
              </tr>

              <tr>
                <td class="align-middle">Frusamide [Frusamide]</td>
                <td class="text-right">40</td>
                <td class="align-middle text-right">
                  <div class="dropdown">
                    <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                      <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                    <div class="dropdown-menu dropdown-menu-right">


                    </div>
                  </div>
                </td>
              </tr>

              <tr>
                <td class="align-middle">Gonadil-f [Tribulus/zinc/vitamin E/Selenium]</td>
                <td class="text-right">0</td>
                <td class="align-middle text-right">
                  <div class="dropdown">
                    <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                      <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                    <div class="dropdown-menu dropdown-menu-right">


                    </div>
                  </div>
                </td>
              </tr>

              <tr>
                <td class="align-middle">Cifixine [Cifixine]</td>
                <td class="text-right">0</td>
                <td class="align-middle text-right">
                  <div class="dropdown">
                    <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                      <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                    <div class="dropdown-menu dropdown-menu-right">


                    </div>
                  </div>
                </td>
              </tr>

              <tr>
                <td class="align-middle">Treviamet [Sitagliptin/metformin]</td>
                <td class="text-right">0</td>
                <td class="align-middle text-right">
                  <div class="dropdown">
                    <button type="button" class="btn btn-sm btn-icon btn-light" data-toggle="dropdown" data-boundary="viewport" aria-expanded="false" aria-haspopup="true">
                      <i class="fa fa-ellipsis-v"></i> <span class="sr-only">Actions</span></button>
                    <div class="dropdown-menu dropdown-menu-right">


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

                  <span class="page-link" href="javascript:"> 1 - 10 of 223</span>
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
</div><!-- /metric row -->
</div>
@endsection
