<div>
    <!-- Search and Filter Form -->
    <form method="GET" action="{{ route('app.settings.laboratory') }}" class="mb-3">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Per Page</label>
                <select name="parameter_per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="7" {{ request('parameter_per_page', 10) == 7 ? 'selected' : '' }}>7</option>
                    <option value="10" {{ request('parameter_per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('parameter_per_page', 10) == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('parameter_per_page', 10) == 50 ? 'selected' : '' }}>50</option>
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label">Search</label>
                <input type="search" name="parameter_search" class="form-control form-control-sm" 
                       value="{{ request('parameter_search') }}" placeholder="Search parameters...">
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary btn-sm w-100">
                    <i class="fa fa-search"></i> Search
                </button>
            </div>
        </div>
        
        <!-- Preserve other sections' parameters -->
        @foreach(request()->except(['parameter_search', 'parameter_per_page', 'parameter_sort_by', 'parameter_sort_direction', 'parameter_page']) as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Name</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($parameters as $parameter)
                    <tr>
                        <td>{{ ($parameters->currentPage() - 1) * $parameters->perPage() + $loop->iteration }}</td>
                        <td>{{ $parameter->name }}</td>
                        <td>
                            <div class="d-inline-block">
                                <a href="javascript:;" class="dropdown hide-arrow" data-bs-toggle="dropdown">
                                    <i class="text-primary ti ti-dots-vertical"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end m-0">
                                    <li>
                                        <a data-request-url="{{ route('app.lab-parameter.edit', $parameter->id) }}"
                                           class="dropdown-item edit-parameter-btn">Edit</a>
                                    </li>
                                    <div class="dropdown-divider"></div>
                                    <li>
                                        <a href="#" onclick="submitDeleteParameterForm({{ $parameter->id }})" 
                                           class="dropdown-item text-danger">Delete</a>
                                    </li>
                                </ul>
                            </div>
                            <form id="delete-parameter-form-{{ $parameter->id }}" 
                                  action="{{ route('app.lab-parameter.destroy', $parameter->id) }}" 
                                  method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4">
                            <p class="text-muted">No parameters found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="text-muted">
            Showing {{ $parameters->firstItem() ?? 0 }} to {{ $parameters->lastItem() ?? 0 }} of {{ $parameters->total() }} entries
        </div>
        <div>
            {{ $parameters->appends(request()->except('parameter_page'))->links() }}
        </div>
    </div>
</div>
