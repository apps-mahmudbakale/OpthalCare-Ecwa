@extends('layouts/layoutMaster')

@section('title', 'Delivery Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">Delivery /</span> Details
        </h4>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
            <i class="ti ti-arrow-left me-1"></i> Back
        </a>
    </div>

    <!-- Patient Info -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="ti ti-user me-2"></i>Patient Information
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <strong>Name:</strong> {{ $delivery->patient->user->firstname }} {{ $delivery->patient->user->lastname }}
                </div>
                <div class="col-md-6">
                    <strong>Hospital No:</strong> {{ $delivery->patient->hospital_no }}
                </div>
            </div>
        </div>
    </div>

    <!-- Delivery Information -->
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ti ti-baby-carriage me-2"></i>Delivery Information
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><td><strong>Delivery Date:</strong></td><td>{{ $delivery->delivery_date->format('M d, Y h:i A') }}</td></tr>
                        <tr><td><strong>Type:</strong></td><td><span class="badge bg-{{ $delivery->delivery_type == 'normal' ? 'success' : 'warning' }}">{{ ucfirst($delivery->delivery_type) }}</span></td></tr>
                        <tr><td><strong>Presentation:</strong></td><td>{{ $delivery->presentation ? ucfirst($delivery->presentation) : '—' }}</td></tr>
                        <tr><td><strong>Gestation:</strong></td><td>{{ $delivery->gestation ?? '—' }}</td></tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ti ti-clock me-2"></i>Labor Information
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><td><strong>Labor Onset:</strong></td><td>{{ $delivery->labor_onset ? $delivery->labor_onset->format('M d, Y h:i A') : '—' }}</td></tr>
                        <tr><td><strong>Duration:</strong></td><td>{{ $delivery->labor_duration ?? '—' }}</td></tr>
                        <tr><td><strong>Complications:</strong></td><td>{{ $delivery->labor_complications ?? '—' }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Baby Information -->
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ti ti-baby me-2"></i>Baby Information
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><td><strong>Gender:</strong></td><td>{{ $delivery->baby_gender ? ucfirst($delivery->baby_gender) : '—' }}</td></tr>
                        <tr><td><strong>Birth Weight:</strong></td><td>{{ $delivery->birth_weight ? $delivery->birth_weight . ' kg' : '—' }}</td></tr>
                        <tr><td><strong>Birth Length:</strong></td><td>{{ $delivery->birth_length ? $delivery->birth_length . ' cm' : '—' }}</td></tr>
                        <tr><td><strong>Head Circumference:</strong></td><td>{{ $delivery->head_circumference ? $delivery->head_circumference . ' cm' : '—' }}</td></tr>
                        <tr><td><strong>APGAR Scores:</strong></td><td>
                            @if($delivery->apgar_1_min || $delivery->apgar_5_min)
                                1min: {{ $delivery->apgar_1_min ?? '—' }}, 5min: {{ $delivery->apgar_5_min ?? '—' }}
                            @else
                                —
                            @endif
                        </td></tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ti ti-user-heart me-2"></i>Maternal Information
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><td><strong>Blood Loss:</strong></td><td>{{ $delivery->blood_loss ? $delivery->blood_loss . ' ml' : '—' }}</td></tr>
                        <tr><td><strong>Perineal Condition:</strong></td><td>{{ $delivery->perineal_condition ?? '—' }}</td></tr>
                        <tr><td><strong>Placenta Delivery:</strong></td><td>{{ $delivery->placenta_delivery ? ucfirst($delivery->placenta_delivery) : '—' }}</td></tr>
                        <tr><td><strong>Placenta Weight:</strong></td><td>{{ $delivery->placenta_weight ? $delivery->placenta_weight . ' g' : '—' }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Conditions and Notes -->
    <div class="row">
        @if($delivery->baby_condition)
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Baby Condition</h5>
                </div>
                <div class="card-body">
                    <p>{{ $delivery->baby_condition }}</p>
                </div>
            </div>
        </div>
        @endif

        @if($delivery->maternal_condition)
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Maternal Condition</h5>
                </div>
                <div class="card-body">
                    <p>{{ $delivery->maternal_condition }}</p>
                </div>
            </div>
        </div>
        @endif

        @if($delivery->complications)
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Complications</h5>
                </div>
                <div class="card-body">
                    <p>{{ $delivery->complications }}</p>
                </div>
            </div>
        </div>
        @endif

        @if($delivery->delivery_notes)
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Delivery Notes</h5>
                </div>
                <div class="card-body">
                    <p>{{ $delivery->delivery_notes }}</p>
                </div>
            </div>
        </div>
        @endif

        @if($delivery->recommendations)
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recommendations</h5>
                </div>
                <div class="card-body">
                    <p>{{ $delivery->recommendations }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Record Info -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Record Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <strong>Recorded By:</strong> {{ $delivery->user->firstname }} {{ $delivery->user->lastname }}
                </div>
                <div class="col-md-6">
                    <strong>Recorded On:</strong> {{ $delivery->created_at->format('M d, Y h:i A') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection