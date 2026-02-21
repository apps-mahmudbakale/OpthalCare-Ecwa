@extends('layouts/layoutMaster')

@section('title', 'General Report')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0"><i class="ti ti-chart-bar me-2"></i>General Report</h4>
  </div>

  <div class="nav-align-top nav-tabs-shadow mb-4">
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link {{ $tab !== 'diagnoses' && $tab !== 'admissions' ? 'active' : '' }}"
           href="{{ route('app.reports.general', array_merge(request()->query(), ['tab' => 'visits'])) }}">
          <i class="ti ti-user-check me-1"></i> Visits
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ $tab === 'diagnoses' ? 'active' : '' }}"
           href="{{ route('app.reports.general', array_merge(request()->query(), ['tab' => 'diagnoses'])) }}">
          <i class="ti ti-stethoscope me-1"></i> Diagnoses
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ $tab === 'admissions' ? 'active' : '' }}"
           href="{{ route('app.reports.general', array_merge(request()->query(), ['tab' => 'admissions'])) }}">
          <i class="ti ti-bed me-1"></i> Admissions
        </a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane fade active show" role="tabpanel">
        {{-- ============================== VISITS TAB ============================== --}}
        @if($tab !== 'diagnoses' && $tab !== 'admissions')
        <div class="card-header p-0 pb-3 mb-4 border-bottom">
          <form method="GET" action="{{ route('app.reports.general') }}" class="row g-3">
            <input type="hidden" name="tab" value="visits">
            <div class="col-md-3">
              <label class="form-label">Status</label>
              <select name="cleared" class="form-select">
                <option value="">— All Status —</option>
                <option value="1" {{ request('cleared') === '1' ? 'selected' : '' }}>Cleared</option>
                <option value="0" {{ request('cleared') === '0' ? 'selected' : '' }}>Pending</option>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">From Date</label>
              <input type="date" name="from" class="form-control flatpickr" value="{{ $from }}">
            </div>
            <div class="col-md-3">
              <label class="form-label">To Date</label>
              <input type="date" name="to" class="form-control flatpickr" value="{{ $to }}">
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2">
              <button type="submit" class="btn btn-primary flex-grow-1"><i class="ti ti-filter me-1"></i>Filter</button>
              <a href="{{ route('app.reports.general', ['tab' => 'visits']) }}" class="btn btn-outline-secondary px-2"><i class="ti ti-refresh"></i></a>
            </div>
          </form>
        </div>

        <div class="table-responsive text-nowrap">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Patient</th>
                <th>HRN</th>
                <th>Check-In Date</th>
                <th>Status</th>
                <th>Clearance Code</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @forelse ($visits as $visit)
              <tr>
                <td>
                  <span class="fw-medium">
                    {{ $visit->patient && $visit->patient->user ? $visit->patient->user->firstname . ' ' . $visit->patient->user->lastname : 'N/A' }}
                  </span>
                </td>
                <td><span class="badge bg-label-info">{{ app(\App\Settings\SystemSettings::class)->number_prefix }}{{ $visit->patient->hospital_no ?? '' }}</span></td>
                <td>{{ \Carbon\Carbon::parse($visit->check_in_date)->format('d M Y') }}</td>
                <td>
                  <span class="badge bg-label-{{ $visit->cleared ? 'success' : 'warning' }}">
                    {{ $visit->cleared ? 'Cleared' : 'Pending' }}
                  </span>
                </td>
                <td><code class="text-primary fw-bold">{{ $visit->clearance_code ?? '—' }}</code></td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center py-5">
                  <div class="text-muted"><i class="ti ti-info-circle me-1"></i> No visits found for this period.</div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="d-flex align-items-center justify-content-between mt-4">
          <small class="text-muted">Showing {{ $visits->firstItem() ?? 0 }} to {{ $visits->lastItem() ?? 0 }} of {{ $visits->total() }}</small>
          {{ $visits->links('vendor.pagination.vuexy-custom') }}
        </div>
        @endif

        {{-- ============================== DIAGNOSES TAB ============================== --}}
        @if($tab === 'diagnoses')
        <div class="card-header p-0 pb-3 mb-4 border-bottom">
          <form method="GET" action="{{ route('app.reports.general') }}" class="row g-3">
            <input type="hidden" name="tab" value="diagnoses">
            <div class="col-md-3">
              <label class="form-label">Specialty</label>
              <select name="specialty" class="form-select">
                <option value="">— All Specialties —</option>
                @foreach ($specialties as $sp)
                <option value="{{ $sp }}" {{ request('specialty') === $sp ? 'selected' : '' }}>{{ $sp }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">From Date</label>
              <input type="date" name="from" class="form-control flatpickr" value="{{ $from }}">
            </div>
            <div class="col-md-3">
              <label class="form-label">To Date</label>
              <input type="date" name="to" class="form-control flatpickr" value="{{ $to }}">
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2">
              <button type="submit" class="btn btn-primary flex-grow-1"><i class="ti ti-filter me-1"></i>Filter</button>
              <a href="{{ route('app.reports.general', ['tab' => 'diagnoses']) }}" class="btn btn-outline-secondary px-2"><i class="ti ti-refresh"></i></a>
            </div>
          </form>
        </div>

        <div class="table-responsive text-nowrap">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Date</th>
                <th>Patient</th>
                <th>Specialty</th>
                <th>Recorded By</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @forelse ($diagnoses as $diag)
              <tr>
                <td>{{ $diag->created_at->format('d M Y') }}</td>
                <td>
                  <span class="fw-medium">
                    {{ $diag->patient && $diag->patient->user ? $diag->patient->user->firstname . ' ' . $diag->patient->user->lastname : 'N/A' }}
                  </span>
                </td>
                <td><span class="badge bg-label-primary">{{ $diag->specialty ?? 'General' }}</span></td>
                <td>{{ $diag->user->firstname ?? '' }} {{ $diag->user->lastname ?? 'N/A' }}</td>
                <td>
                  <span class="badge bg-label-{{ $diag->status === 'Pending' ? 'warning' : 'success' }}">
                    {{ $diag->status }}
                  </span>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center py-5">
                  <div class="text-muted"><i class="ti ti-info-circle me-1"></i> No diagnoses found for this period.</div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="d-flex align-items-center justify-content-between mt-4">
          <small class="text-muted">Showing {{ $diagnoses->firstItem() ?? 0 }} to {{ $diagnoses->lastItem() ?? 0 }} of {{ $diagnoses->total() }}</small>
          {{ $diagnoses->links('vendor.pagination.vuexy-custom') }}
        </div>
        @endif

        {{-- ============================== ADMISSIONS TAB ============================== --}}
        @if($tab === 'admissions')
        <div class="card-header p-0 pb-3 mb-4 border-bottom">
          <form method="GET" action="{{ route('app.reports.general') }}" class="row g-3">
            <input type="hidden" name="tab" value="admissions">
            <div class="col-md-2">
              <label class="form-label">Ward</label>
              <select name="ward_id" class="form-select">
                <option value="">— All Wards —</option>
                @foreach ($wards as $id => $name)
                <option value="{{ $id }}" {{ request('ward_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <label class="form-label">Status</label>
              <select name="adm_status" class="form-select">
                <option value="">— All Status —</option>
                <option value="active" {{ request('adm_status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="discharged" {{ request('adm_status') === 'discharged' ? 'selected' : '' }}>Discharged</option>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">From Date</label>
              <input type="date" name="from" class="form-control flatpickr" value="{{ $from }}">
            </div>
            <div class="col-md-3">
              <label class="form-label">To Date</label>
              <input type="date" name="to" class="form-control flatpickr" value="{{ $to }}">
            </div>
            <div class="col-md-2 d-flex align-items-end gap-2">
              <button type="submit" class="btn btn-primary flex-grow-1"><i class="ti ti-filter me-1"></i>Filter</button>
              <a href="{{ route('app.reports.general', ['tab' => 'admissions']) }}" class="btn btn-outline-secondary px-2"><i class="ti ti-refresh"></i></a>
            </div>
          </form>
        </div>

        <div class="table-responsive text-nowrap">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Patient</th>
                <th>Ward</th>
                <th>Admission Date</th>
                <th>Status</th>
                <th>Length of Stay</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @forelse ($admissions as $adm)
              @php
                $los = \Carbon\Carbon::parse($adm->created_at)->diffInDays(
                  $adm->status === 'discharged' ? $adm->updated_at : now()
                );
              @endphp
              <tr>
                <td>
                  <span class="fw-medium">
                    {{ $adm->patient && $adm->patient->user ? $adm->patient->user->firstname . ' ' . $adm->patient->user->lastname : 'N/A' }}
                  </span>
                </td>
                <td>{{ $adm->ward->name ?? 'N/A' }}</td>
                <td>{{ $adm->created_at->format('d M Y') }}</td>
                <td>
                  <span class="badge bg-label-{{ $adm->status === 'active' ? 'success' : 'secondary' }}">
                    {{ ucfirst($adm->status) }}
                  </span>
                </td>
                <td>{{ $los }} day(s)</td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center py-5">
                  <div class="text-muted"><i class="ti ti-info-circle me-1"></i> No admissions found for this period.</div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="d-flex align-items-center justify-content-between mt-4">
          <small class="text-muted">Showing {{ $admissions->firstItem() ?? 0 }} to {{ $admissions->lastItem() ?? 0 }} of {{ $admissions->total() }}</small>
          {{ $admissions->links('vendor.pagination.vuexy-custom') }}
        </div>
        @endif
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    if (typeof flatpickr !== 'undefined') {
      flatpickr('.flatpickr', {
        dateFormat: 'Y-m-d',
        allowInput: true
      });
    }
  });
</script>
@endsection
