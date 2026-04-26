@extends('layouts/layoutMaster')

@section('title', 'Specialities Management')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <span class="text-muted fw-light">Consultation Settings /</span> Specialities
        </h4>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#new-speciality-modal">
            <i class="ti ti-plus me-1"></i> New Speciality
        </button>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <form method="GET" action="{{ route('app.specialities.index') }}" class="row g-3">
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
                           value="{{ request('search') }}" placeholder="Search specialities...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="ti ti-search"></i> Search
                        </button>
                        <a href="{{ route('app.specialities.index') }}" class="btn btn-outline-secondary btn-sm">
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
                    @forelse ($specialities as $speciality)
                        <tr>
                            <td>{{ ($specialities->currentPage() - 1) * $specialities->perPage() + $loop->iteration }}</td>
                            <td>{{ $speciality->name }}</td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('app.specialities.edit', $speciality->id) }}">
                                                <i class="ti ti-edit me-2"></i> Edit
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('app.specialities.destroy', $speciality->id) }}" method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this speciality?')">
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
                                <p class="mb-0">No specialities found</p>
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
                        Showing {{ $specialities->firstItem() ?? 0 }} to {{ $specialities->lastItem() ?? 0 }} of {{ $specialities->total() }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 text-end">
                    {{ $specialities->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>

    @include('_partials._modals.modal-new-speciality')
@endsection