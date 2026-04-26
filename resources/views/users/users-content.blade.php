<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
    <div class="card-header flex-column flex-md-row">
        <div class="head-label text-center">
            <h5 class="card-title mb-0">Users</h5>
        </div>
        <div class="dt-action-buttons text-end pt-3 pt-md-0">
            <div class="dt-buttons btn-group flex-wrap">
                <a class="btn btn-secondary create-new btn-primary" href="{{ route('app.users.create') }}">
                    <span><i class="ti ti-plus me-sm-1"></i>
                        <span class="d-none d-sm-inline-block">Add New Record</span>
                    </span>
                </a>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="dataTables_length" id="DataTables_Table_0_length">
                <label>
                    <select name="per_page" class="form-select form-select-sm" onchange="updatePerPage(this.value)">
                        <option value="7" {{ request('per_page', 10) == 7 ? 'selected' : '' }}>7</option>
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50</option>
                        <option value="75" {{ request('per_page', 10) == 75 ? 'selected' : '' }}>75</option>
                        <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </label>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end">
            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                <label>Search:
                    <input type="search" class="form-control form-control-sm" 
                           value="{{ request('search') }}" 
                           onkeyup="searchUsers(this.value)"
                           placeholder="Search users...">
                </label>
            </div>
        </div>
    </div>
    
    <table class="datatables-basic table dataTable no-footer dtr-column" id="DataTables_Table_0"
        aria-describedby="DataTables_Table_0_info" style="width: 1135px;">
        <thead>
            <tr>
                <th class="control sorting_disabled dtr-hidden">S/N</th>
                <th class="sorting" onclick="sortBy('firstname')">
                    First Name 
                    @if(request('sort_by') == 'firstname')
                        <i class="ti ti-chevron-{{ request('sort_direction', 'asc') == 'asc' ? 'up' : 'down' }}"></i>
                    @endif
                </th>
                <th class="sorting" onclick="sortBy('lastname')">
                    Last Name
                    @if(request('sort_by') == 'lastname')
                        <i class="ti ti-chevron-{{ request('sort_direction', 'asc') == 'asc' ? 'up' : 'down' }}"></i>
                    @endif
                </th>
                <th class="sorting" onclick="sortBy('email')">
                    Email
                    @if(request('sort_by') == 'email')
                        <i class="ti ti-chevron-{{ request('sort_direction', 'asc') == 'asc' ? 'up' : 'down' }}"></i>
                    @endif
                </th>
                <th class="sorting" onclick="sortBy('phone')">
                    Phone
                    @if(request('sort_by') == 'phone')
                        <i class="ti ti-chevron-{{ request('sort_direction', 'asc') == 'asc' ? 'up' : 'down' }}"></i>
                    @endif
                </th>
                <th>Status</th>
                <th class="sorting_disabled">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr class="odd">
                    <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                    <td>{{ $user->firstname }}</td>
                    <td>{{ $user->lastname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td><span class="badge bg-label-success">{{ $user->roles->first()->name ?? 'no role' }}</span></td>
                    <td>
                        <div class="d-inline-block">
                            <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" 
                               data-bs-toggle="dropdown">
                                <i class="text-primary ti ti-dots-vertical"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end m-0">
                                <li>
                                    <a href="{{ route('app.users.edit', $user->id) }}" class="dropdown-item">Edit</a>
                                </li>
                                <div class="dropdown-divider"></div>
                                <li>
                                    <a href="javascript:void(0)" onclick="deleteUser({{ $user->id }})" 
                                       class="dropdown-item text-danger">Delete</a>
                                </li>
                            </ul>
                        </div>
                        <form id="delete-form-{{ $user->id }}" action="{{ route('app.users.destroy', $user->id) }}"
                            method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="ti ti-info-circle ti-lg mb-2"></i>
                        <p class="mb-0">No users found</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} entries
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                {{ $users->appends(request()->except('page'))->links() }}
            </div>
        </div>
    </div>
</div>

<script>
let searchTimeout;

// Add CSS for clickable headers
const style = document.createElement('style');
style.textContent = `
    .sorting {
        cursor: pointer;
        user-select: none;
    }
    .sorting:hover {
        background-color: #f8f9fa;
    }
`;
document.head.appendChild(style);

function searchUsers(query) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        const url = new URL(window.location);
        if (query.trim()) {
            url.searchParams.set('search', query);
        } else {
            url.searchParams.delete('search');
        }
        url.searchParams.delete('page'); // Reset to first page
        window.location.href = url.toString();
    }, 300);
}

function updatePerPage(perPage) {
    const url = new URL(window.location);
    url.searchParams.set('per_page', perPage);
    url.searchParams.delete('page'); // Reset to first page
    window.location.href = url.toString();
}

function sortBy(column) {
    const url = new URL(window.location);
    const currentSort = url.searchParams.get('sort_by');
    const currentDirection = url.searchParams.get('sort_direction') || 'asc';
    
    if (currentSort === column) {
        // Toggle direction
        url.searchParams.set('sort_direction', currentDirection === 'asc' ? 'desc' : 'asc');
    } else {
        // New column, default to asc
        url.searchParams.set('sort_by', column);
        url.searchParams.set('sort_direction', 'asc');
    }
    
    url.searchParams.delete('page'); // Reset to first page
    window.location.href = url.toString();
}

function deleteUser(userId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        customClass: {
            confirmButton: 'btn btn-primary me-3',
            cancelButton: 'btn btn-label-secondary'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + userId).submit();
        }
    });
}
</script>