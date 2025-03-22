@extends('layouts/layoutMaster')

@section('title', 'Waiting List')

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
        <div class="card-body">
            <div class="form-group"><!-- .input-group -->
                <form id="filter-form"><input type="hidden" name="csrfmiddlewaretoken"
                        value="HxrxryzOLwxiWECgxiCIY9c8rX7lbq6K1jPd7xQoZjELOAQlXxMu6GYePFBX2s7K">
                    <div class="d-flex justify-content-between"><select name="clinic"
                            class="filter form-control custom-select mr-2">
                            <option disabled="" selected="">Filter By Clinic</option>
                            <option value="">All</option>
                            <option value="1">DIAGNOSTICS</option>
                            <option value="3">GENERAL CONSULTATION</option>
                            <option value="4">MEDICAL CHECK-UP</option>
                            <option value="6">PSYCHIATRY</option>
                            <option value="5">RETAINERSHIP</option>
                            <option value="2">SPECIALIST CLINIC</option>
                        </select><select name="group" class="filter form-control custom-select mr-2">
                            <option disabled="" selected="">Filter By Queue Type</option>
                            <option value="">All</option>
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
                            <option value="nursing">Nursing</option>
                            <option value="billing">Billing</option>
                        </select><select name="specialty" class="filter form-control custom-select mr-2">
                            <option disabled="" selected="">Filter By Specialty</option>
                            <option value="">All</option>
                            <option value="15">....</option>
                            <option value="14">BACK PAIN</option>
                            <option value="22">BASIC MEDICAL CHECK-UP (FEMALE)</option>
                            <option value="18">BASIC MEDICAL CHECK-UP (MALE)</option>
                            <option value="10">CADIOLOGY</option>
                            <option value="33">CADIOLOGY</option>
                            <option value="21">COMPLETE MEDICAL CHECK-UP (MALE)</option>
                            <option value="17">COMPLETE MEDICAL CKECH-UP (FEMALE)</option>
                            <option value="24">COMPREHENSIVE MEDICAL CHECK-UP (FEMALE)</option>
                            <option value="20">COMPREHENSIVE MEDICAL CHECK-UP (MALE)</option>
                            <option value="16">DENTAL SURGEON</option>
                            <option value="29">DERMATOLOGIST</option>
                            <option value="37">ENDOCRINOLOGIST</option>
                            <option value="6">ENT</option>
                            <option value="23">EXECUTE MEDICAL CHECK-UP (FEMALE)</option>
                            <option value="19">EXECUTIVE MEDICAL CHECK-UP (MALE)</option>
                            <option value="2">GASTROENTROLOGIST</option>
                            <option value="1">GENERAL CONSULTATION</option>
                            <option value="12">GENERAL SURGEON</option>
                            <option value="3">GYNAECOLOGIST</option>
                            <option value="11">NEPHROLOGY</option>
                            <option value="9">NEUROLOGY</option>
                            <option value="4">NUERO PAEDIATRICS</option>
                            <option value="13">Neurosurgeon</option>
                            <option value="38">ONCOLOGIST</option>
                            <option value="7">OPHTHALMOLOGY</option>
                            <option value="39">OPTHALMOLOGY</option>
                            <option value="26">ORTHOPAEDICS</option>
                            <option value="31">PAEDIATRIC SURGEON</option>
                            <option value="32">PEDIATRICS</option>
                            <option value="28">PLASTIC SURGEON</option>
                            <option value="25">PSYCHIATRY</option>
                            <option value="35">Physiotherapy</option>
                            <option value="5">RADIOLOGIST</option>
                            <option value="27">RHEUMATOLIGIST</option>
                            <option value="30">SPINE SURGEON</option>
                            <option value="40">STAFF CONSULTATION</option>
                            <option value="34">UROLOGIST</option>
                            <option value="8">UROLOGY</option>
                            <option value="36">UROLOGY (DIS)</option>
                        </select><select name="patient_id" id="patient_id"
                            class="filter form-control ml-2 w-100 custom-select select2-hidden-accessible"
                            data-placeholder="Filter By Patient" data-select2-id="patient_id" tabindex="-1"
                            aria-hidden="true"></select><span class="select2 select2-container select2-container--default"
                            dir="ltr" data-select2-id="1" style="width: 900px;"><span class="selection"><span
                                    class="select2-selection select2-selection--single" role="combobox"
                                    aria-haspopup="true" aria-expanded="false" tabindex="0"
                                    aria-labelledby="select2-patient_id-container"><span
                                        class="select2-selection__rendered" id="select2-patient_id-container"
                                        role="textbox" aria-readonly="true"><span
                                            class="select2-selection__placeholder">Filter By Patient</span></span><span
                                        class="select2-selection__arrow" role="presentation"><b
                                            role="presentation"></b></span></span></span><span class="dropdown-wrapper"
                                aria-hidden="true"></span></span></div>
                </form>
            </div>
            <div id="container_area_response">
                <div class="table-responsive table-hover">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Time In</th>
                                <th>Patient</th>
                                <th>Type</th>
                                <th>Specialty</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="">
                                <td>14th Dec, 2023 8:51AM</td>
                                <td><a href="/patient/22340">Muhammad, Tukur [CID022340]</a></td>
                                <td>Radiology</td>
                                <td>- -</td>
                                <td class="text-right">
                                    <div class="btn-group btn-group-sm mr-2" role="group"><button type="button"
                                            class="btn  btn-success btn-sm"
                                            onclick="queueAction('22340', 'radiology', 'attend', '65319')">
                                            Attend To
                                        </button><button type="button" class="btn btn-danger btn-sm"
                                            onclick="queueAction('22340', 'radiology', 'hold', '65319')">
                                            Hold
                                        </button></div>
                                </td>
                            </tr>
                            <tr class="">
                                <td>14th Dec, 2023 8:53AM</td>
                                <td><a href="/patient/22341">Aliyu, Abdullahi [CID022341]</a></td>
                                <td>Laboratory</td>
                                <td>- -</td>
                                <td class="text-right">
                                    <div class="btn-group btn-group-sm mr-2" role="group"><button type="button"
                                            class="btn  btn-success btn-sm"
                                            onclick="queueAction('22341', 'lab', 'attend', '65320')">
                                            Attend To
                                        </button><button type="button" class="btn btn-danger btn-sm"
                                            onclick="queueAction('22341', 'lab', 'hold', '65320')">
                                            Hold
                                        </button></div>
                                </td>
                            </tr>
                            <tr class="">
                                <td>14th Dec, 2023 8:53AM</td>
                                <td><a href="/patient/22341">Aliyu, Abdullahi [CID022341]</a></td>
                                <td>Laboratory</td>
                                <td>- -</td>
                                <td class="text-right">
                                    <div class="btn-group btn-group-sm mr-2" role="group"><button type="button"
                                            class="btn  btn-success btn-sm"
                                            onclick="queueAction('22341', 'lab', 'attend', '65321')">
                                            Attend To
                                        </button><button type="button" class="btn btn-danger btn-sm"
                                            onclick="queueAction('22341', 'lab', 'hold', '65321')">
                                            Hold
                                        </button></div>
                                </td>
                            </tr>
                            <tr class="">
                                <td>14th Dec, 2023 8:55AM</td>
                                <td><a href="/patient/19288">Yusuf, Ahmad [CID019288]</a></td>
                                <td>Radiology</td>
                                <td>- -</td>
                                <td class="text-right">
                                    <div class="btn-group btn-group-sm mr-2" role="group"><button type="button"
                                            class="btn  btn-success btn-sm"
                                            onclick="queueAction('19288', 'radiology', 'attend', '65322')">
                                            Attend To
                                        </button><button type="button" class="btn btn-danger btn-sm"
                                            onclick="queueAction('19288', 'radiology', 'hold', '65322')">
                                            Hold
                                        </button></div>
                                </td>
                            </tr>
                            <tr class="">
                                <td>14th Dec, 2023 8:57AM</td>
                                <td><a href="/patient/22342">Aliyu, Fatima [CID022342]</a></td>
                                <td>Radiology</td>
                                <td>- -</td>
                                <td class="text-right">
                                    <div class="btn-group btn-group-sm mr-2" role="group"><button type="button"
                                            class="btn  btn-success btn-sm"
                                            onclick="queueAction('22342', 'radiology', 'attend', '65323')">
                                            Attend To
                                        </button><button type="button" class="btn btn-danger btn-sm"
                                            onclick="queueAction('22342', 'radiology', 'hold', '65323')">
                                            Hold
                                        </button></div>
                                </td>
                            </tr>
                            <tr class="">
                                <td>14th Dec, 2023 8:59AM</td>
                                <td><a href="/patient/22343">Umar, Umar [CID022343]</a></td>
                                <td>Radiology</td>
                                <td>- -</td>
                                <td class="text-right">
                                    <div class="btn-group btn-group-sm mr-2" role="group"><button type="button"
                                            class="btn  btn-success btn-sm"
                                            onclick="queueAction('22343', 'radiology', 'attend', '65324')">
                                            Attend To
                                        </button><button type="button" class="btn btn-danger btn-sm"
                                            onclick="queueAction('22343', 'radiology', 'hold', '65324')">
                                            Hold
                                        </button></div>
                                </td>
                            </tr>
                            <tr class="">
                                <td>14th Dec, 2023 9:00AM</td>
                                <td><a href="/patient/22343">Umar, Umar [CID022343]</a></td>
                                <td>Radiology</td>
                                <td>- -</td>
                                <td class="text-right">
                                    <div class="btn-group btn-group-sm mr-2" role="group"><button type="button"
                                            class="btn  btn-success btn-sm"
                                            onclick="queueAction('22343', 'radiology', 'attend', '65325')">
                                            Attend To
                                        </button><button type="button" class="btn btn-danger btn-sm"
                                            onclick="queueAction('22343', 'radiology', 'hold', '65325')">
                                            Hold
                                        </button></div>
                                </td>
                            </tr>
                            <tr class="">
                                <td>14th Dec, 2023 9:02AM</td>
                                <td><a href="/patient/22344">Ibrahim, Musa [CID022344]</a></td>
                                <td>Laboratory</td>
                                <td>- -</td>
                                <td class="text-right">
                                    <div class="btn-group btn-group-sm mr-2" role="group"><button type="button"
                                            class="btn  btn-success btn-sm"
                                            onclick="queueAction('22344', 'lab', 'attend', '65326')">
                                            Attend To
                                        </button><button type="button" class="btn btn-danger btn-sm"
                                            onclick="queueAction('22344', 'lab', 'hold', '65326')">
                                            Hold
                                        </button></div>
                                </td>
                            </tr>
                            <tr class="">
                                <td>14th Dec, 2023 9:02AM</td>
                                <td><a href="/patient/22344">Ibrahim, Musa [CID022344]</a></td>
                                <td>Laboratory</td>
                                <td>- -</td>
                                <td class="text-right">
                                    <div class="btn-group btn-group-sm mr-2" role="group"><button type="button"
                                            class="btn  btn-success btn-sm"
                                            onclick="queueAction('22344', 'lab', 'attend', '65327')">
                                            Attend To
                                        </button><button type="button" class="btn btn-danger btn-sm"
                                            onclick="queueAction('22344', 'lab', 'hold', '65327')">
                                            Hold
                                        </button></div>
                                </td>
                            </tr>
                            <tr class="">
                                <td>14th Dec, 2023 9:06AM</td>
                                <td><a href="/patient/22346">Umar, Ahmad Tijani [CID022346]</a></td>
                                <td>Consultancy</td>
                                <td>GENERAL CONSULTATION</td>
                                <td class="text-right">
                                    <div class="btn-group btn-group-sm mr-2" role="group"><button type="button"
                                            class="btn  btn-success btn-sm"
                                            onclick="queueAction('22346', 'consultation', 'attend', '65328')">
                                            Attend To
                                        </button><button type="button" class="btn btn-danger btn-sm"
                                            onclick="queueAction('22346', 'consultation', 'hold', '65328')">
                                            Hold
                                        </button></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <hr class="my-2">
                    <div class="d-flex justify-content-around">
                        <ul class="pagination">
                            <li class="page-item disabled"><a class="page-link" href="javascript:"><span
                                        class="oi oi-arrow-left"></span> Previous</a></li>
                            <li class="page-item active"><span class="page-link" href="javascript:"> 1 - 10 of 144</span>
                            </li>
                            <li class="page-item"><a class="page-link" href="javascript:" data-page="2"
                                    data-href="?page=2">Next <span class="oi oi-arrow-right"></span></a></li>
                        </ul><input type="hidden" class="sr-only filter" name="page" value="1">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
