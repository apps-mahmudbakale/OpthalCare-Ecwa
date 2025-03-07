@extends('layouts/layoutMaster')

@section('title', 'Radiology Report')

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
    <h4>Billing Reports</h4>
    <div class="d-flex"><!-- .nav-scroller --><div class="nav-scroller border-bottom"><!-- .nav-tabs --><ul class="nav nav-tabs"><li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab-revenue" data-remote="/reports/billing/revenue">Revenue </a></li><li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-cashpoints" data-remote="/reports/billing/payments">Cash Points </a></li><li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-end-of-day" data-remote="/reports/billing/end-of-day-cash"> Cashier's End of Day </a></li><li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-insurance-enrollees" data-remote="/reports/billing/insurance-enrollees">Insurance Enrollees </a></li></ul><!-- /.nav-tabs --></div><!-- /.nav-scroller --></div><!-- .tab-content --><div class="tab-content pt-4"><div class="tab-pane fade active show" id="tab-revenue" role="tabpanel"><div class="card">
          <!-- .card-header -->
          <div class="card-header">
            <form class="filterForm d-flex justify-content-between">
              <input type="hidden" name="csrfmiddlewaretoken" value="AxOZYTQaIW7Zo0Vt2DyR427Eh3rhh4NshpUHTlpePzLFELd2MdvSKlARSvmlWBun">
              <div class="form-group flex-fill">
                <label class="mb-0" for="category_id">Source</label>
                <div class="dropdown bootstrap-select filter form-control"><select name="service__category" id="category_id" data-live-search="true" class="filter form-control selectpicker" tabindex="-98">
                    <option value="">- All -</option>
                    <option value="lab">Laboratory</option>

                    <option value="pharmacy">Pharmacy</option>

                    <option value="radiology">Radiology</option>

                    <option value="consultation">Consultancy</option>

                    <option value="admissions">Admissions</option>

                    <option value="consumables">Medical Consumables</option>

                    <option value="antenatal">Antenatal</option>

                    <option value="procedures">Medical Procedures</option>

                    <option value="dialysis">Dialysis</option>

                    <option value="medicalreport">Medical Reports</option>

                    <option value="vaccination">Vaccination</option>

                  </select><button type="button" class="custom-select dropdown-toggle" data-toggle="dropdown" role="combobox" aria-owns="bs-select-1" aria-haspopup="listbox" aria-expanded="false" data-id="category_id" title="- All -"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner">- All -</div></div> </div></button><div class="dropdown-menu "><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" role="combobox" aria-label="Search" aria-controls="bs-select-1" aria-autocomplete="list"></div><div class="inner show" role="listbox" id="bs-select-1" tabindex="-1"><ul class="dropdown-menu inner show" role="presentation"></ul></div></div></div>
              </div>
              <div class="form-group flex-fill ml-2">
                <label class="mb-0" for="id_location">Location</label>
                <div class="dropdown bootstrap-select custom-select- form-control filter"><select id="id_location" name="location_id" data-live-search="true" class="custom-select- selectpicker form-control filter" tabindex="-98">
                    <option value="">- All -</option>

                    <option data-category="antenatal" value="17">
                      (Antenatal) ANTENATAL CLINIC</option>
                    <option data-category="billing" value="1">
                      (Billing) CASH POINT 1  (MAIN)</option>
                    <option data-category="billing" value="2">
                      (Billing) CASH POINT 2 (PHARMACY)</option>
                    <option data-category="billing" value="53">
                      (Billing) CASH POINT 3 (A &amp; E)</option>
                    <option data-category="consultation" value="30">
                      (Consultancy) CARDIOLOGY CONS ROOM</option>
                    <option data-category="consultation" value="13">
                      (Consultancy) CONSULTING ROOM 1</option>
                    <option data-category="consultation" value="3">
                      (Consultancy) CONSULTING ROOM 1</option>
                    <option data-category="consultation" value="14">
                      (Consultancy) CONSULTING ROOM 1</option>
                    <option data-category="consultation" value="20">
                      (Consultancy) CONSULTING ROOM 1</option>
                    <option data-category="consultation" value="9">
                      (Consultancy) CONSULTING ROOM 2</option>
                    <option data-category="consultation" value="21">
                      (Consultancy) CONSULTING ROOM 2</option>
                    <option data-category="consultation" value="12">
                      (Consultancy) CONSULTING ROOM 2</option>
                    <option data-category="consultation" value="10">
                      (Consultancy) CONSULTING ROOM 3</option>
                    <option data-category="consultation" value="11">
                      (Consultancy) CONSULTING ROOM 4</option>
                    <option data-category="consultation" value="26">
                      (Consultancy) DEMATHOLOGY CONS ROOM</option>
                    <option data-category="consultation" value="27">
                      (Consultancy) DIETICIAN CONS ROOM</option>
                    <option data-category="consultation" value="25">
                      (Consultancy) ENDOCRINIOLOGY CONS ROOM</option>
                    <option data-category="consultation" value="24">
                      (Consultancy) ENT CONSULTATION ROOM</option>
                    <option data-category="consultation" value="28">
                      (Consultancy) GASTROLOGY CONS ROOM</option>
                    <option data-category="consultation" value="43">
                      (Consultancy) GYNAE EMERGENCY</option>
                    <option data-category="consultation" value="15">
                      (Consultancy) GYNAE EMERGENCY</option>
                    <option data-category="consultation" value="29">
                      (Consultancy) NEUROLOGY CONS ROOM</option>
                    <option data-category="consumables" value="46">
                      (Medical Consumables) EPU</option>
                    <option data-category="consumables" value="50">
                      (Medical Consumables) GOPD PHARMACY</option>
                    <option data-category="consumables" value="42">
                      (Medical Consumables) GOPD STATION</option>
                    <option data-category="consumables" value="51">
                      (Medical Consumables) LABOUR WARD</option>
                    <option data-category="consumables" value="47">
                      (Medical Consumables) PAEDEATRICS</option>
                    <option data-category="consumables" value="16">
                      (Medical Consumables) PHARMACY 1</option>
                    <option data-category="consumables" value="41">
                      (Medical Consumables) THEATRE STATION</option>
                    <option data-category="dialysis" value="45">
                      (Dialysis) GENERAL ROOM</option>
                    <option data-category="dialysis" value="44">
                      (Dialysis) VIP ROOM</option>
                    <option data-category="lab" value="5">
                      (Laboratory) CHEM PATH</option>
                    <option data-category="lab" value="8">
                      (Laboratory) HEMATOLOGY</option>
                    <option data-category="lab" value="7">
                      (Laboratory) MEDICAL MICROBIOLOGY</option>
                    <option data-category="pharmacy" value="48">
                      (Pharmacy) FAMILY PLANNING</option>
                    <option data-category="pharmacy" value="6">
                      (Pharmacy) GOPD PHARMACY</option>
                    <option data-category="pharmacy" value="39">
                      (Pharmacy) ICU STATION</option>
                    <option data-category="pharmacy" value="37">
                      (Pharmacy) LABOUR WARD STATION</option>
                    <option data-category="pharmacy" value="34">
                      (Pharmacy) O &amp; G STATION</option>
                    <option data-category="procedures" value="22">
                      (Medical Procedures) A &amp; E THEATER</option>
                    <option data-category="procedures" value="23">
                      (Medical Procedures) LABOUR WARD THEATER</option>
                    <option data-category="procedures" value="19">
                      (Medical Procedures) MAIN THEATER</option>
                    <option data-category="radiology" value="4">
                      (Radiology) RADIOLOGY</option>
                  </select><button type="button" class="custom-select dropdown-toggle" data-toggle="dropdown" role="combobox" aria-owns="bs-select-2" aria-haspopup="listbox" aria-expanded="false" data-id="id_location" title="- All -"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner">- All -</div></div> </div></button><div class="dropdown-menu "><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" role="combobox" aria-label="Search" aria-controls="bs-select-2" aria-autocomplete="list"></div><div class="inner show" role="listbox" id="bs-select-2" tabindex="-1"><ul class="dropdown-menu inner show" role="presentation"></ul></div></div></div>
              </div>
              <div class="form-group flex-fill ml-2">
                <label class="mb-0" for="paid_status">Payment Status</label>
                <div class="dropdown bootstrap-select filter form-control"><select name="paid" id="paid_status" data-live-search="true" class="filter form-control selectpicker" tabindex="-98">
                    <option value="">- All -</option>
                    <option value="1">Paid</option>
                    <option value="0">Not Yet Paid</option>
                  </select><button type="button" class="custom-select dropdown-toggle" data-toggle="dropdown" role="combobox" aria-owns="bs-select-3" aria-haspopup="listbox" aria-expanded="false" data-id="paid_status" title="- All -"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner">- All -</div></div> </div></button><div class="dropdown-menu "><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" role="combobox" aria-label="Search" aria-controls="bs-select-3" aria-autocomplete="list"></div><div class="inner show" role="listbox" id="bs-select-3" tabindex="-1"><ul class="dropdown-menu inner show" role="presentation"></ul></div></div></div>
              </div>

              <div class="form-group flex-fill ml-2">
                <input type="hidden" name="start" class="filter sr-only">
                <input type="hidden" name="stop" class="filter sr-only">
                <label for="reportrange" class="mb-0">Transaction Date</label>
                <div id="reportrange" class="form-control d-flex custom-select filter-">
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
          </div><!-- /.card-header -->

          <!-- .table-responsive -->
          <div class="table-responsive">
            <!-- .table -->
            <table class="table">
              <!-- thead -->
              <thead>
              <tr>
                <th>Date</th>
                <th>Service</th>
                <th>Category</th>
                <th class="text-right">Amount</th>
                <th></th>
              </tr>
              </thead>
              <tbody>
              <!-- tr -->

              <tr>
                <td class="align-middle">03/07/2025 7:54 a.m.</td>
                <td class="align-middle">Consultancy: MEDICAL OFFICER</td>
                <td class="align-middle">Consultancy </td>
                <td class="align-middle text-right"> ₦5,000.00</td>
                <td class="align-middle text-right">
                </td>
              </tr>

              <tr>
                <td class="align-middle">03/07/2025 7:54 a.m.</td>
                <td class="align-middle">Enrollment Fee</td>
                <td class="align-middle"> </td>
                <td class="align-middle text-right"> ₦2,000.00</td>
                <td class="align-middle text-right">
                </td>
              </tr>

              <tr>
                <td class="align-middle">03/07/2025 7:51 a.m.</td>
                <td class="align-middle">Pharmacy: IV OMEPRAZOLE</td>
                <td class="align-middle">Pharmacy </td>
                <td class="align-middle text-right"> ₦2,000.00</td>
                <td class="align-middle text-right">
                </td>
              </tr>

              <tr>
                <td class="align-middle">03/07/2025 7:51 a.m.</td>
                <td class="align-middle">Pharmacy: PYROX</td>
                <td class="align-middle">Pharmacy </td>
                <td class="align-middle text-right"> ₦2,000.00</td>
                <td class="align-middle text-right">
                </td>
              </tr>

              <tr>
                <td class="align-middle">03/07/2025 7:51 a.m.</td>
                <td class="align-middle">Pharmacy: INJ PCM 300MG</td>
                <td class="align-middle">Pharmacy </td>
                <td class="align-middle text-right"> ₦400.00</td>
                <td class="align-middle text-right">
                </td>
              </tr>

              <tr>
                <td class="align-middle">03/07/2025 7:49 a.m.</td>
                <td class="align-middle">Pharmacy: TOT"'HEMA</td>
                <td class="align-middle">Pharmacy </td>
                <td class="align-middle text-right"> ₦3,000.00</td>
                <td class="align-middle text-right">
                </td>
              </tr>

              <tr>
                <td class="align-middle">03/07/2025 7:40 a.m.</td>
                <td class="align-middle">Laboratory: URINALYSIS</td>
                <td class="align-middle">Laboratory </td>
                <td class="align-middle text-right"> ₦2,000.00</td>
                <td class="align-middle text-right">
                </td>
              </tr>

              <tr>
                <td class="align-middle">03/07/2025 7:40 a.m.</td>
                <td class="align-middle">Laboratory: HELICOBACTER PYLORI ANTIGEN (STOOL)</td>
                <td class="align-middle">Laboratory </td>
                <td class="align-middle text-right"> ₦10,000.00</td>
                <td class="align-middle text-right">
                </td>
              </tr>

              <tr>
                <td class="align-middle">03/07/2025 7:40 a.m.</td>
                <td class="align-middle">Admissions: Medical Consumable</td>
                <td class="align-middle"> </td>
                <td class="align-middle text-right"> ₦3,000.00</td>
                <td class="align-middle text-right">
                </td>
              </tr>

              <tr>
                <td class="align-middle">03/07/2025 7:39 a.m.</td>
                <td class="align-middle">MORTUARY FEE</td>
                <td class="align-middle"> </td>
                <td class="align-middle text-right"> ₦3,500.00</td>
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

                  <span class="page-link" href="javascript:"> 1 - 10 of 41</span>
                </li>


                <li class="page-item">
                  <a class="page-link" href="javascript:" data-page="2" data-href="?page=2">Next <span class="oi oi-arrow-right"></span></a>
                </li>

              </ul>
              <input type="hidden" class="sr-only filter" name="page" value="1">

            </div>


          </div><!-- /.table-responsive -->
        </div>
        <script>
          var processFilter1 = function () {
            var currentTab = $('[data-toggle="tab"].active');
            var url = currentTab.data('remote'), //contentArea = currentTab.attr('href'),
              form = $('.tab-pane.active.show .filterForm');
            var data = form.serializeArray();
            data.push({'name': 'page', 'value': $('.pagination + [name="page"]').val()});

            showLoader();
            $.post(url, data, function (s) {
              $.unblockUI();
              $('.tab-pane.active.show .table-responsive').html($(s).find('.table-responsive').html());
            }, 'html');
          };
          jQuery(function ($) {
            var start = moment();
            var end = moment();

            function cb(start, end) {
              $('.tab-pane.active.show #reportrange span').html(start.format('MM/D/YYYY') + ' - ' + end.format('MM/D/YYYY'));
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
              processFilter1();
            });
            cb(start, end);

            $('.selectpicker:not([tabindex])').selectpicker('refresh');
            $(document).off('change', '#category_id').on('change', '#category_id', function (e) {
              e.preventDefault();
              if ($(this).val() !== '') {
                $('#id_location option[data-category]').each(function (i, o) {
                  o.setAttribute('hidden', 'hidden');
                });
                $('#id_location option[data-category="' + $(this).val() + '"]').each(function (i, o) {
                  o.removeAttribute('hidden');
                });
                $('#id_location').selectpicker('refresh');
              } else {
                $('#id_location option[data-category]').each(function (i, o) {
                  o.removeAttribute('hidden');
                });
                $('#id_location').selectpicker('refresh');
              }
            });
            $(document).off('click', '.pagination > .page-item > .page-link').on('click', '.pagination > .page-item > .page-link', function (e) {
              e.preventDefault();
              $('.pagination + [name="page"]').val($(this).data('page')).trigger('change');
              //processFilter1();
            }).off('change', '.tab-pane.active.show :input.filter').on('change', '.tab-pane.active.show :input.filter', function (e) {
              processFilter1();
              //console.log(e.currentTarget);
            }).off('click', '#export-btn').on('click', '#export-btn', function (e) {
              let filters = $('.filterForm').serializeArray();

              _.remove(filters, function(n){return (n.name==='start') || (n.name==='stop') });
              filters.push({name: 'date__range', value: [$('.tab-pane.active.show [name="start"].filter').val(), $('.tab-pane.active.show [name="stop"].filter').val()]});
              //$.post('/billing/report/download-revenue', filters);
              console.log(filters);
              let filename = '';
              const data = new URLSearchParams();
              data.append('filters', JSON.stringify(filters));
              data.append('csrfmiddlewaretoken', 'AxOZYTQaIW7Zo0Vt2DyR427Eh3rhh4NshpUHTlpePzLFELd2MdvSKlARSvmlWBun');
              showLoader();
              fetch('/billing/report/download-revenue', {
                method: 'post',
                body: data
              }).then(res => {
                for (var [key, value] of res.headers.entries()) {
                  if (key.toLowerCase() === 'content-disposition') {
                    filename = value.match(/filename="(.*?)"/i)[1];
                  }
                }
                return res.blob()
              }).then(blob => {
                $.unblockUI();
                saveAs(blob, filename)
              });
            });
          })
        </script>
      </div><div class="tab-pane fade" id="tab-cashpoints" role="tabpanel"></div><div class="tab-pane fade" id="tab-end-of-day" role="tabpanel"></div><div class="tab-pane fade" id="tab-insurance-enrollees" role="tabpanel"></div></div><!-- /.tab-content -->
  </div><!-- /metric row -->
</div>
@endsection
