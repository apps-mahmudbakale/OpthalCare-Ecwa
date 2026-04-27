@extends('layouts/layoutMaster')
@section('title', 'Billing Reports')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Reports /</span> Billing</h4>

{{-- Tabs --}}
<ul class="nav nav-tabs mb-0" role="tablist">
    <li class="nav-item">
        <a href="{{ request()->fullUrlWithQuery(['tab' => 'revenue']) }}"
           class="nav-link {{ $tab === 'revenue' ? 'active' : '' }}">
            <i class="ti ti-report-money me-1"></i> Revenue
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ request()->fullUrlWithQuery(['tab' => 'cashpoints']) }}"
           class="nav-link {{ $tab === 'cashpoints' ? 'active' : '' }}">
            <i class="ti ti-cash-banknote me-1"></i> Cashpoints
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ request()->fullUrlWithQuery(['tab' => 'endday']) }}"
           class="nav-link {{ $tab === 'endday' ? 'active' : '' }}">
            <i class="ti ti-clock me-1"></i> Cashier End of Day
        </a>
    </li>
</ul>

{{-- ── REVENUE TAB ── --}}
@if($tab === 'revenue')
<div class="card border-top-0 rounded-top-0">
    <div class="card-header border-bottom">
        <form method="GET" action="{{ route('app.reports.billing') }}" class="row g-2 align-items-end">
            <input type="hidden" name="tab" value="revenue">
            <div class="col-md-2">
                <label class="form-label small mb-1">Service</label>
                <select name="service" class="form-select form-select-sm">
                    <option value="">All</option>
                    <option value="admissions"   {{ $service === 'admissions'   ? 'selected' : '' }}>Admission</option>
                    <option value="consultations"{{ $service === 'consultations'? 'selected' : '' }}>Consultation</option>
                    <option value="laboratory"   {{ $service === 'laboratory'   ? 'selected' : '' }}>Laboratory</option>
                    <option value="procedure"    {{ $service === 'procedure'    ? 'selected' : '' }}>Procedure</option>
                    <option value="pharmacy"     {{ $service === 'pharmacy'     ? 'selected' : '' }}>Pharmacy</option>
                    <option value="radiology"    {{ $service === 'radiology'    ? 'selected' : '' }}>Radiology</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Cash Point</label>
                <select name="cashpoint" class="form-select form-select-sm">
                    <option value="">All</option>
                    @foreach($cashPoints as $cp)
                        <option value="{{ $cp->id }}" {{ $cashpoint == $cp->id ? 'selected' : '' }}>{{ strtoupper($cp->name) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Payment Method</label>
                <select name="method" class="form-select form-select-sm">
                    <option value="">All</option>
                    @foreach($paymentMethods as $pm)
                        <option value="{{ $pm->name }}" {{ $method === $pm->name ? 'selected' : '' }}>{{ $pm->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Date</label>
                <input type="date" name="date" value="{{ $date }}" class="form-control form-control-sm">
            </div>
            <div class="col-md-4 d-flex gap-2 align-items-end">
                <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                <a href="{{ route('app.reports.billing', ['tab' => 'revenue']) }}" class="btn btn-sm btn-outline-secondary">Clear</a>
                <a href="{{ route('app.reports.billing.export-revenue', request()->except('page')) }}" class="btn btn-sm btn-success ms-auto">
                    <i class="ti ti-download me-1"></i> Export
                </a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-sm table-striped align-middle mb-0" style="white-space: nowrap;">
            <thead class="table-light">
                <tr>
                    <th style="width: 80px;">Payment ID</th>
                    <th style="width: 140px;">Date</th>
                    <th style="width: 150px;">Patient</th>
                    <th style="width: 120px;">Bill Ref</th>
                    <th style="width: 110px;">Service</th>
                    <th style="width: 100px;">Cash Point</th>
                    <th style="width: 90px;">Method</th>
                    <th style="width: 100px; text-align: right;">Amount (₦)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($revenue as $item)
                <tr>
                    <td><span class="badge bg-primary">{{ $item->id }}</span></td>
                    <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                    <td>{{ $item->billing->patient->user->firstname ?? '-' }} {{ $item->billing->patient->user->lastname ?? '' }}</td>
                    <td><span class="badge bg-light text-dark">{{ $item->billing->bill_ref ?? '-' }}</span></td>
                    <td>{{ $item->billing->service ?? '-' }}</td>
                    <td>{{ $item->cashPoint->name ?? '-' }}</td>
                    <td>{{ ucfirst($item->payment_method ?? 'Cash') }}</td>
                    <td style="text-align: right;">{{ number_format($item->paying_amount, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">No records found.</td></tr>
                @endforelse
            </tbody>
            @if($revenue->count())
            <tfoot class="table-light fw-bold">
                <tr>
                    <td colspan="7" style="text-align: right;">Page Total:</td>
                    <td style="text-align: right;">₦{{ number_format($revenue->sum('paying_amount'), 2) }}</td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
        <small class="text-muted">
            Showing {{ $revenue->firstItem() ?? 0 }} to {{ $revenue->lastItem() ?? 0 }}
            of {{ $revenue->total() }} entries
        </small>
        <div>{{ $revenue->links() }}</div>
    </div>
</div>
@endif

{{-- ── CASHPOINTS TAB ── --}}
@if($tab === 'cashpoints')
<div class="card border-top-0 rounded-top-0">
    <div class="card-header border-bottom">
        <form method="GET" action="{{ route('app.reports.billing') }}" class="row g-2 align-items-end">
            <input type="hidden" name="tab" value="cashpoints">
            <div class="col-md-3">
                <label class="form-label small mb-1">Cashier</label>
                <select name="cashier" class="form-select form-select-sm">
                    <option value="">All</option>
                    @foreach($allCashiers as $u)
                        <option value="{{ $u->id }}" {{ $cashier == $u->id ? 'selected' : '' }}>{{ $u->firstname }} {{ $u->lastname }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Cash Point</label>
                <select name="cashpoint" class="form-select form-select-sm">
                    <option value="">All</option>
                    @foreach($cashPoints as $cp)
                        <option value="{{ $cp->id }}" {{ $cashpoint == $cp->id ? 'selected' : '' }}>{{ strtoupper($cp->name) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Payment Method</label>
                <select name="method" class="form-select form-select-sm">
                    <option value="">All</option>
                    @foreach($paymentMethods as $pm)
                        <option value="{{ $pm->name }}" {{ $method === $pm->name ? 'selected' : '' }}>{{ $pm->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Date</label>
                <input type="date" name="date" value="{{ $date }}" class="form-control form-control-sm">
            </div>
            <div class="col-md-3 d-flex gap-2 align-items-end">
                <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                <a href="{{ route('app.reports.billing', ['tab' => 'cashpoints']) }}" class="btn btn-sm btn-outline-secondary">Clear</a>
                <a href="{{ route('app.reports.billing.export-cashpoint', request()->except('page')) }}" class="btn btn-sm btn-success ms-auto">
                    <i class="ti ti-download me-1"></i> Export
                </a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-sm table-striped align-middle mb-0">
            <thead class="table-light">
                <tr><th>Cash Point</th><th>Total Revenue (₦)</th></tr>
            </thead>
            <tbody>
                @forelse($cashpointRevenue as $row)
                <tr>
                    <td>{{ strtoupper($row->cashPoint->name ?? 'N/A') }}</td>
                    <td class="fw-bold">{{ number_format($row->total_revenue, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="2" class="text-center text-muted py-4">No records found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- ── END OF DAY TAB ── --}}
@if($tab === 'endday')
<div class="card border-top-0 rounded-top-0">
    <div class="card-header border-bottom">
        <form method="GET" action="{{ route('app.reports.billing') }}" class="row g-2 align-items-end">
            <input type="hidden" name="tab" value="endday">
            <div class="col-md-3">
                <label class="form-label small mb-1">Cashier</label>
                <select name="cashier" class="form-select form-select-sm">
                    <option value="">All Cashiers</option>
                    @foreach($allCashiers as $u)
                        <option value="{{ $u->id }}" {{ $cashier == $u->id ? 'selected' : '' }}>{{ $u->firstname }} {{ $u->lastname }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Payment Method</label>
                <select name="method" class="form-select form-select-sm">
                    <option value="">All</option>
                    @foreach($paymentMethods as $pm)
                        <option value="{{ $pm->name }}" {{ $method === $pm->name ? 'selected' : '' }}>{{ $pm->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Date</label>
                <input type="date" name="date" value="{{ $date }}" class="form-control form-control-sm">
            </div>
            <div class="col-md-5 d-flex gap-2 align-items-end">
                <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                <a href="{{ route('app.reports.billing', ['tab' => 'endday']) }}" class="btn btn-sm btn-outline-secondary">Clear</a>
                <a href="{{ route('app.reports.billing.export-endday', request()->except('page')) }}" class="btn btn-sm btn-success ms-auto">
                    <i class="ti ti-download me-1"></i> Export
                </a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-sm table-bordered align-middle mb-0">
            <thead class="table-light">
                <tr><th>Cashier</th><th>Payment Method</th><th>Total Amount (₦)</th></tr>
            </thead>
            <tbody>
                @forelse($endDayRevenue as $userId => $methods)
                    @php $user = $cashierUsers[$userId] ?? null; @endphp
                    @if($user)
                        @foreach($methods as $m)
                        <tr>
                            <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                            <td>{{ ucfirst($m->payment_method ?? 'Cash') }}</td>
                            <td>{{ number_format($m->total, 2) }}</td>
                        </tr>
                        @endforeach
                        <tr class="table-light fw-bold">
                            <td colspan="2">Total for {{ $user->firstname }}</td>
                            <td>{{ number_format($methods->sum('total'), 2) }}</td>
                        </tr>
                    @endif
                @empty
                <tr><td colspan="3" class="text-center text-muted py-4">No records found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection
