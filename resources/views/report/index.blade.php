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
                                        class="value ml-2">{{$patientsCount}}</span></p><a href="#" class="text-right">... Details</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div href="javascript:" class="card-metric- metric metric-bordered align-items-center-">
                                <h2 class="metric-label">Expired Drugs</h2>
                                <p class="metric-value h3"><sub><i class="fa fa-tasks"></i></sub><span
                                        class="value ml-3">309</span></p><a href="/reports/pharmacy/#expired-drugs"
                                    class="text-right">... Details</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div href="javascript:" class="card-metric- metric metric-bordered align-items-center-">
                                <h2 class="metric-label">Low Stock Drugs</h2>
                                <p class="metric-value h3"><sub><i class="fa fa-tasks"></i></sub><span
                                        class="value ml-3">725</span></p><a href="/reports/pharmacy/#low-stock-drugs"
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
                        <div class="chartdiv" id="cash-points-collections" style="position: relative;">
                            <div dir="ltr" class="resize-sensor"
                                style="pointer-events: none; position: absolute; inset: 0px; overflow: hidden; z-index: -1; visibility: hidden; max-width: 100%;">
                                <div class="resize-sensor-expand"
                                    style="pointer-events: none; position: absolute; inset: 0px; overflow: hidden; z-index: -1; visibility: hidden; max-width: 100%;">
                                    <div
                                        style="position: absolute; left: 0px; top: 0px; transition: all 0s ease 0s; width: 608px; height: 510px;">
                                    </div>
                                </div>
                                <div class="resize-sensor-shrink"
                                    style="pointer-events: none; position: absolute; inset: 0px; overflow: hidden; z-index: -1; visibility: hidden; max-width: 100%;">
                                    <div
                                        style="position: absolute; left: 0px; top: 0px; transition: all 0s ease 0s; width: 200%; height: 200%;">
                                    </div>
                                </div>
                            </div>
                            <div style="width: 100%; height: 100%; position: relative; top: -0.450012px;"><svg
                                    version="1.1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" role="group"
                                    style="width: 100%; height: 100%; overflow: visible;">
                                    <desc>JavaScript chart by amCharts</desc>
                                    <defs>
                                        <clipPath id="id-136">
                                            <rect width="598" height="500"></rect>
                                        </clipPath>
                                        <linearGradient id="gradient-id-159" x1="1%" x2="99%"
                                            y1="59%" y2="41%">
                                            <stop stop-color="#474758" offset="0"></stop>
                                            <stop stop-color="#474758" stop-opacity="1" offset="0.75"></stop>
                                            <stop stop-color="#3cabff" stop-opacity="1" offset="0.755"></stop>
                                        </linearGradient>
                                        <filter id="filter-id-168" width="200%" height="200%" x="-50%" y="-50%">
                                        </filter>
                                        <filter id="filter-id-189" width="200%" height="200%" x="-50%" y="-50%">
                                        </filter>
                                        <clipPath id="id-222">
                                            <path d="M0,0 L519,0 L519,374 L0,374 L0,0"></path>
                                        </clipPath>
                                        <clipPath id="id-691">
                                            <rect width="519" height="374"></rect>
                                        </clipPath>
                                        <filter id="filter-id-141" width="200%" height="200%" x="-50%" y="-50%">
                                            <feGaussianBlur result="blurOut" in="SourceGraphic" stdDeviation="1.5">
                                            </feGaussianBlur>
                                            <feOffset result="offsetBlur" dx="1" dy="1"></feOffset>
                                            <feFlood flood-color="#000000" flood-opacity="0.5"></feFlood>
                                            <feComposite in2="offsetBlur" operator="in"></feComposite>
                                            <feMerge>
                                                <feMergeNode></feMergeNode>
                                                <feMergeNode in="SourceGraphic"></feMergeNode>
                                            </feMerge>
                                        </filter>
                                        <filter id="filter-id-156" width="120%" height="120%" x="-10%" y="-10%">
                                            <feColorMatrix type="saturate" values="0"></feColorMatrix>
                                        </filter>
                                        <filter id="filter-id-227" width="200%" height="200%" x="-50%" y="-50%">
                                            <feGaussianBlur result="blurOut" in="SourceGraphic" stdDeviation="1.5">
                                            </feGaussianBlur>
                                            <feOffset result="offsetBlur" dx="1" dy="1"></feOffset>
                                            <feFlood flood-color="#000000" flood-opacity="0.5"></feFlood>
                                            <feComposite in2="offsetBlur" operator="in"></feComposite>
                                            <feMerge>
                                                <feMergeNode></feMergeNode>
                                                <feMergeNode in="SourceGraphic"></feMergeNode>
                                            </feMerge>
                                        </filter>
                                    </defs>
                                    <g>
                                        <g fill="#ffffff" fill-opacity="0">
                                            <rect width="598" height="500"></rect>
                                        </g>
                                        <g>
                                            <g role="region" clip-path="url(&quot;#id-136&quot;)" opacity="1"
                                                aria-describedby="id-112-description">
                                                <g transform="translate(15,15)">
                                                    <g fill="#000000" id="id-248" font-size="17"
                                                        transform="translate(181.5,0)">
                                                        <g style="user-select: none;"><text x="0" y="20.350000381469727"
                                                                dy="-5.495">
                                                                <tspan>Collections by Cash Points</tspan>
                                                            </text></g>
                                                    </g>
                                                    <g transform="translate(0,20)">
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <g transform="translate(49,0)">
                                                                                <g fill="#ffffff" fill-opacity="0">
                                                                                    <rect width="519" height="374">
                                                                                    </rect>
                                                                                </g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <g stroke="#000000"
                                                                                                stroke-opacity="0.15"
                                                                                                fill="none"
                                                                                                transform="translate(0,449)"
                                                                                                display="none">
                                                                                                <path d=" M0,0  L519,0 "
                                                                                                    transform="translate(-0.5,-0.5)">
                                                                                                </path>
                                                                                            </g>
                                                                                            <g stroke="#000000"
                                                                                                stroke-opacity="0.15"
                                                                                                fill="none"
                                                                                                transform="translate(0,411)"
                                                                                                display="none">
                                                                                                <path d=" M0,0  L519,0 "
                                                                                                    transform="translate(-0.5,-0.5)">
                                                                                                </path>
                                                                                            </g>
                                                                                            <g stroke="#000000"
                                                                                                stroke-opacity="0.15"
                                                                                                fill="none"
                                                                                                transform="translate(0,374)">
                                                                                                <path d=" M0,0  L519,0 "
                                                                                                    transform="translate(-0.5,-0.5)">
                                                                                                </path>
                                                                                            </g>
                                                                                            <g stroke="#000000"
                                                                                                stroke-opacity="0.15"
                                                                                                fill="none"
                                                                                                transform="translate(0,337)"
                                                                                                display="none">
                                                                                                <path d=" M0,0  L519,0 "
                                                                                                    transform="translate(-0.5,-0.5)">
                                                                                                </path>
                                                                                            </g>
                                                                                            <g stroke="#000000"
                                                                                                stroke-opacity="0.15"
                                                                                                fill="none"
                                                                                                transform="translate(0,299)"
                                                                                                display="none">
                                                                                                <path d=" M0,0  L519,0 "
                                                                                                    transform="translate(-0.5,-0.5)">
                                                                                                </path>
                                                                                            </g>
                                                                                            <g stroke="#000000"
                                                                                                stroke-opacity="0.15"
                                                                                                fill="none"
                                                                                                transform="translate(0,262)"
                                                                                                display="none">
                                                                                                <path d=" M0,0  L519,0 "
                                                                                                    transform="translate(-0.5,-0.5)">
                                                                                                </path>
                                                                                            </g>
                                                                                            <g stroke="#000000"
                                                                                                stroke-opacity="0.15"
                                                                                                fill="none"
                                                                                                transform="translate(0,224)"
                                                                                                display="none">
                                                                                                <path d=" M0,0  L519,0 "
                                                                                                    transform="translate(-0.5,-0.5)">
                                                                                                </path>
                                                                                            </g>
                                                                                            <g stroke="#000000"
                                                                                                stroke-opacity="0.15"
                                                                                                fill="none"
                                                                                                transform="translate(0,187)">
                                                                                                <path d=" M0,0  L519,0 "
                                                                                                    transform="translate(-0.5,-0.5)">
                                                                                                </path>
                                                                                            </g>
                                                                                            <g stroke="#000000"
                                                                                                stroke-opacity="0.15"
                                                                                                fill="none"
                                                                                                transform="translate(0,-94)"
                                                                                                display="none">
                                                                                                <path d=" M0,0  L519,0 "
                                                                                                    transform="translate(-0.5,-0.5)">
                                                                                                </path>
                                                                                            </g>
                                                                                            <g stroke="#000000"
                                                                                                stroke-opacity="0.15"
                                                                                                fill="none">
                                                                                                <path d=" M0,0  L519,0 "
                                                                                                    transform="translate(-0.5,-0.5)">
                                                                                                </path>
                                                                                            </g>
                                                                                            <g stroke="#000000"
                                                                                                stroke-opacity="0.15"
                                                                                                fill="none"
                                                                                                transform="translate(0,93)">
                                                                                                <path d=" M0,0  L519,0 "
                                                                                                    transform="translate(-0.5,-0.5)">
                                                                                                </path>
                                                                                            </g>
                                                                                            <g stroke="#000000"
                                                                                                stroke-opacity="0.15"
                                                                                                fill="none"
                                                                                                transform="translate(0,280)">
                                                                                                <path d=" M0,0  L519,0 "
                                                                                                    transform="translate(-0.5,-0.5)">
                                                                                                </path>
                                                                                            </g>
                                                                                            <g stroke="#000000"
                                                                                                stroke-opacity="0.15"
                                                                                                fill="none"
                                                                                                transform="translate(0,467)"
                                                                                                display="none">
                                                                                                <path d=" M0,0  L519,0 "
                                                                                                    transform="translate(-0.5,-0.5)">
                                                                                                </path>
                                                                                            </g>
                                                                                            <g stroke="#000000"
                                                                                                stroke-opacity="0.15"
                                                                                                fill="none"
                                                                                                transform="translate(0,561)"
                                                                                                display="none">
                                                                                                <path d=" M0,0  L519,0 "
                                                                                                    transform="translate(-0.5,-0.5)">
                                                                                                </path>
                                                                                            </g>
                                                                                        </g>
                                                                                    </g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <g stroke="#000000"
                                                                                                stroke-opacity="0.15"
                                                                                                fill="none">
                                                                                                <path d=" M0,0  L0,374 "
                                                                                                    transform="translate(-0.5,-0.5)">
                                                                                                </path>
                                                                                            </g>
                                                                                            <g stroke="#000000"
                                                                                                stroke-opacity="0.15"
                                                                                                fill="none"
                                                                                                transform="translate(104,0)">
                                                                                                <path d=" M0,0  L0,374 "
                                                                                                    transform="translate(-0.5,-0.5)">
                                                                                                </path>
                                                                                            </g>
                                                                                            <g stroke="#000000"
                                                                                                stroke-opacity="0.15"
                                                                                                fill="none"
                                                                                                transform="translate(208,0)">
                                                                                                <path d=" M0,0  L0,374 "
                                                                                                    transform="translate(-0.5,-0.5)">
                                                                                                </path>
                                                                                            </g>
                                                                                            <g stroke="#000000"
                                                                                                stroke-opacity="0.15"
                                                                                                fill="none"
                                                                                                transform="translate(311,0)">
                                                                                                <path d=" M0,0  L0,374 "
                                                                                                    transform="translate(-0.5,-0.5)">
                                                                                                </path>
                                                                                            </g>
                                                                                            <g stroke="#000000"
                                                                                                stroke-opacity="0.15"
                                                                                                fill="none"
                                                                                                transform="translate(415,0)">
                                                                                                <path d=" M0,0  L0,374 "
                                                                                                    transform="translate(-0.5,-0.5)">
                                                                                                </path>
                                                                                            </g>
                                                                                            <g stroke="#000000"
                                                                                                stroke-opacity="0.15"
                                                                                                fill="none"
                                                                                                transform="translate(519,0)">
                                                                                                <path d=" M0,0  L0,374 "
                                                                                                    transform="translate(-0.5,-0.5)">
                                                                                                </path>
                                                                                            </g>
                                                                                        </g>
                                                                                    </g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <g role="menu"
                                                                                                stroke-opacity="0"
                                                                                                fill-opacity="1"
                                                                                                fill="#f44336"
                                                                                                stroke="#f44336"
                                                                                                aria-describedby="id-217-description"
                                                                                                id="id-217">
                                                                                                <g>
                                                                                                    <g
                                                                                                        clip-path="url(&quot;#id-222&quot;)">
                                                                                                        <g>
                                                                                                            <g>
                                                                                                                <g>
                                                                                                                    <g stroke-opacity="1"
                                                                                                                        fill-opacity="0.8"
                                                                                                                        stroke-width="2"
                                                                                                                        fill="#f44336"
                                                                                                                        stroke="#f44336"
                                                                                                                        role="menuitem"
                                                                                                                        focusable="true"
                                                                                                                        tabindex="0"
                                                                                                                        transform="translate(10.38,187)">
                                                                                                                        <g>
                                                                                                                            <g>
                                                                                                                                <path
                                                                                                                                    d="M0,0 L83.04,0 a0,0 0 0 1 0,0 L83.04,0 a0,0 0 0 1 -0,0 L0,0 a0,0 0 0 1 -0,-0 L0,0 a0,0 0 0 1 0,-0 Z">
                                                                                                                                </path>
                                                                                                                            </g>
                                                                                                                        </g>
                                                                                                                    </g>
                                                                                                                    <g stroke-opacity="1"
                                                                                                                        fill-opacity="0.8"
                                                                                                                        stroke-width="2"
                                                                                                                        fill="#f44336"
                                                                                                                        stroke="#f44336"
                                                                                                                        role="menuitem"
                                                                                                                        focusable="true"
                                                                                                                        tabindex="0"
                                                                                                                        transform="translate(114.18,187)">
                                                                                                                        <g>
                                                                                                                            <g>
                                                                                                                                <path
                                                                                                                                    d="M0,0 L83.04,0 a0,0 0 0 1 0,0 L83.04,0 a0,0 0 0 1 -0,0 L0,0 a0,0 0 0 1 -0,-0 L0,0 a0,0 0 0 1 0,-0 Z">
                                                                                                                                </path>
                                                                                                                            </g>
                                                                                                                        </g>
                                                                                                                    </g>
                                                                                                                    <g stroke-opacity="1"
                                                                                                                        fill-opacity="0.8"
                                                                                                                        stroke-width="2"
                                                                                                                        fill="#f44336"
                                                                                                                        stroke="#f44336"
                                                                                                                        role="menuitem"
                                                                                                                        focusable="true"
                                                                                                                        tabindex="0"
                                                                                                                        transform="translate(217.98,187)">
                                                                                                                        <g>
                                                                                                                            <g>
                                                                                                                                <path
                                                                                                                                    d="M0,0 L83.04,0 a0,0 0 0 1 0,0 L83.04,0 a0,0 0 0 1 -0,0 L0,0 a0,0 0 0 1 -0,-0 L0,0 a0,0 0 0 1 0,-0 Z">
                                                                                                                                </path>
                                                                                                                            </g>
                                                                                                                        </g>
                                                                                                                    </g>
                                                                                                                    <g stroke-opacity="1"
                                                                                                                        fill-opacity="0.8"
                                                                                                                        stroke-width="2"
                                                                                                                        fill="#f44336"
                                                                                                                        stroke="#f44336"
                                                                                                                        role="menuitem"
                                                                                                                        focusable="true"
                                                                                                                        tabindex="0"
                                                                                                                        transform="translate(321.78,187)">
                                                                                                                        <g>
                                                                                                                            <g>
                                                                                                                                <path
                                                                                                                                    d="M0,0 L83.04,0 a0,0 0 0 1 0,0 L83.04,0 a0,0 0 0 1 -0,0 L0,0 a0,0 0 0 1 -0,-0 L0,0 a0,0 0 0 1 0,-0 Z">
                                                                                                                                </path>
                                                                                                                            </g>
                                                                                                                        </g>
                                                                                                                    </g>
                                                                                                                    <g stroke-opacity="1"
                                                                                                                        fill-opacity="0.8"
                                                                                                                        stroke-width="2"
                                                                                                                        fill="#f44336"
                                                                                                                        stroke="#f44336"
                                                                                                                        role="menuitem"
                                                                                                                        focusable="true"
                                                                                                                        tabindex="0"
                                                                                                                        transform="translate(425.58,187)">
                                                                                                                        <g>
                                                                                                                            <g>
                                                                                                                                <path
                                                                                                                                    d="M0,0 L83.04,0 a0,0 0 0 1 0,0 L83.04,0 a0,0 0 0 1 -0,0 L0,0 a0,0 0 0 1 -0,-0 L0,0 a0,0 0 0 1 0,-0 Z">
                                                                                                                                </path>
                                                                                                                            </g>
                                                                                                                        </g>
                                                                                                                    </g>
                                                                                                                </g>
                                                                                                            </g>
                                                                                                        </g>
                                                                                                    </g>
                                                                                                    <g></g>
                                                                                                </g>
                                                                                                <desc
                                                                                                    id="id-217-description">
                                                                                                    Collections</desc>
                                                                                            </g>
                                                                                        </g>
                                                                                    </g>
                                                                                    <g
                                                                                        clip-path="url(&quot;#id-691&quot;)">
                                                                                        <g>
                                                                                            <g fill="#f44336"
                                                                                                stroke="#f44336">
                                                                                                <g></g>
                                                                                            </g>
                                                                                        </g>
                                                                                    </g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <g>
                                                                                                <g></g>
                                                                                            </g>
                                                                                            <g>
                                                                                                <g></g>
                                                                                            </g>
                                                                                        </g>
                                                                                    </g>
                                                                                    <g>
                                                                                        <g></g>
                                                                                    </g>
                                                                                    <g>
                                                                                        <g></g>
                                                                                    </g>
                                                                                    <g role="button" focusable="true"
                                                                                        tabindex="0" opacity="0"
                                                                                        visibility="hidden"
                                                                                        aria-hidden="true"
                                                                                        transform="translate(479,-3)"
                                                                                        aria-labelledby="id-127-title">
                                                                                        <g fill="#6794dc" stroke="#ffffff"
                                                                                            fill-opacity="1"
                                                                                            stroke-opacity="0"
                                                                                            transform="translate(0,8)">
                                                                                            <path
                                                                                                d="M17,0 L18,0 a17,17 0 0 1 17,17 L35,17 a17,17 0 0 1 -17,17 L17,34 a17,17 0 0 1 -17,-17 L0,17 a17,17 0 0 1 17,-17 Z">
                                                                                            </path>
                                                                                        </g>
                                                                                        <g transform="translate(9,9)">
                                                                                            <g stroke="#ffffff"
                                                                                                style="pointer-events: none;"
                                                                                                transform="translate(0,8)">
                                                                                                <path d=" M0,0  L11,0 "
                                                                                                    transform="translate(2.5,7.5)">
                                                                                                </path>
                                                                                            </g>
                                                                                            <g fill="#000000"
                                                                                                style="pointer-events: none;"
                                                                                                transform="translate(17,8)">
                                                                                                <g display="none"></g>
                                                                                            </g>
                                                                                        </g>
                                                                                        <title id="id-127-title">Zoom Out
                                                                                        </title>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                            <g>
                                                                                <g>
                                                                                    <g aria-hidden="true">
                                                                                        <g>
                                                                                            <g fill="#000000"
                                                                                                transform="translate(0,187) rotate(-90)">
                                                                                                <g display="none"></g>
                                                                                            </g>
                                                                                            <g stroke="#000000"
                                                                                                stroke-opacity="0.15"
                                                                                                fill="none"
                                                                                                transform="translate(49,187)">
                                                                                                <path
                                                                                                    transform="translate(-0.5,-0.5)"
                                                                                                    d=" M0,0  L519,0 ">
                                                                                                </path>
                                                                                            </g>
                                                                                            <g>
                                                                                                <g>
                                                                                                    <g fill="#000000"
                                                                                                        fill-opacity="0"
                                                                                                        opacity="0"
                                                                                                        stroke-opacity="0"
                                                                                                        style="pointer-events: none;"
                                                                                                        transform="translate(49,187)">
                                                                                                        <g transform="translate(-39,-8.5)"
                                                                                                            style="user-select: none;">
                                                                                                            <text x="0"
                                                                                                                y="17.049999237060547"
                                                                                                                dy="-4.603">
                                                                                                                <tspan>-0.4
                                                                                                                </tspan>
                                                                                                            </text></g>
                                                                                                    </g>
                                                                                                    <g fill="#000000"
                                                                                                        transform="translate(49,448.8)"
                                                                                                        display="none">
                                                                                                        <g transform="translate(-37,-8.5)"
                                                                                                            style="user-select: none;">
                                                                                                            <text x="0"
                                                                                                                y="17.049999237060547"
                                                                                                                dy="-4.603">
                                                                                                                <tspan>-1.4
                                                                                                                </tspan>
                                                                                                            </text></g>
                                                                                                    </g>
                                                                                                    <g fill="#000000"
                                                                                                        transform="translate(49,411.4)"
                                                                                                        display="none">
                                                                                                        <g transform="translate(-36,-8.5)"
                                                                                                            style="user-select: none;">
                                                                                                            <text x="0"
                                                                                                                y="17.049999237060547"
                                                                                                                dy="-4.603">
                                                                                                                <tspan>-1.2
                                                                                                                </tspan>
                                                                                                            </text></g>
                                                                                                    </g>
                                                                                                    <g fill="#000000"
                                                                                                        transform="translate(49,374)">
                                                                                                        <g transform="translate(-24,-8.5)"
                                                                                                            style="user-select: none;">
                                                                                                            <text x="0"
                                                                                                                y="17.049999237060547"
                                                                                                                dy="-4.603">
                                                                                                                <tspan>-1
                                                                                                                </tspan>
                                                                                                            </text></g>
                                                                                                    </g>
                                                                                                    <g fill="#000000"
                                                                                                        transform="translate(49,336.6)"
                                                                                                        display="none">
                                                                                                        <g transform="translate(-38,-8.5)"
                                                                                                            style="user-select: none;">
                                                                                                            <text x="0"
                                                                                                                y="17.049999237060547"
                                                                                                                dy="-4.603">
                                                                                                                <tspan>-0.8
                                                                                                                </tspan>
                                                                                                            </text></g>
                                                                                                    </g>
                                                                                                    <g fill="#000000"
                                                                                                        transform="translate(49,299.2)"
                                                                                                        display="none">
                                                                                                        <g transform="translate(-38,-8.5)"
                                                                                                            style="user-select: none;">
                                                                                                            <text x="0"
                                                                                                                y="17.049999237060547"
                                                                                                                dy="-4.603">
                                                                                                                <tspan>-0.6
                                                                                                                </tspan>
                                                                                                            </text></g>
                                                                                                    </g>
                                                                                                    <g fill="#000000"
                                                                                                        transform="translate(49,261.8)"
                                                                                                        display="none">
                                                                                                        <g transform="translate(-39,-8.5)"
                                                                                                            style="user-select: none;">
                                                                                                            <text x="0"
                                                                                                                y="17.049999237060547"
                                                                                                                dy="-4.603">
                                                                                                                <tspan>-0.4
                                                                                                                </tspan>
                                                                                                            </text></g>
                                                                                                    </g>
                                                                                                    <g fill="#000000"
                                                                                                        transform="translate(49,224.4)"
                                                                                                        display="none">
                                                                                                        <g transform="translate(-38,-8.5)"
                                                                                                            style="user-select: none;">
                                                                                                            <text x="0"
                                                                                                                y="17.049999237060547"
                                                                                                                dy="-4.603">
                                                                                                                <tspan>-0.2
                                                                                                                </tspan>
                                                                                                            </text></g>
                                                                                                    </g>
                                                                                                    <g fill="#000000"
                                                                                                        transform="translate(49,187)">
                                                                                                        <g transform="translate(-20,-8.5)"
                                                                                                            style="user-select: none;">
                                                                                                            <text x="0"
                                                                                                                y="17.049999237060547"
                                                                                                                dy="-4.603">
                                                                                                                <tspan>0
                                                                                                                </tspan>
                                                                                                            </text></g>
                                                                                                    </g>
                                                                                                    <g fill="#000000"
                                                                                                        transform="translate(49,-93.5)"
                                                                                                        display="none">
                                                                                                        <g transform="translate(-30,-8.5)"
                                                                                                            style="user-select: none;">
                                                                                                            <text x="0"
                                                                                                                y="17.049999237060547"
                                                                                                                dy="-4.603">
                                                                                                                <tspan>1.5
                                                                                                                </tspan>
                                                                                                            </text></g>
                                                                                                    </g>
                                                                                                    <g fill="#000000"
                                                                                                        transform="translate(49,0)">
                                                                                                        <g transform="translate(-18,-8.5)"
                                                                                                            style="user-select: none;">
                                                                                                            <text x="0"
                                                                                                                y="17.049999237060547"
                                                                                                                dy="-4.603">
                                                                                                                <tspan>1
                                                                                                                </tspan>
                                                                                                            </text></g>
                                                                                                    </g>
                                                                                                    <g fill="#000000"
                                                                                                        transform="translate(49,93.5)">
                                                                                                        <g transform="translate(-32,-8.5)"
                                                                                                            style="user-select: none;">
                                                                                                            <text x="0"
                                                                                                                y="17.049999237060547"
                                                                                                                dy="-4.603">
                                                                                                                <tspan>0.5
                                                                                                                </tspan>
                                                                                                            </text></g>
                                                                                                    </g>
                                                                                                    <g fill="#000000"
                                                                                                        transform="translate(49,280.5)">
                                                                                                        <g transform="translate(-38,-8.5)"
                                                                                                            style="user-select: none;">
                                                                                                            <text x="0"
                                                                                                                y="17.049999237060547"
                                                                                                                dy="-4.603">
                                                                                                                <tspan>-0.5
                                                                                                                </tspan>
                                                                                                            </text></g>
                                                                                                    </g>
                                                                                                    <g fill="#000000"
                                                                                                        transform="translate(49,467.5)"
                                                                                                        display="none">
                                                                                                        <g transform="translate(-36,-8.5)"
                                                                                                            style="user-select: none;">
                                                                                                            <text x="0"
                                                                                                                y="17.049999237060547"
                                                                                                                dy="-4.603">
                                                                                                                <tspan>-1.5
                                                                                                                </tspan>
                                                                                                            </text></g>
                                                                                                    </g>
                                                                                                    <g fill="#000000"
                                                                                                        transform="translate(49,561)"
                                                                                                        display="none">
                                                                                                        <g transform="translate(-26,-8.5)"
                                                                                                            style="user-select: none;">
                                                                                                            <text x="0"
                                                                                                                y="17.049999237060547"
                                                                                                                dy="-4.603">
                                                                                                                <tspan>-2
                                                                                                                </tspan>
                                                                                                            </text></g>
                                                                                                    </g>
                                                                                                </g>
                                                                                            </g>
                                                                                            <g stroke="#000000"
                                                                                                stroke-opacity="0"
                                                                                                fill="none"
                                                                                                style="pointer-events: none;"
                                                                                                transform="translate(49,0)">
                                                                                                <path d=" M0,0  L0,374 "
                                                                                                    transform="translate(-0.5,-0.5)">
                                                                                                </path>
                                                                                            </g>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                            <g transform="translate(568,0)">
                                                                                <g></g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <g>
                                                                        <g transform="translate(49,0)"></g>
                                                                    </g>
                                                                    <g transform="translate(0,374)">
                                                                        <g transform="translate(49,0)">
                                                                            <g aria-hidden="true">
                                                                                <g>
                                                                                    <g stroke="#000000" stroke-opacity="0"
                                                                                        fill="none"
                                                                                        style="pointer-events: none;">
                                                                                        <path d=" M0,0  L519,0 "
                                                                                            transform="translate(-0.5,-0.5)">
                                                                                        </path>
                                                                                    </g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <g fill="#000000"
                                                                                                fill-opacity="0"
                                                                                                opacity="0"
                                                                                                stroke-opacity="0"
                                                                                                style="pointer-events: none;"
                                                                                                transform="translate(259.5,0)">
                                                                                                <g transform="translate(-4.5,10)"
                                                                                                    style="user-select: none;">
                                                                                                    <text x="0"
                                                                                                        y="17.049999237060547"
                                                                                                        dy="-4.603">
                                                                                                        <tspan>L</tspan>
                                                                                                    </text></g>
                                                                                            </g>
                                                                                            <g fill="#000000"
                                                                                                transform="translate(51.9,0)">
                                                                                                <g transform="translate(-48.5,10)"
                                                                                                    style="user-select: none;">
                                                                                                    <text x="0"
                                                                                                        y="17.049999237060547"
                                                                                                        dy="-4.603">
                                                                                                        <tspan>ACCOUNTANT
                                                                                                        </tspan>
                                                                                                    </text></g>
                                                                                            </g>
                                                                                            <g fill="#000000"
                                                                                                transform="translate(155.7,25)">
                                                                                                <g transform="translate(-61,10)"
                                                                                                    style="user-select: none;">
                                                                                                    <text x="0"
                                                                                                        y="17.049999237060547"
                                                                                                        dy="-4.603">
                                                                                                        <tspan>Abuja Cash
                                                                                                            Point 1</tspan>
                                                                                                    </text></g>
                                                                                            </g>
                                                                                            <g fill="#000000"
                                                                                                transform="translate(259.5,0)">
                                                                                                <g transform="translate(-66,10)"
                                                                                                    style="user-select: none;">
                                                                                                    <text x="0"
                                                                                                        y="17.049999237060547"
                                                                                                        dy="-4.603">
                                                                                                        <tspan>Gombe Cash
                                                                                                            Point 1</tspan>
                                                                                                    </text></g>
                                                                                            </g>
                                                                                            <g fill="#000000"
                                                                                                transform="translate(363.3,25)">
                                                                                                <g transform="translate(-51,10)"
                                                                                                    style="user-select: none;">
                                                                                                    <text x="0"
                                                                                                        y="17.049999237060547"
                                                                                                        dy="-4.603">
                                                                                                        <tspan>SKO CASHIER 1
                                                                                                        </tspan>
                                                                                                    </text></g>
                                                                                            </g>
                                                                                            <g fill="#000000"
                                                                                                transform="translate(467.1,0)">
                                                                                                <g transform="translate(-52,10)"
                                                                                                    style="user-select: none;">
                                                                                                    <text x="0"
                                                                                                        y="17.049999237060547"
                                                                                                        dy="-4.603">
                                                                                                        <tspan>SKO CASHIER 2
                                                                                                        </tspan>
                                                                                                    </text></g>
                                                                                            </g>
                                                                                            <g fill="#000000"
                                                                                                display="none"
                                                                                                transform="translate(570.9,25)">
                                                                                                <g transform="translate(0,10)"
                                                                                                    display="none"></g>
                                                                                            </g>
                                                                                        </g>
                                                                                    </g>
                                                                                    <g stroke="#000000"
                                                                                        stroke-opacity="0.15"
                                                                                        fill="none" display="none"
                                                                                        transform="translate(519,-374)"
                                                                                        opacity="0" visibility="hidden"
                                                                                        aria-hidden="true">
                                                                                        <path
                                                                                            transform="translate(-0.5,-0.5)"
                                                                                            d=" M0,0  L0,374 "></path>
                                                                                    </g>
                                                                                    <g fill="#000000"
                                                                                        transform="translate(259.5,37)">
                                                                                        <g display="none"></g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g role="group" aria-describedby="id-235-description"
                                                                transform="translate(0,411)">
                                                                <g>
                                                                    <g style="cursor: pointer;" focusable="true"
                                                                        tabindex="0" role="switch"
                                                                        aria-controls="id-217" aria-labelledby="id-217"
                                                                        aria-checked="true"
                                                                        transform="translate(230.5,0)">
                                                                        <g fill="#ffffff" fill-opacity="0">
                                                                            <rect width="107" height="39"></rect>
                                                                        </g>
                                                                        <g transform="translate(0,8)">
                                                                            <g style="pointer-events: none;"
                                                                                fill="#f44336">
                                                                                <g fill="#ffffff" fill-opacity="0"
                                                                                    stroke-opacity="0" stroke="#000000">
                                                                                    <rect width="23" height="23">
                                                                                    </rect>
                                                                                </g>
                                                                                <g>
                                                                                    <g fill="#f44336" fill-opacity="0.8"
                                                                                        stroke="#f44336"
                                                                                        stroke-opacity="1"
                                                                                        stroke-width="2">
                                                                                        <path
                                                                                            d="M3,0 L20,0 a3,3 0 0 1 3,3 L23,20 a3,3 0 0 1 -3,3 L3,23 a3,3 0 0 1 -3,-3 L0,3 a3,3 0 0 1 3,-3 Z">
                                                                                        </path>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                            <g fill="#000000"
                                                                                style="pointer-events: none;"
                                                                                transform="translate(28,3)">
                                                                                <g style="user-select: none;"><text x="0"
                                                                                        y="17.049999237060547"
                                                                                        overflow="hidden" dy="-4.603">
                                                                                        <tspan>Collections</tspan>
                                                                                    </text></g>
                                                                            </g>
                                                                            <g fill="#000000"
                                                                                style="pointer-events: none;"
                                                                                display="none">
                                                                                <g display="none"></g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <desc id="id-235-description">Legend</desc>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                                <desc id="id-112-description">Chart</desc>
                                            </g>
                                            <g>
                                                <g>
                                                    <g role="tooltip" visibility="hidden" opacity="0">
                                                        <g fill="#ffffff" style="pointer-events: none;"
                                                            fill-opacity="0.9" stroke-width="1" stroke-opacity="1"
                                                            stroke="#ffffff" filter="url(&quot;#filter-id-141&quot;)"
                                                            transform="translate(0,6)">
                                                            <path
                                                                d="M3,0 L3,0 L0,-6 L13,0 L21,0 a3,3 0 0 1 3,3 L24,8 a3,3 0 0 1 -3,3 L3,11 a3,3 0 0 1 -3,-3 L0,3 a3,3 0 0 1 3,-3">
                                                            </path>
                                                        </g>
                                                        <g>
                                                            <g fill="#ffffff" style="pointer-events: none;"
                                                                transform="translate(12,6)">
                                                                <g transform="translate(0,7)" display="none"></g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                    <g visibility="hidden" style="pointer-events: none;" display="none">
                                                        <g fill="#ffffff" opacity="1">
                                                            <rect width="598" height="500"></rect>
                                                        </g>
                                                        <g>
                                                            <g transform="translate(299,250)">
                                                                <g>
                                                                    <g stroke-opacity="1" fill="#f3f3f3"
                                                                        fill-opacity="0.8">
                                                                        <g>
                                                                            <g>
                                                                                <path
                                                                                    d=" M53,0  a53,53,0,0,1,-106,0 a53,53,0,0,1,106,0 M42,0  a42,42,0,0,0,-84,0 a42,42,0,0,0,84,0 L42,0 ">
                                                                                </path>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <g stroke-opacity="1" fill="#000000"
                                                                        fill-opacity="0.2">
                                                                        <g>
                                                                            <g>
                                                                                <path
                                                                                    d=" M50,0  a50,50,0,0,1,-100,0 a50,50,0,0,1,100,0 M45,0  a45,45,0,0,0,-90,0 a45,45,0,0,0,90,0 L45,0 ">
                                                                                </path>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <g fill="#000000" fill-opacity="0.4">
                                                                        <g style="user-select: none;"
                                                                            transform="translate(-19,-8.5)"><text x="0"
                                                                                y="17.049999237060547" dy="-4.603">
                                                                                <tspan>100%</tspan>
                                                                            </text></g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                    <g opacity="0.3" style="cursor: pointer;"
                                                        aria-labelledby="id-156-title"
                                                        filter="url(&quot;#filter-id-156&quot;)"
                                                        transform="translate(0,479)">
                                                        <g fill="#ffffff" opacity="0">
                                                            <rect width="66" height="21"></rect>
                                                        </g>
                                                        <g>
                                                            <g shape-rendering="auto" fill="none" stroke-opacity="1"
                                                                stroke-width="1.7999999999999998" stroke="#3cabff">
                                                                <path
                                                                    d=" M15,15  C17.4001,15 22.7998,15.0001 27,15 C31.2002,14.9999 33.2999,6 36,6 C38.7001,6 38.6999,10.5 40.5,10.5 C42.3001,10.5 42.2999,6 45,6 C47.7001,6 50.9999,14.9999 54,15 C57.0002,15.0001 58.7999,15 60,15">
                                                                </path>
                                                            </g>
                                                            <g shape-rendering="auto" fill="none" stroke-opacity="1"
                                                                stroke-width="1.7999999999999998"
                                                                stroke="url(&quot;#gradient-id-159&quot;)">
                                                                <path
                                                                    d=" M6,15  C8.2501,15 9.7498,15.0001 15,15 C20.2502,14.9999 20.7748,3.6 27,3.6 C33.2252,3.6 33.8998,14.9999 39.9,15 C45.9002,15.0001 45.9748,15 51,15 C56.0252,15 57.7499,15 60,15">
                                                                </path>
                                                            </g>
                                                        </g>
                                                        <title id="id-156-title">Chart created using amCharts library
                                                        </title>
                                                    </g>
                                                    <g role="tooltip" visibility="hidden" opacity="0">
                                                        <g fill="#000000" style="pointer-events: none;" fill-opacity="1"
                                                            stroke-width="1" stroke-opacity="1" stroke="#000000"
                                                            transform="translate(64,409)">
                                                            <path
                                                                d="M0,0 L20,0 a0,0 0 0 1 0,0 L20,10 a0,0 0 0 1 -0,0 L0,10 a0,0 0 0 1 -0,-0 L0,0 a0,0 0 0 1 0,-0">
                                                            </path>
                                                        </g>
                                                        <g>
                                                            <g fill="#ffffff" style="pointer-events: none;"
                                                                transform="translate(74,409)">
                                                                <g transform="translate(0,5)" display="none"></g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                    <g role="tooltip" visibility="hidden" opacity="0">
                                                        <g fill="#000000" style="pointer-events: none;" fill-opacity="1"
                                                            stroke-width="1" stroke-opacity="1" stroke="#000000"
                                                            transform="translate(-25,35)">
                                                            <path
                                                                d="M0,0 L20,0 a0,0 0 0 1 0,0 L20,0 L20,0 L25,0 L20,10 L20,10 a0,0 0 0 1 -0,0 L0,10 a0,0 0 0 1 -0,-0 L0,0 a0,0 0 0 1 0,-0">
                                                            </path>
                                                        </g>
                                                        <g>
                                                            <g fill="#ffffff" style="pointer-events: none;"
                                                                transform="translate(-15,35)">
                                                                <g transform="translate(0,5)" display="none"></g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                    <g role="tooltip" visibility="hidden" opacity="0">
                                                        <g fill="#ffffff" style="pointer-events: none;"
                                                            fill-opacity="0.9" stroke-width="1" stroke-opacity="1"
                                                            stroke="#ffffff" filter="url(&quot;#filter-id-227&quot;)"
                                                            transform="translate(6,0)">
                                                            <path
                                                                d="M3,0 L21,0 a3,3 0 0 1 3,3 L24,8 a3,3 0 0 1 -3,3 L3,11 a3,3 0 0 1 -3,-3 L0,8 L0,8 L-6,0 L0,-2 L0,3 a3,3 0 0 1 3,-3">
                                                            </path>
                                                        </g>
                                                        <g>
                                                            <g fill="#ffffff" style="pointer-events: none;"
                                                                transform="translate(18,0)">
                                                                <g transform="translate(0,7)" display="none"></g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                                <ul class="amcharts-amexport-menu amcharts-amexport-menu-level-0 amcharts-amexport-menu-root amcharts-amexport-right amcharts-amexport-top"
                                    role="menu" style="pointer-events: auto;">
                                    <li
                                        class="amcharts-amexport-item amcharts-amexport-item-level-0 amcharts-amexport-item-blank">
                                        <a class="amcharts-amexport-label amcharts-amexport-label-level-0 amcharts-amexport-item-blank"
                                            tabindex="0" role="menuitem"
                                            aria-label="... [Click, tap or press ENTER to open]">...</a>
                                        <ul class="amcharts-amexport-menu amcharts-amexport-menu-level-1">
                                            <li
                                                class="amcharts-amexport-item amcharts-amexport-item-level-1 amcharts-amexport-item-blank">
                                                <a class="amcharts-amexport-label amcharts-amexport-label-level-1 amcharts-amexport-item-blank"
                                                    tabindex="0" role="menuitem"
                                                    aria-label="Image [Click, tap or press ENTER to open]">Image</a>
                                                <ul class="amcharts-amexport-menu amcharts-amexport-menu-level-2">
                                                    <li
                                                        class="amcharts-amexport-item amcharts-amexport-item-level-2 amcharts-amexport-item-png">
                                                        <a class="amcharts-amexport-label amcharts-amexport-label-level-2 amcharts-amexport-item-png amcharts-amexport-clickable"
                                                            tabindex="0" role="menuitem"
                                                            aria-label="Click, tap or press ENTER to export as PNG.">PNG</a>
                                                    </li>
                                                    <li
                                                        class="amcharts-amexport-item amcharts-amexport-item-level-2 amcharts-amexport-item-jpg">
                                                        <a class="amcharts-amexport-label amcharts-amexport-label-level-2 amcharts-amexport-item-jpg amcharts-amexport-clickable"
                                                            tabindex="0" role="menuitem"
                                                            aria-label="Click, tap or press ENTER to export as JPG.">JPG</a>
                                                    </li>
                                                    <li
                                                        class="amcharts-amexport-item amcharts-amexport-item-level-2 amcharts-amexport-item-svg">
                                                        <a class="amcharts-amexport-label amcharts-amexport-label-level-2 amcharts-amexport-item-svg amcharts-amexport-clickable"
                                                            tabindex="0" role="menuitem"
                                                            aria-label="Click, tap or press ENTER to export as SVG.">SVG</a>
                                                    </li>
                                                    <li
                                                        class="amcharts-amexport-item amcharts-amexport-item-level-2 amcharts-amexport-item-pdf">
                                                        <a class="amcharts-amexport-label amcharts-amexport-label-level-2 amcharts-amexport-item-pdf amcharts-amexport-clickable"
                                                            tabindex="0" role="menuitem"
                                                            aria-label="Click, tap or press ENTER to export as PDF.">PDF</a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li
                                                class="amcharts-amexport-item amcharts-amexport-item-level-1 amcharts-amexport-item-blank">
                                                <a class="amcharts-amexport-label amcharts-amexport-label-level-1 amcharts-amexport-item-blank"
                                                    tabindex="0" role="menuitem"
                                                    aria-label="Data [Click, tap or press ENTER to open]">Data</a>
                                                <ul class="amcharts-amexport-menu amcharts-amexport-menu-level-2">
                                                    <li
                                                        class="amcharts-amexport-item amcharts-amexport-item-level-2 amcharts-amexport-item-json">
                                                        <a class="amcharts-amexport-label amcharts-amexport-label-level-2 amcharts-amexport-item-json amcharts-amexport-clickable"
                                                            tabindex="0" role="menuitem"
                                                            aria-label="Click, tap or press ENTER to export as JSON.">JSON</a>
                                                    </li>
                                                    <li
                                                        class="amcharts-amexport-item amcharts-amexport-item-level-2 amcharts-amexport-item-csv">
                                                        <a class="amcharts-amexport-label amcharts-amexport-label-level-2 amcharts-amexport-item-csv amcharts-amexport-clickable"
                                                            tabindex="0" role="menuitem"
                                                            aria-label="Click, tap or press ENTER to export as CSV.">CSV</a>
                                                    </li>
                                                    <li
                                                        class="amcharts-amexport-item amcharts-amexport-item-level-2 amcharts-amexport-item-xlsx">
                                                        <a class="amcharts-amexport-label amcharts-amexport-label-level-2 amcharts-amexport-item-xlsx amcharts-amexport-clickable"
                                                            tabindex="0" role="menuitem"
                                                            aria-label="Click, tap or press ENTER to export as XLSX.">XLSX</a>
                                                    </li>
                                                    <li
                                                        class="amcharts-amexport-item amcharts-amexport-item-level-2 amcharts-amexport-item-html">
                                                        <a class="amcharts-amexport-label amcharts-amexport-label-level-2 amcharts-amexport-item-html amcharts-amexport-clickable"
                                                            tabindex="0" role="menuitem"
                                                            aria-label="Click, tap or press ENTER to export as HTML.">HTML</a>
                                                    </li>
                                                    <li
                                                        class="amcharts-amexport-item amcharts-amexport-item-level-2 amcharts-amexport-item-pdfdata">
                                                        <a class="amcharts-amexport-label amcharts-amexport-label-level-2 amcharts-amexport-item-pdfdata amcharts-amexport-clickable"
                                                            tabindex="0" role="menuitem"
                                                            aria-label="Click, tap or press ENTER to export as PDF.">PDF</a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li
                                                class="amcharts-amexport-item amcharts-amexport-item-level-1 amcharts-amexport-item-print">
                                                <a class="amcharts-amexport-label amcharts-amexport-label-level-1 amcharts-amexport-item-print amcharts-amexport-clickable"
                                                    tabindex="0" role="menuitem"
                                                    aria-label="Click, tap or press ENTER to print.">Print</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div>
            <div class="col-12 col-lg-12 col-xl-6-"><!-- .card -->
                <div class="card card-fluid match-height" style=""><!-- .card-body -->
                    <div class="card-body">
                        <div id="revenue-by-category" class="chartdiv" style="position: relative;">
                            <div dir="ltr" class="resize-sensor"
                                style="pointer-events: none; position: absolute; inset: 0px; overflow: hidden; z-index: -1; visibility: hidden; max-width: 100%;">
                                <div class="resize-sensor-expand"
                                    style="pointer-events: none; position: absolute; inset: 0px; overflow: hidden; z-index: -1; visibility: hidden; max-width: 100%;">
                                    <div
                                        style="position: absolute; left: 0px; top: 0px; transition: all 0s ease 0s; width: 1258px; height: 510px;">
                                    </div>
                                </div>
                                <div class="resize-sensor-shrink"
                                    style="pointer-events: none; position: absolute; inset: 0px; overflow: hidden; z-index: -1; visibility: hidden; max-width: 100%;">
                                    <div
                                        style="position: absolute; left: 0px; top: 0px; transition: all 0s ease 0s; width: 200%; height: 200%;">
                                    </div>
                                </div>
                            </div>
                            <div style="width: 100%; height: 100%; position: relative; top: -0.449951px;"><svg
                                    version="1.1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" role="group"
                                    style="width: 100%; height: 100%; overflow: visible;">
                                    <desc>JavaScript chart by amCharts</desc>
                                    <defs>
                                        <clipPath id="id-46">
                                            <rect width="1248" height="500"></rect>
                                        </clipPath>
                                        <linearGradient id="gradient-id-69" x1="1%" x2="99%" y1="59%"
                                            y2="41%">
                                            <stop stop-color="#474758" offset="0"></stop>
                                            <stop stop-color="#474758" stop-opacity="1" offset="0.75"></stop>
                                            <stop stop-color="#3cabff" stop-opacity="1" offset="0.755"></stop>
                                        </linearGradient>
                                        <clipPath id="id-78"></clipPath>
                                        <filter id="filter-id-51" width="200%" height="200%" x="-50%" y="-50%">
                                            <feGaussianBlur result="blurOut" in="SourceGraphic" stdDeviation="1.5">
                                            </feGaussianBlur>
                                            <feOffset result="offsetBlur" dx="1" dy="1"></feOffset>
                                            <feFlood flood-color="#000000" flood-opacity="0.5"></feFlood>
                                            <feComposite in2="offsetBlur" operator="in"></feComposite>
                                            <feMerge>
                                                <feMergeNode></feMergeNode>
                                                <feMergeNode in="SourceGraphic"></feMergeNode>
                                            </feMerge>
                                        </filter>
                                        <filter id="filter-id-66" width="120%" height="120%" x="-10%" y="-10%">
                                            <feColorMatrix type="saturate" values="0"></feColorMatrix>
                                        </filter>
                                        <filter id="filter-id-83" width="200%" height="200%" x="-50%" y="-50%">
                                            <feGaussianBlur result="blurOut" in="SourceGraphic" stdDeviation="1.5">
                                            </feGaussianBlur>
                                            <feOffset result="offsetBlur" dx="1" dy="1"></feOffset>
                                            <feFlood flood-color="#000000" flood-opacity="0.5"></feFlood>
                                            <feComposite in2="offsetBlur" operator="in"></feComposite>
                                            <feMerge>
                                                <feMergeNode></feMergeNode>
                                                <feMergeNode in="SourceGraphic"></feMergeNode>
                                            </feMerge>
                                        </filter>
                                        <filter id="filter-id-663" width="200%" height="200%" x="-50%" y="-50%">
                                            <feGaussianBlur result="blurOut" in="SourceGraphic" stdDeviation="1.5">
                                            </feGaussianBlur>
                                            <feOffset result="offsetBlur" dx="3" dy="3"></feOffset>
                                            <feFlood flood-color="#000000" flood-opacity="0"></feFlood>
                                            <feComposite in2="offsetBlur" operator="in"></feComposite>
                                            <feMerge>
                                                <feMergeNode></feMergeNode>
                                                <feMergeNode in="SourceGraphic"></feMergeNode>
                                            </feMerge>
                                        </filter>
                                        <filter id="filter-id-629" width="200%" height="200%" x="-50%" y="-50%">
                                            <feGaussianBlur result="blurOut" in="SourceGraphic" stdDeviation="1.5">
                                            </feGaussianBlur>
                                            <feOffset result="offsetBlur" dx="3" dy="3"></feOffset>
                                            <feFlood flood-color="#000000" flood-opacity="0"></feFlood>
                                            <feComposite in2="offsetBlur" operator="in"></feComposite>
                                            <feMerge>
                                                <feMergeNode></feMergeNode>
                                                <feMergeNode in="SourceGraphic"></feMergeNode>
                                            </feMerge>
                                        </filter>
                                        <filter id="filter-id-595" width="200%" height="200%" x="-50%" y="-50%">
                                            <feGaussianBlur result="blurOut" in="SourceGraphic" stdDeviation="1.5">
                                            </feGaussianBlur>
                                            <feOffset result="offsetBlur" dx="3" dy="3"></feOffset>
                                            <feFlood flood-color="#000000" flood-opacity="0"></feFlood>
                                            <feComposite in2="offsetBlur" operator="in"></feComposite>
                                            <feMerge>
                                                <feMergeNode></feMergeNode>
                                                <feMergeNode in="SourceGraphic"></feMergeNode>
                                            </feMerge>
                                        </filter>
                                        <filter id="filter-id-561" width="200%" height="200%" x="-50%" y="-50%">
                                            <feGaussianBlur result="blurOut" in="SourceGraphic" stdDeviation="1.5">
                                            </feGaussianBlur>
                                            <feOffset result="offsetBlur" dx="3" dy="3"></feOffset>
                                            <feFlood flood-color="#000000" flood-opacity="0"></feFlood>
                                            <feComposite in2="offsetBlur" operator="in"></feComposite>
                                            <feMerge>
                                                <feMergeNode></feMergeNode>
                                                <feMergeNode in="SourceGraphic"></feMergeNode>
                                            </feMerge>
                                        </filter>
                                        <filter id="filter-id-527" width="200%" height="200%" x="-50%" y="-50%">
                                            <feGaussianBlur result="blurOut" in="SourceGraphic" stdDeviation="1.5">
                                            </feGaussianBlur>
                                            <feOffset result="offsetBlur" dx="3" dy="3"></feOffset>
                                            <feFlood flood-color="#000000" flood-opacity="0"></feFlood>
                                            <feComposite in2="offsetBlur" operator="in"></feComposite>
                                            <feMerge>
                                                <feMergeNode></feMergeNode>
                                                <feMergeNode in="SourceGraphic"></feMergeNode>
                                            </feMerge>
                                        </filter>
                                        <filter id="filter-id-493" width="200%" height="200%" x="-50%" y="-50%">
                                            <feGaussianBlur result="blurOut" in="SourceGraphic" stdDeviation="1.5">
                                            </feGaussianBlur>
                                            <feOffset result="offsetBlur" dx="3" dy="3"></feOffset>
                                            <feFlood flood-color="#000000" flood-opacity="0"></feFlood>
                                            <feComposite in2="offsetBlur" operator="in"></feComposite>
                                            <feMerge>
                                                <feMergeNode></feMergeNode>
                                                <feMergeNode in="SourceGraphic"></feMergeNode>
                                            </feMerge>
                                        </filter>
                                        <filter id="filter-id-459" width="200%" height="200%" x="-50%" y="-50%">
                                            <feGaussianBlur result="blurOut" in="SourceGraphic" stdDeviation="1.5">
                                            </feGaussianBlur>
                                            <feOffset result="offsetBlur" dx="3" dy="3"></feOffset>
                                            <feFlood flood-color="#000000" flood-opacity="0"></feFlood>
                                            <feComposite in2="offsetBlur" operator="in"></feComposite>
                                            <feMerge>
                                                <feMergeNode></feMergeNode>
                                                <feMergeNode in="SourceGraphic"></feMergeNode>
                                            </feMerge>
                                        </filter>
                                        <filter id="filter-id-424" width="200%" height="200%" x="-50%" y="-50%">
                                            <feGaussianBlur result="blurOut" in="SourceGraphic" stdDeviation="1.5">
                                            </feGaussianBlur>
                                            <feOffset result="offsetBlur" dx="3" dy="3"></feOffset>
                                            <feFlood flood-color="#000000" flood-opacity="0"></feFlood>
                                            <feComposite in2="offsetBlur" operator="in"></feComposite>
                                            <feMerge>
                                                <feMergeNode></feMergeNode>
                                                <feMergeNode in="SourceGraphic"></feMergeNode>
                                            </feMerge>
                                        </filter>
                                    </defs>
                                    <g>
                                        <g fill="#ffffff" fill-opacity="0">
                                            <rect width="1248" height="500"></rect>
                                        </g>
                                        <g>
                                            <g role="region" clip-path="url(&quot;#id-46&quot;)" opacity="1"
                                                aria-describedby="id-22-description">
                                                <g>
                                                    <g fill="#000000" id="id-109" font-size="17"
                                                        transform="translate(510,0)">
                                                        <g style="user-select: none;"><text x="0" y="20.350000381469727"
                                                                dy="-5.495">
                                                                <tspan>Revenue By Service Category</tspan>
                                                            </text></g>
                                                    </g>
                                                    <g transform="translate(0,20)">
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <g transform="translate(624,201)">
                                                                        <g>
                                                                            <g role="menu" opacity="1"
                                                                                aria-describedby="id-73-description">
                                                                                <g>
                                                                                    <g
                                                                                        clip-path="url(&quot;#id-78&quot;)">
                                                                                        <g></g>
                                                                                    </g>
                                                                                    <g></g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <g stroke-opacity="1"
                                                                                                filter="url(&quot;#filter-id-424&quot;)"
                                                                                                style="cursor: pointer;"
                                                                                                stroke="#ffffff"
                                                                                                stroke-width="1"
                                                                                                role="menuitem"
                                                                                                focusable="true"
                                                                                                tabindex="0"
                                                                                                id="id-424"
                                                                                                fill="#f44336">
                                                                                                <g>
                                                                                                    <g>
                                                                                                        <path d=""></path>
                                                                                                    </g>
                                                                                                    <g></g>
                                                                                                </g>
                                                                                            </g>
                                                                                            <g stroke-opacity="1"
                                                                                                filter="url(&quot;#filter-id-459&quot;)"
                                                                                                style="cursor: pointer;"
                                                                                                stroke="#ffffff"
                                                                                                stroke-width="1"
                                                                                                role="menuitem"
                                                                                                focusable="true"
                                                                                                tabindex="0"
                                                                                                id="id-459"
                                                                                                fill="#e91e63">
                                                                                                <g>
                                                                                                    <g>
                                                                                                        <path d=""></path>
                                                                                                    </g>
                                                                                                    <g></g>
                                                                                                </g>
                                                                                            </g>
                                                                                            <g stroke-opacity="1"
                                                                                                filter="url(&quot;#filter-id-493&quot;)"
                                                                                                style="cursor: pointer;"
                                                                                                stroke="#ffffff"
                                                                                                stroke-width="1"
                                                                                                role="menuitem"
                                                                                                focusable="true"
                                                                                                tabindex="0"
                                                                                                id="id-493"
                                                                                                fill="#9c27b0">
                                                                                                <g>
                                                                                                    <g>
                                                                                                        <path d=""></path>
                                                                                                    </g>
                                                                                                    <g></g>
                                                                                                </g>
                                                                                            </g>
                                                                                            <g stroke-opacity="1"
                                                                                                filter="url(&quot;#filter-id-527&quot;)"
                                                                                                style="cursor: pointer;"
                                                                                                stroke="#ffffff"
                                                                                                stroke-width="1"
                                                                                                role="menuitem"
                                                                                                focusable="true"
                                                                                                tabindex="0"
                                                                                                id="id-527"
                                                                                                fill="#673ab7">
                                                                                                <g>
                                                                                                    <g>
                                                                                                        <path d=""></path>
                                                                                                    </g>
                                                                                                    <g></g>
                                                                                                </g>
                                                                                            </g>
                                                                                            <g stroke-opacity="1"
                                                                                                filter="url(&quot;#filter-id-561&quot;)"
                                                                                                style="cursor: pointer;"
                                                                                                stroke="#ffffff"
                                                                                                stroke-width="1"
                                                                                                role="menuitem"
                                                                                                focusable="true"
                                                                                                tabindex="0"
                                                                                                id="id-561"
                                                                                                fill="#3f51b5">
                                                                                                <g>
                                                                                                    <g>
                                                                                                        <path d=""></path>
                                                                                                    </g>
                                                                                                    <g></g>
                                                                                                </g>
                                                                                            </g>
                                                                                            <g stroke-opacity="1"
                                                                                                filter="url(&quot;#filter-id-595&quot;)"
                                                                                                style="cursor: pointer;"
                                                                                                stroke="#ffffff"
                                                                                                stroke-width="1"
                                                                                                role="menuitem"
                                                                                                focusable="true"
                                                                                                tabindex="0"
                                                                                                id="id-595"
                                                                                                fill="#2196f3">
                                                                                                <g>
                                                                                                    <g>
                                                                                                        <path d=""></path>
                                                                                                    </g>
                                                                                                    <g></g>
                                                                                                </g>
                                                                                            </g>
                                                                                            <g stroke-opacity="1"
                                                                                                filter="url(&quot;#filter-id-629&quot;)"
                                                                                                style="cursor: pointer;"
                                                                                                stroke="#ffffff"
                                                                                                stroke-width="1"
                                                                                                role="menuitem"
                                                                                                focusable="true"
                                                                                                tabindex="0"
                                                                                                id="id-629"
                                                                                                fill="#03a9f4">
                                                                                                <g>
                                                                                                    <g>
                                                                                                        <path d=""></path>
                                                                                                    </g>
                                                                                                    <g></g>
                                                                                                </g>
                                                                                            </g>
                                                                                            <g stroke-opacity="1"
                                                                                                filter="url(&quot;#filter-id-663&quot;)"
                                                                                                style="cursor: pointer;"
                                                                                                stroke="#ffffff"
                                                                                                stroke-width="1"
                                                                                                role="menuitem"
                                                                                                focusable="true"
                                                                                                tabindex="0"
                                                                                                id="id-663"
                                                                                                fill="#00bcd4">
                                                                                                <g>
                                                                                                    <g>
                                                                                                        <path d=""></path>
                                                                                                    </g>
                                                                                                    <g></g>
                                                                                                </g>
                                                                                            </g>
                                                                                        </g>
                                                                                    </g>
                                                                                    <g>
                                                                                        <g></g>
                                                                                    </g>
                                                                                    <g>
                                                                                        <g></g>
                                                                                    </g>
                                                                                </g>
                                                                                <desc id="id-73-description">Series</desc>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <g transform="translate(624,240)">
                                                                        <g>
                                                                            <g>
                                                                                <g></g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g role="group" aria-describedby="id-96-description"
                                                                transform="translate(0,402)">
                                                                <g>
                                                                    <g style="cursor: pointer;" focusable="true"
                                                                        tabindex="0" role="switch"
                                                                        aria-controls="id-424" aria-labelledby="id-424"
                                                                        aria-checked="true"
                                                                        transform="translate(30.5,0)">
                                                                        <g fill="#ffffff" fill-opacity="0">
                                                                            <rect width="163" height="39"></rect>
                                                                        </g>
                                                                        <g transform="translate(0,8)">
                                                                            <g style="pointer-events: none;">
                                                                                <g fill="#ffffff" fill-opacity="0"
                                                                                    stroke-opacity="0">
                                                                                    <rect width="23" height="23">
                                                                                    </rect>
                                                                                </g>
                                                                                <g>
                                                                                    <g stroke-opacity="1"
                                                                                        stroke="#ffffff" fill="#f44336">
                                                                                        <path
                                                                                            d="M3,0 L20,0 a3,3 0 0 1 3,3 L23,20 a3,3 0 0 1 -3,3 L3,23 a3,3 0 0 1 -3,-3 L0,3 a3,3 0 0 1 3,-3 Z">
                                                                                        </path>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                            <g fill="#000000"
                                                                                style="pointer-events: none;"
                                                                                transform="translate(28,3)">
                                                                                <g style="user-select: none;"><text x="0"
                                                                                        y="17.049999237060547"
                                                                                        overflow="hidden"
                                                                                        dy="-4.603">
                                                                                        <tspan>Admissions</tspan>
                                                                                    </text></g>
                                                                            </g>
                                                                            <g fill="#000000"
                                                                                style="pointer-events: none;"
                                                                                transform="translate(108,3)">
                                                                                <g style="user-select: none;"><text x="50"
                                                                                        y="17.049999237060547"
                                                                                        dy="-4.603"
                                                                                        text-anchor="end">
                                                                                        <tspan>0.0%</tspan>
                                                                                    </text></g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <g style="cursor: pointer;" focusable="true"
                                                                        tabindex="0" role="switch"
                                                                        aria-controls="id-459" aria-labelledby="id-459"
                                                                        aria-checked="true"
                                                                        transform="translate(268.5,0)">
                                                                        <g fill="#ffffff" fill-opacity="0">
                                                                            <rect width="151" height="39"></rect>
                                                                        </g>
                                                                        <g transform="translate(0,8)">
                                                                            <g style="pointer-events: none;">
                                                                                <g fill="#ffffff" fill-opacity="0"
                                                                                    stroke-opacity="0">
                                                                                    <rect width="23" height="23">
                                                                                    </rect>
                                                                                </g>
                                                                                <g>
                                                                                    <g stroke-opacity="1"
                                                                                        stroke="#ffffff" fill="#e91e63">
                                                                                        <path
                                                                                            d="M3,0 L20,0 a3,3 0 0 1 3,3 L23,20 a3,3 0 0 1 -3,3 L3,23 a3,3 0 0 1 -3,-3 L0,3 a3,3 0 0 1 3,-3 Z">
                                                                                        </path>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                            <g fill="#000000"
                                                                                style="pointer-events: none;"
                                                                                transform="translate(28,3)">
                                                                                <g style="user-select: none;"><text x="0"
                                                                                        y="17.049999237060547"
                                                                                        overflow="hidden"
                                                                                        dy="-4.603">
                                                                                        <tspan>Antenatal</tspan>
                                                                                    </text></g>
                                                                            </g>
                                                                            <g fill="#000000"
                                                                                style="pointer-events: none;"
                                                                                transform="translate(96,3)">
                                                                                <g style="user-select: none;"><text x="50"
                                                                                        y="17.049999237060547"
                                                                                        dy="-4.603"
                                                                                        text-anchor="end">
                                                                                        <tspan>0.0%</tspan>
                                                                                    </text></g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <g style="cursor: pointer;" focusable="true"
                                                                        tabindex="0" role="switch"
                                                                        aria-controls="id-493" aria-labelledby="id-493"
                                                                        aria-checked="true"
                                                                        transform="translate(441.5,0)">
                                                                        <g fill="#ffffff" fill-opacity="0">
                                                                            <rect width="170" height="39"></rect>
                                                                        </g>
                                                                        <g transform="translate(0,8)">
                                                                            <g style="pointer-events: none;">
                                                                                <g fill="#ffffff" fill-opacity="0"
                                                                                    stroke-opacity="0">
                                                                                    <rect width="23" height="23">
                                                                                    </rect>
                                                                                </g>
                                                                                <g>
                                                                                    <g stroke-opacity="1"
                                                                                        stroke="#ffffff" fill="#9c27b0">
                                                                                        <path
                                                                                            d="M3,0 L20,0 a3,3 0 0 1 3,3 L23,20 a3,3 0 0 1 -3,3 L3,23 a3,3 0 0 1 -3,-3 L0,3 a3,3 0 0 1 3,-3 Z">
                                                                                        </path>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                            <g fill="#000000"
                                                                                style="pointer-events: none;"
                                                                                transform="translate(28,3)">
                                                                                <g style="user-select: none;"><text x="0"
                                                                                        y="17.049999237060547"
                                                                                        overflow="hidden"
                                                                                        dy="-4.603">
                                                                                        <tspan>Consultancy</tspan>
                                                                                    </text></g>
                                                                            </g>
                                                                            <g fill="#000000"
                                                                                style="pointer-events: none;"
                                                                                transform="translate(115,3)">
                                                                                <g style="user-select: none;"><text x="50"
                                                                                        y="17.049999237060547"
                                                                                        dy="-4.603"
                                                                                        text-anchor="end">
                                                                                        <tspan>0.0%</tspan>
                                                                                    </text></g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <g style="cursor: pointer;" focusable="true"
                                                                        tabindex="0" role="switch"
                                                                        aria-controls="id-527" aria-labelledby="id-527"
                                                                        aria-checked="true"
                                                                        transform="translate(631.5,0)">
                                                                        <g fill="#ffffff" fill-opacity="0">
                                                                            <rect width="232" height="39"></rect>
                                                                        </g>
                                                                        <g transform="translate(0,8)">
                                                                            <g style="pointer-events: none;">
                                                                                <g fill="#ffffff" fill-opacity="0"
                                                                                    stroke-opacity="0">
                                                                                    <rect width="23" height="23">
                                                                                    </rect>
                                                                                </g>
                                                                                <g>
                                                                                    <g stroke-opacity="1"
                                                                                        stroke="#ffffff" fill="#673ab7">
                                                                                        <path
                                                                                            d="M3,0 L20,0 a3,3 0 0 1 3,3 L23,20 a3,3 0 0 1 -3,3 L3,23 a3,3 0 0 1 -3,-3 L0,3 a3,3 0 0 1 3,-3 Z">
                                                                                        </path>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                            <g fill="#000000"
                                                                                style="pointer-events: none;"
                                                                                transform="translate(28,3)">
                                                                                <g style="user-select: none;"><text x="0"
                                                                                        y="17.049999237060547"
                                                                                        overflow="hidden"
                                                                                        dy="-4.603">
                                                                                        <tspan>Medical Consumables</tspan>
                                                                                    </text></g>
                                                                            </g>
                                                                            <g fill="#000000"
                                                                                style="pointer-events: none;"
                                                                                transform="translate(177,3)">
                                                                                <g style="user-select: none;"><text x="50"
                                                                                        y="17.049999237060547"
                                                                                        dy="-4.603"
                                                                                        text-anchor="end">
                                                                                        <tspan>0.0%</tspan>
                                                                                    </text></g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <g style="cursor: pointer;" focusable="true"
                                                                        tabindex="0" role="switch"
                                                                        aria-controls="id-561" aria-labelledby="id-561"
                                                                        aria-checked="true"
                                                                        transform="translate(883.5,0)">
                                                                        <g fill="#ffffff" fill-opacity="0">
                                                                            <rect width="160" height="39"></rect>
                                                                        </g>
                                                                        <g transform="translate(0,8)">
                                                                            <g style="pointer-events: none;">
                                                                                <g fill="#ffffff" fill-opacity="0"
                                                                                    stroke-opacity="0">
                                                                                    <rect width="23" height="23">
                                                                                    </rect>
                                                                                </g>
                                                                                <g>
                                                                                    <g stroke-opacity="1"
                                                                                        stroke="#ffffff" fill="#3f51b5">
                                                                                        <path
                                                                                            d="M3,0 L20,0 a3,3 0 0 1 3,3 L23,20 a3,3 0 0 1 -3,3 L3,23 a3,3 0 0 1 -3,-3 L0,3 a3,3 0 0 1 3,-3 Z">
                                                                                        </path>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                            <g fill="#000000"
                                                                                style="pointer-events: none;"
                                                                                transform="translate(28,3)">
                                                                                <g style="user-select: none;"><text x="0"
                                                                                        y="17.049999237060547"
                                                                                        overflow="hidden"
                                                                                        dy="-4.603">
                                                                                        <tspan>Laboratory</tspan>
                                                                                    </text></g>
                                                                            </g>
                                                                            <g fill="#000000"
                                                                                style="pointer-events: none;"
                                                                                transform="translate(105,3)">
                                                                                <g style="user-select: none;"><text x="50"
                                                                                        y="17.049999237060547"
                                                                                        dy="-4.603"
                                                                                        text-anchor="end">
                                                                                        <tspan>0.0%</tspan>
                                                                                    </text></g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <g style="cursor: pointer;" focusable="true"
                                                                        tabindex="0" role="switch"
                                                                        aria-controls="id-595" aria-labelledby="id-595"
                                                                        aria-checked="true"
                                                                        transform="translate(1063.5,0)">
                                                                        <g fill="#ffffff" fill-opacity="0">
                                                                            <rect width="154" height="39"></rect>
                                                                        </g>
                                                                        <g transform="translate(0,8)">
                                                                            <g style="pointer-events: none;">
                                                                                <g fill="#ffffff" fill-opacity="0"
                                                                                    stroke-opacity="0">
                                                                                    <rect width="23" height="23">
                                                                                    </rect>
                                                                                </g>
                                                                                <g>
                                                                                    <g stroke-opacity="1"
                                                                                        stroke="#ffffff" fill="#2196f3">
                                                                                        <path
                                                                                            d="M3,0 L20,0 a3,3 0 0 1 3,3 L23,20 a3,3 0 0 1 -3,3 L3,23 a3,3 0 0 1 -3,-3 L0,3 a3,3 0 0 1 3,-3 Z">
                                                                                        </path>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                            <g fill="#000000"
                                                                                style="pointer-events: none;"
                                                                                transform="translate(28,3)">
                                                                                <g style="user-select: none;"><text x="0"
                                                                                        y="17.049999237060547"
                                                                                        overflow="hidden"
                                                                                        dy="-4.603">
                                                                                        <tspan>Pharmacy</tspan>
                                                                                    </text></g>
                                                                            </g>
                                                                            <g fill="#000000"
                                                                                style="pointer-events: none;"
                                                                                transform="translate(99,3)">
                                                                                <g style="user-select: none;"><text x="50"
                                                                                        y="17.049999237060547"
                                                                                        dy="-4.603"
                                                                                        text-anchor="end">
                                                                                        <tspan>0.0%</tspan>
                                                                                    </text></g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <g style="cursor: pointer;" focusable="true"
                                                                        tabindex="0" role="switch"
                                                                        aria-controls="id-629" aria-labelledby="id-629"
                                                                        aria-checked="true"
                                                                        transform="translate(30.5,39)">
                                                                        <g fill="#ffffff" fill-opacity="0">
                                                                            <rect width="218" height="39"></rect>
                                                                        </g>
                                                                        <g transform="translate(0,8)">
                                                                            <g style="pointer-events: none;">
                                                                                <g fill="#ffffff" fill-opacity="0"
                                                                                    stroke-opacity="0">
                                                                                    <rect width="23" height="23">
                                                                                    </rect>
                                                                                </g>
                                                                                <g>
                                                                                    <g stroke-opacity="1"
                                                                                        stroke="#ffffff" fill="#03a9f4">
                                                                                        <path
                                                                                            d="M3,0 L20,0 a3,3 0 0 1 3,3 L23,20 a3,3 0 0 1 -3,3 L3,23 a3,3 0 0 1 -3,-3 L0,3 a3,3 0 0 1 3,-3 Z">
                                                                                        </path>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                            <g fill="#000000"
                                                                                style="pointer-events: none;"
                                                                                transform="translate(28,3)">
                                                                                <g style="user-select: none;"><text x="0"
                                                                                        y="17.049999237060547"
                                                                                        overflow="hidden"
                                                                                        dy="-4.603">
                                                                                        <tspan>Medical Procedures</tspan>
                                                                                    </text></g>
                                                                            </g>
                                                                            <g fill="#000000"
                                                                                style="pointer-events: none;"
                                                                                transform="translate(163,3)">
                                                                                <g style="user-select: none;"><text x="50"
                                                                                        y="17.049999237060547"
                                                                                        dy="-4.603"
                                                                                        text-anchor="end">
                                                                                        <tspan>0.0%</tspan>
                                                                                    </text></g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <g style="cursor: pointer;" focusable="true"
                                                                        tabindex="0" role="switch"
                                                                        aria-controls="id-663" aria-labelledby="id-663"
                                                                        aria-checked="true"
                                                                        transform="translate(268.5,39)">
                                                                        <g fill="#ffffff" fill-opacity="0">
                                                                            <rect width="153" height="39"></rect>
                                                                        </g>
                                                                        <g transform="translate(0,8)">
                                                                            <g style="pointer-events: none;">
                                                                                <g fill="#ffffff" fill-opacity="0"
                                                                                    stroke-opacity="0">
                                                                                    <rect width="23" height="23">
                                                                                    </rect>
                                                                                </g>
                                                                                <g>
                                                                                    <g stroke-opacity="1"
                                                                                        stroke="#ffffff" fill="#00bcd4">
                                                                                        <path
                                                                                            d="M3,0 L20,0 a3,3 0 0 1 3,3 L23,20 a3,3 0 0 1 -3,3 L3,23 a3,3 0 0 1 -3,-3 L0,3 a3,3 0 0 1 3,-3 Z">
                                                                                        </path>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                            <g fill="#000000"
                                                                                style="pointer-events: none;"
                                                                                transform="translate(28,3)">
                                                                                <g style="user-select: none;"><text x="0"
                                                                                        y="17.049999237060547"
                                                                                        overflow="hidden"
                                                                                        dy="-4.603">
                                                                                        <tspan>Radiology</tspan>
                                                                                    </text></g>
                                                                            </g>
                                                                            <g fill="#000000"
                                                                                style="pointer-events: none;"
                                                                                transform="translate(98,3)">
                                                                                <g style="user-select: none;"><text x="50"
                                                                                        y="17.049999237060547"
                                                                                        dy="-4.603"
                                                                                        text-anchor="end">
                                                                                        <tspan>0.0%</tspan>
                                                                                    </text></g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <desc id="id-96-description">Legend</desc>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                                <desc id="id-22-description">Chart</desc>
                                            </g>
                                            <g>
                                                <g>
                                                    <g role="tooltip" visibility="hidden" opacity="0">
                                                        <g fill="#ffffff" style="pointer-events: none;"
                                                            fill-opacity="0.9" stroke-width="1" stroke-opacity="1"
                                                            stroke="#ffffff" filter="url(&quot;#filter-id-51&quot;)"
                                                            transform="translate(0,6)">
                                                            <path
                                                                d="M3,0 L3,0 L0,-6 L13,0 L21,0 a3,3 0 0 1 3,3 L24,8 a3,3 0 0 1 -3,3 L3,11 a3,3 0 0 1 -3,-3 L0,3 a3,3 0 0 1 3,-3">
                                                            </path>
                                                        </g>
                                                        <g>
                                                            <g fill="#ffffff" style="pointer-events: none;"
                                                                transform="translate(12,6)">
                                                                <g transform="translate(0,7)" display="none"></g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                    <g visibility="hidden" style="pointer-events: none;"
                                                        display="none">
                                                        <g fill="#ffffff" opacity="1">
                                                            <rect width="1248" height="500"></rect>
                                                        </g>
                                                        <g>
                                                            <g transform="translate(624,250)">
                                                                <g>
                                                                    <g stroke-opacity="1" fill="#f3f3f3"
                                                                        fill-opacity="0.8">
                                                                        <g>
                                                                            <g>
                                                                                <path
                                                                                    d=" M53,0  a53,53,0,0,1,-106,0 a53,53,0,0,1,106,0 M42,0  a42,42,0,0,0,-84,0 a42,42,0,0,0,84,0 L42,0 ">
                                                                                </path>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <g stroke-opacity="1" fill="#000000"
                                                                        fill-opacity="0.2">
                                                                        <g>
                                                                            <g>
                                                                                <path
                                                                                    d=" M50,0  a50,50,0,0,1,-100,0 a50,50,0,0,1,100,0 M45,0  a45,45,0,0,0,-90,0 a45,45,0,0,0,90,0 L45,0 ">
                                                                                </path>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <g fill="#000000" fill-opacity="0.4">
                                                                        <g style="user-select: none;"
                                                                            transform="translate(-19,-8.5)"><text x="0"
                                                                                y="17.049999237060547" dy="-4.603">
                                                                                <tspan>100%</tspan>
                                                                            </text></g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                    <g opacity="0.3" style="cursor: pointer;"
                                                        aria-labelledby="id-66-title"
                                                        filter="url(&quot;#filter-id-66&quot;)"
                                                        transform="translate(0,479)">
                                                        <g fill="#ffffff" opacity="0">
                                                            <rect width="66" height="21"></rect>
                                                        </g>
                                                        <g>
                                                            <g shape-rendering="auto" fill="none"
                                                                stroke-opacity="1" stroke-width="1.7999999999999998"
                                                                stroke="#3cabff">
                                                                <path
                                                                    d=" M15,15  C17.4001,15 22.7998,15.0001 27,15 C31.2002,14.9999 33.2999,6 36,6 C38.7001,6 38.6999,10.5 40.5,10.5 C42.3001,10.5 42.2999,6 45,6 C47.7001,6 50.9999,14.9999 54,15 C57.0002,15.0001 58.7999,15 60,15">
                                                                </path>
                                                            </g>
                                                            <g shape-rendering="auto" fill="none"
                                                                stroke-opacity="1" stroke-width="1.7999999999999998"
                                                                stroke="url(&quot;#gradient-id-69&quot;)">
                                                                <path
                                                                    d=" M6,15  C8.2501,15 9.7498,15.0001 15,15 C20.2502,14.9999 20.7748,3.6 27,3.6 C33.2252,3.6 33.8998,14.9999 39.9,15 C45.9002,15.0001 45.9748,15 51,15 C56.0252,15 57.7499,15 60,15">
                                                                </path>
                                                            </g>
                                                        </g>
                                                        <title id="id-66-title">Chart created using amCharts library
                                                        </title>
                                                    </g>
                                                    <g role="tooltip" visibility="hidden" opacity="0">
                                                        <g fill="#ffffff" style="pointer-events: none;"
                                                            fill-opacity="0.9" stroke-width="1" stroke-opacity="1"
                                                            stroke="#ffffff" filter="url(&quot;#filter-id-83&quot;)"
                                                            transform="translate(0,6)">
                                                            <path
                                                                d="M3,0 L3,0 L0,-6 L13,0 L21,0 a3,3 0 0 1 3,3 L24,8 a3,3 0 0 1 -3,3 L3,11 a3,3 0 0 1 -3,-3 L0,3 a3,3 0 0 1 3,-3">
                                                            </path>
                                                        </g>
                                                        <g>
                                                            <g fill="#ffffff" style="pointer-events: none;"
                                                                transform="translate(12,6)">
                                                                <g transform="translate(0,7)" display="none"></g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                                <ul class="amcharts-amexport-menu amcharts-amexport-menu-level-0 amcharts-amexport-menu-root amcharts-amexport-right amcharts-amexport-top"
                                    role="menu" style="pointer-events: auto;">
                                    <li
                                        class="amcharts-amexport-item amcharts-amexport-item-level-0 amcharts-amexport-item-blank">
                                        <a class="amcharts-amexport-label amcharts-amexport-label-level-0 amcharts-amexport-item-blank"
                                            tabindex="0" role="menuitem"
                                            aria-label="... [Click, tap or press ENTER to open]">...</a>
                                        <ul class="amcharts-amexport-menu amcharts-amexport-menu-level-1">
                                            <li
                                                class="amcharts-amexport-item amcharts-amexport-item-level-1 amcharts-amexport-item-blank">
                                                <a class="amcharts-amexport-label amcharts-amexport-label-level-1 amcharts-amexport-item-blank"
                                                    tabindex="0" role="menuitem"
                                                    aria-label="Image [Click, tap or press ENTER to open]">Image</a>
                                                <ul class="amcharts-amexport-menu amcharts-amexport-menu-level-2">
                                                    <li
                                                        class="amcharts-amexport-item amcharts-amexport-item-level-2 amcharts-amexport-item-png">
                                                        <a class="amcharts-amexport-label amcharts-amexport-label-level-2 amcharts-amexport-item-png amcharts-amexport-clickable"
                                                            tabindex="0" role="menuitem"
                                                            aria-label="Click, tap or press ENTER to export as PNG.">PNG</a>
                                                    </li>
                                                    <li
                                                        class="amcharts-amexport-item amcharts-amexport-item-level-2 amcharts-amexport-item-jpg">
                                                        <a class="amcharts-amexport-label amcharts-amexport-label-level-2 amcharts-amexport-item-jpg amcharts-amexport-clickable"
                                                            tabindex="0" role="menuitem"
                                                            aria-label="Click, tap or press ENTER to export as JPG.">JPG</a>
                                                    </li>
                                                    <li
                                                        class="amcharts-amexport-item amcharts-amexport-item-level-2 amcharts-amexport-item-svg">
                                                        <a class="amcharts-amexport-label amcharts-amexport-label-level-2 amcharts-amexport-item-svg amcharts-amexport-clickable"
                                                            tabindex="0" role="menuitem"
                                                            aria-label="Click, tap or press ENTER to export as SVG.">SVG</a>
                                                    </li>
                                                    <li
                                                        class="amcharts-amexport-item amcharts-amexport-item-level-2 amcharts-amexport-item-pdf">
                                                        <a class="amcharts-amexport-label amcharts-amexport-label-level-2 amcharts-amexport-item-pdf amcharts-amexport-clickable"
                                                            tabindex="0" role="menuitem"
                                                            aria-label="Click, tap or press ENTER to export as PDF.">PDF</a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li
                                                class="amcharts-amexport-item amcharts-amexport-item-level-1 amcharts-amexport-item-blank">
                                                <a class="amcharts-amexport-label amcharts-amexport-label-level-1 amcharts-amexport-item-blank"
                                                    tabindex="0" role="menuitem"
                                                    aria-label="Data [Click, tap or press ENTER to open]">Data</a>
                                                <ul class="amcharts-amexport-menu amcharts-amexport-menu-level-2">
                                                    <li
                                                        class="amcharts-amexport-item amcharts-amexport-item-level-2 amcharts-amexport-item-json">
                                                        <a class="amcharts-amexport-label amcharts-amexport-label-level-2 amcharts-amexport-item-json amcharts-amexport-clickable"
                                                            tabindex="0" role="menuitem"
                                                            aria-label="Click, tap or press ENTER to export as JSON.">JSON</a>
                                                    </li>
                                                    <li
                                                        class="amcharts-amexport-item amcharts-amexport-item-level-2 amcharts-amexport-item-csv">
                                                        <a class="amcharts-amexport-label amcharts-amexport-label-level-2 amcharts-amexport-item-csv amcharts-amexport-clickable"
                                                            tabindex="0" role="menuitem"
                                                            aria-label="Click, tap or press ENTER to export as CSV.">CSV</a>
                                                    </li>
                                                    <li
                                                        class="amcharts-amexport-item amcharts-amexport-item-level-2 amcharts-amexport-item-xlsx">
                                                        <a class="amcharts-amexport-label amcharts-amexport-label-level-2 amcharts-amexport-item-xlsx amcharts-amexport-clickable"
                                                            tabindex="0" role="menuitem"
                                                            aria-label="Click, tap or press ENTER to export as XLSX.">XLSX</a>
                                                    </li>
                                                    <li
                                                        class="amcharts-amexport-item amcharts-amexport-item-level-2 amcharts-amexport-item-html">
                                                        <a class="amcharts-amexport-label amcharts-amexport-label-level-2 amcharts-amexport-item-html amcharts-amexport-clickable"
                                                            tabindex="0" role="menuitem"
                                                            aria-label="Click, tap or press ENTER to export as HTML.">HTML</a>
                                                    </li>
                                                    <li
                                                        class="amcharts-amexport-item amcharts-amexport-item-level-2 amcharts-amexport-item-pdfdata">
                                                        <a class="amcharts-amexport-label amcharts-amexport-label-level-2 amcharts-amexport-item-pdfdata amcharts-amexport-clickable"
                                                            tabindex="0" role="menuitem"
                                                            aria-label="Click, tap or press ENTER to export as PDF.">PDF</a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li
                                                class="amcharts-amexport-item amcharts-amexport-item-level-1 amcharts-amexport-item-print">
                                                <a class="amcharts-amexport-label amcharts-amexport-label-level-1 amcharts-amexport-item-print amcharts-amexport-clickable"
                                                    tabindex="0" role="menuitem"
                                                    aria-label="Click, tap or press ENTER to print.">Print</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /grid column -->
        </div><!-- /grid row -->
    </div>
@endsection
