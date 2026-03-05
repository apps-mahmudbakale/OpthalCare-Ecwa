@extends('layouts/layoutMaster')

@section('title', 'Procedure Profile')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Procedure /</span> Profile
</h4>

<div class="row">
  <!-- Procedure Detail -->
  <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
    <!-- Procedure Card -->
    <div class="card mb-4">
      <div class="card-body">
        <div class="user-avatar-section">
          <div class="d-flex align-items-center flex-column">
            <div class="user-info text-center">
              <h4 class="mb-2">{{ $procedureRequest->procedure->name }}</h4>
              <span class="badge bg-label-secondary">{{ $procedureRequest->procedure->category->name ?? 'N/A' }}</span>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-around flex-wrap my-4 py-3">
          <div class="d-flex align-items-start me-4 mt-3 gap-3">
            <span class="badge bg-label-primary p-2 rounded"><i class='ti ti-checkbox ti-sm'></i></span>
            <div>
              <h5 class="mb-0">{{ $procedureRequest->status }}</h5>
              <span>Status</span>
            </div>
          </div>
          <div class="d-flex align-items-start mt-3 gap-3">
            <span class="badge bg-label-primary p-2 rounded"><i class='ti ti-briefcase ti-sm'></i></span>
            <div>
              <h5 class="mb-0">{{ $procedureRequest->request_ref }}</h5>
              <span>Reference</span>
            </div>
          </div>
        </div>
        <p class="mt-4 small text-uppercase text-muted">Details</p>
        <div class="info-container">
          <ul class="list-unstyled">
            <li class="mb-2">
              <span class="fw-semibold me-1">Patient:</span>
              <span>{{ $procedureRequest->patient->user->firstname }} {{ $procedureRequest->patient->user->lastname }}</span>
            </li>
            <li class="mb-2 pt-1">
              <span class="fw-semibold me-1">Requested By:</span>
              <span>{{ $procedureRequest->user->firstname }} {{ $procedureRequest->user->lastname }}</span>
            </li>
            <li class="mb-2 pt-1">
              <span class="fw-semibold me-1">Request Date:</span>
              <span>{{ $procedureRequest->created_at->format('M d, Y h:i A') }}</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- /Procedure Card -->
  </div>
  <!--/ Procedure Detail -->

  <!-- Procedure Actions & Content -->
  <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
    <div class="nav-align-top mb-4">
      <ul class="nav nav-pills mb-3" role="tablist">
        <li class="nav-item">
          <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-overview" aria-controls="navs-pills-overview" aria-selected="true">Overview</button>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade show active" id="navs-pills-overview" role="tabpanel">
           <div class="card mb-4">
            <h5 class="card-header">Procedure Information</h5>
            <div class="card-body">
              <p>This page displays the details for procedure <strong>{{ $procedureRequest->procedure->name }}</strong> requested for <strong>{{ $procedureRequest->patient->user->firstname }} {{ $procedureRequest->patient->user->lastname }}</strong>.</p>
              
              <div class="row">
                  <div class="col-md-6 mb-3">
                      <label class="form-label fw-bold">Current Status</label>
                      <div>
                          @if($procedureRequest->status == 'Pending')
                            <span class="badge bg-label-warning">Scheduled / Pending</span>
                          @else
                            <span class="badge bg-label-success">{{ $procedureRequest->status }}</span>
                          @endif
                      </div>
                  </div>
                  <div class="col-md-6 mb-3">
                      <label class="form-label fw-bold">Admission Preparation</label>
                      <div>
                          <a href="{{route('app.procedure.prepare', $procedureRequest->request_ref)}}" class="btn btn-primary btn-sm">
                              <i class="ti ti-bed me-1"></i> Prepare for Admission
                          </a>
                      </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Procedure Actions & Content -->
</div>
@endsection
