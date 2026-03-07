@extends('layouts/layoutMaster')

@section('title', 'Antenatal Records')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
@endsection

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Antenatal /</span> Records</h4>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#enroll-antenatal-modal">
            <i class="ti ti-plus me-1"></i> Enroll Patient
        </button>
    </div>
    <div class="card">
        <livewire:antenatal-record-list />
    </div>

    <!-- Enroll Patient Modal -->
    <div class="modal fade" id="enroll-antenatal-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Enroll Patient for Antenatal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('app.antenatal-records.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Patient <span class="text-danger">*</span></label>
                                <select name="patient_id" class="form-select select2" required>
                                    <option value="">Select Patient</option>
                                    @foreach(\App\Models\Patient::with('user')->get() as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->user->firstname }} {{ $patient->user->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Visit Date</label>
                                <input type="text" name="visit_date" class="form-control flatpickr" placeholder="Select date" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Complaint</label>
                                <textarea name="complaint" class="form-control" rows="3" placeholder="Chief complaint..."></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Treatment Plan</label>
                                <textarea name="treatment_plan" class="form-control" rows="3" placeholder="Treatment plan..."></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Notes</label>
                                <textarea name="note" class="form-control" rows="3" placeholder="Additional notes..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Enroll Patient</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                dropdownParent: $('#enroll-antenatal-modal'),
                placeholder: 'Select Patient',
                allowClear: true
            });
            $('.flatpickr').flatpickr({
                dateFormat: 'Y-m-d'
            });
        });
    </script>
@endsection
