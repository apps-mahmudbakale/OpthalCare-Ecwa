@extends('layouts/layoutMaster')

@section('title', 'Reports')

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
<style type="text/css">
  .highcharts-figure,
  .highcharts-data-table table {
    min-width: 310px;
    max-width: 800px;
    margin: 1em auto;
  }

  #container {
    height: 400px;
  }

  .highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
  }

  .highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
  }

  .highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
  }

  .highcharts-data-table td,
  .highcharts-data-table th,
  .highcharts-data-table caption {
    padding: 0.5em;
  }

  .highcharts-data-table thead tr,
  .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
  }

  .highcharts-data-table tr:hover {
    background: #f1f7ff;
  }

</style>
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
            <div class="metric-row">
              <h4>Reports</h4>
                <div class="col-lg-12">
                    <div class="metric-row metric-flush">
                        <div class="col-md-3">
                            <div href="javascript:" class="card-metric- metric metric-bordered align-items-center-">
                                <h2 class="metric-label">Patients  Today</h2>
                                <p class="metric-value h3"><sub><i class="oi oi-people"></i></sub><span
                                        class="value ml-2">{{$patientTodayCount}}</span></p><a href="#" class="text-right">... Details</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div href="javascript:" class="card-metric- metric metric-bordered align-items-center-">
                                <h2 class="metric-label">Total Patients </h2>
                                <p class="metric-value h3"><sub><i class="oi oi-people"></i></sub><span
                                        class="value ml-2">{{$patientsCount}}</span></p><a href="{{route('app.patients.index')}}" class="text-right">... Details</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div href="javascript:" class="card-metric- metric metric-bordered align-items-center-">
                                <h2 class="metric-label">Expired Drugs</h2>
                                <p class="metric-value h3"><sub><i class="fa fa-tasks"></i></sub><span
                                        class="value ml-3">{{$expiredDrugs}}</span></p><a href="/reports/pharmacy/#expired-drugs"
                                    class="text-right">... Details</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div href="javascript:" class="card-metric- metric metric-bordered align-items-center-">
                                <h2 class="metric-label">Low Stock Drugs</h2>
                                <p class="metric-value h3"><sub><i class="fa fa-tasks"></i></sub><span
                                        class="value ml-3">{{$lowStock}}</span></p><a href="/reports/pharmacy/#low-stock-drugs"
                                    class="text-right">... Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /metric row -->
        <div class="section-block">
            <div class="metric-row">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card-metric">
                        <div class="metric py-3">
                            <h2 class="metric-label"><a href="{{route('app.reports.general')}}">General Reports</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card-metric">
                        <div class="metric py-3">
                            <h2 class="metric-label"><a href="{{route('app.reports.pharmacy')}}">Extended Pharmacy Reports</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card-metric">
                        <div class="metric py-3">
                            <h2 class="metric-label"><a href="{{route('app.reports.lab')}}">Extended Laboratory Reports</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card-metric">
                        <div class="metric py-3">
                            <h2 class="metric-label"><a href="{{route('app.reports.radiology')}}">Extended Radiology Reports</a></h2>

                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card-metric">
                        <div class="metric py-3">
                            <h2 class="metric-label"><a href="{{route('app.reports.procedure')}}">Extended Procedures Reports</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card-metric">
                        <div class="metric py-3">
                            <h2 class="metric-label"><a href="{{route('app.reports.billing')}}">Extended Billing Reports</a></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.section-block --><!-- grid row -->
        <div class="row"><!-- grid column -->
            <div class="col-12 col-lg-12 col-xl-12"><!-- .card -->
                <div class="card card-fluid match-height" style="height: 532px;"><!-- .card-body -->
                    <div class="card-body">
                      <figure class="highcharts-figure">
                        <div id="container"></div>
                        <p></p>
                      </figure>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div>
            <div class="col-12 col-lg-12 col-xl-6-"><!-- .card -->
                <div class="card card-fluid match-height" style=""><!-- .card-body -->
                    <div class="card-body">
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /grid column -->
        </div><!-- /grid row -->
    </div>
<script src="{{asset('code/highcharts.js')}}"></script>
<script src="{{asset('code/modules/exporting.js')}}"></script>
<script src="{{asset('code/modules/export-data.js')}}"></script>
<script src="{{asset('code/modules/accessibility.js')}}"></script>
<script type="text/javascript">
  Highcharts.chart('container', {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Revenue by Cash Point'
    },
    xAxis: {
      categories: {!! json_encode($cashPointNames) !!},
  crosshair: true,
    labels: {
    rotation: -45, // Rotate labels if there are many cash points
      style: {
      fontSize: '13px'
    }
  }
  },
  yAxis: {
    min: 0,
      title: {
      text: 'Revenue (Amount)'
    }
  },
  tooltip: {
    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
      pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
    '<td style="padding:0"><b>{point.y:.2f}</b></td></tr>',
      footerFormat: '</table>',
      shared: true,
      useHTML: true
  },
  plotOptions: {
    column: {
      pointPadding: 0.2,
        borderWidth: 0
    }
  },
  series: [{
    name: 'Payments',
    data: {!! json_encode($paymentSeries) !!}
  }]
  });
</script>
@endsection
