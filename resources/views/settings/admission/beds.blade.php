@extends('layouts/layoutMaster')

@section('title', 'Beds Management')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <span class="text-muted fw-light">Admission Settings /</span> Beds
        </h4>
        <div class="btn-group">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#new-bed-modal">
                <i class="ti ti-plus me-1"></i> New Bed
            </button>
            <a href="{{ route('app.bed.export') }}" class="btn btn-outline-primary">
                <i class="ti ti-download me-1"></i> Export
            </a>
            <button type="button" class="btn btn-outline-primary" id="import-beds-btn">
                <i class="ti ti-upload me-1"></i> Import
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <form method="GET" action="{{ route('app.beds.index') }}" class="row g-3">
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
                           value="{{ request('search') }}" placeholder="Search beds or wards...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="ti ti-search"></i> Search
                        </button>
                        <a href="{{ route('app.beds.index') }}" class="btn btn-outline-secondary btn-sm">
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
                        <th>Bed Name</th>
                        <th>Ward</th>
                        <th class="text-end">Price</th>
                        <th class="text-center">Available</th>
                        <th class="text-center" width="100">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($beds as $bed)
                        <tr>
                            <td>{{ ($beds->currentPage() - 1) * $beds->perPage() + $loop->iteration }}</td>
                            <td>{{ $bed->name }}</td>
                            <td>{{ $bed->ward->name ?? 'N/A' }}</td>
                            <td class="text-end">₦{{ number_format($bed->price, 2) }}</td>
                            <td class="text-center">
                                @if($bed->available)
                                    <span class="badge bg-label-success">Yes</span>
                                @else
                                    <span class="badge bg-label-danger">No</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('app.beds.edit', $bed->id) }}">
                                                <i class="ti ti-edit me-2"></i> Edit
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('app.beds.destroy', $bed->id) }}" method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this bed?')">
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
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="ti ti-info-circle ti-lg mb-2"></i>
                                <p class="mb-0">No beds found</p>
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
                        Showing {{ $beds->firstItem() ?? 0 }} to {{ $beds->lastItem() ?? 0 }} of {{ $beds->total() }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 text-end">
                    {{ $beds->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>

    @include('_partials._modals.modal-new-bed')
    @include('_partials._modals.global-modal')
@endsection

@section('page-script')
<script>
    $(document).ready(function() {
        $('#import-beds-btn').on('click', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: '{{ route('app.bed.import') }}',
                type: 'GET',
                success: function(response) {
                    $('#global-modal .modal-body').html(response);
                    $('#global-modal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('Error loading import form:', error);
                    alert('Failed to load import form. Please try again.');
                }
            });
        });
    });
</script>
@endsection
