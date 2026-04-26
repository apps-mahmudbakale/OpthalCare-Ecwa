@extends('layouts/layoutMaster')

@section('title', 'Wards Management')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <span class="text-muted fw-light">Admission Settings /</span> Wards
        </h4>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#new-ward-modal">
            <i class="ti ti-plus me-1"></i> New Ward
        </button>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <form method="GET" action="{{ route('app.wards.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Per Page</label>
                    <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Search</label>
                    <input type="search" name="search" class="form-control form-control-sm" 
                           value="{{ request('search') }}" placeholder="Search wards...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="ti ti-search"></i> Search
                        </button>
                        <a href="{{ route('app.wards.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="ti ti-x"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>S/N</th>
                        <th>Name</th>
                        <th class="text-center" width="100">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($wards as $ward)
                        <tr>
                            <td>{{ ($wards->currentPage() - 1) * $wards->perPage() + $loop->iteration }}</td>
                            <td>{{ $ward->name }}</td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('app.wards.edit', $ward->id) }}">
                                                <i class="ti ti-edit me-2"></i> Edit
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('app.wards.destroy', $ward->id) }}" method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this ward?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="ti ti-trash me-2"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">
                                <i class="ti ti-info-circle ti-lg mb-2"></i>
                                <p class="mb-0">No wards found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer border-top">
            <div class="row align-items-center">
                <div class="col-sm-12 col-md-6 mb-2 mb-md-0">
                    <div class="text-muted small">
                        Showing {{ $wards->firstItem() ?? 0 }} to {{ $wards->lastItem() ?? 0 }} of {{ $wards->total() }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 text-end">
                    {{ $wards->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>

    @include('_partials._modals.modal-new-ward')
@endsection
