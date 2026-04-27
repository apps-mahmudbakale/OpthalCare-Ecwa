<div class="card">
    <div class="card-header border-bottom d-flex flex-column flex-md-row align-items-center justify-content-between py-3">
        <form method="GET" action="{{ route('app.lab.index') }}" class="w-100">
            <div class="row g-3">
                <div class="col-md-2">
                    <label class="form-label small mb-1">Show</label>
                    <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small mb-1">Status</label>
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Specimen Collected" {{ request('status') == 'Specimen Collected' ? 'selected' : '' }}>Specimen Collected</option>
                        <option value="Result Ready" {{ request('status') == 'Result Ready' ? 'selected' : '' }}>Result Ready</option>
                        <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small mb-1">Search</label>
                    <input type="search" name="search" class="form-control form-control-sm" 
                           value="{{ request('search') }}" placeholder="Patient name or test...">
                </div>
                <div class="col-md-3">
                    <label class="form-label small mb-1">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm flex-grow-1">
                            <i class="ti ti-search"></i> Search
                        </button>
                        <a href="{{ route('app.lab.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="ti ti-x"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- .table-responsive -->
    <div class="table-responsive">
        <!-- Bulk Actions Bar -->
        <div id="bulk-actions-bar" class="alert alert-info d-none mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="ti ti-info-circle me-2"></i>
                    <span id="selected-count">0</span> lab result(s) selected
                </div>
                <div>
                    <button type="button" class="btn btn-success btn-sm me-2" onclick="selectAllReady()">
                        <i class="ti ti-check-all me-1"></i> Select All Ready
                    </button>
                    <button type="button" class="btn btn-primary btn-sm me-2" onclick="bulkPrintResults()">
                        <i class="ti ti-printer me-1"></i> Print Selected Results
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearSelection()">
                        <i class="ti ti-x me-1"></i> Clear Selection
                    </button>
                </div>
            </div>
        </div>

        <table class="table table-hover table-striped mb-0">
            <thead class="table-light">
                <tr>
                    <th width="40">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="select-all" onchange="toggleSelectAll()">
                            <label class="form-check-label" for="select-all"></label>
                        </div>
                    </th>
                    <th>Date</th>
                    <th>Patient</th>
                    <th>Lab Test</th>
                    <th>Requester</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($labRequests as $labRequest)
                    <tr>
                        <td class="align-middle">
                            @if($labRequest->status == 'Result Ready')
                                <div class="form-check">
                                    <input class="form-check-input lab-checkbox" type="checkbox" 
                                           value="{{ $labRequest->id }}" 
                                           id="lab-{{ $labRequest->id }}"
                                           onchange="updateBulkActions()">
                                    <label class="form-check-label" for="lab-{{ $labRequest->id }}"></label>
                                </div>
                            @endif
                        </td>
                        <td class="align-middle small text-nowrap">
                            {{ \Carbon\Carbon::parse($labRequest->created_at)->format('d M Y, g:i A') }}
                        </td>
                        <td class="align-middle">
                            <a href="{{ route('app.patients.show', $labRequest->patient->id) }}" class="fw-bold" target="_blank">
                                {{ $labRequest->patient->user->firstname }} {{ $labRequest->patient->user->lastname }}
                            </a>
                            <div class="small text-muted">#{{ $labRequest->patient->hospital_no }}</div>
                        </td>
                        <td class="align-middle">
                            <span class="badge bg-label-info">{{ $labRequest->test ? $labRequest->test->name : 'Test not found' }}</span>
                        </td>
                        <td class="align-middle small">
                            {{ $labRequest->user->firstname . ' ' . $labRequest->user->lastname }}
                        </td>
                        <td class="align-middle text-nowrap">
                            @php
                                $statusClass = match($labRequest->status) {
                                    'Result Ready' => 'bg-label-success',
                                    'Specimen Collected' => 'bg-label-warning',
                                    'Pending' => 'bg-label-primary',
                                    'Cancelled' => 'bg-label-danger',
                                    default => 'bg-label-secondary'
                                };
                            @endphp
                            <span class="badge rounded-pill {{ $statusClass }} px-3">{{ $labRequest->status }}</span>
                        </td>
                        <td class="align-middle text-center">
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    @if ($labRequest->status == 'Specimen Collected')
                                        <li><button class="dropdown-item py-2" data-request-url="{{ route('app.lab.show', $labRequest->id) }}"><i class="ti ti-plus me-2"></i>Add Result</button></li>
                                    @elseif ($labRequest->status == 'Result Ready')
                                        <li><a class="dropdown-item py-2" target="_blank" href="{{ route('app.lab.print.result', $labRequest->id) }}"><i class="ti ti-printer me-2"></i>Print Result</a></li>
                                    @else
                                        <li><a href="{{ route('app.lab.specimen', $labRequest->id) }}" class="dropdown-item py-2"><i class="ti ti-flask me-2"></i>Receive Specimens</a></li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    @if($labRequest->status === 'Pending')
                                    <li>
                                        <form action="{{ route('app.lab.destroy', $labRequest->id) }}" method="POST"
                                              onsubmit="return confirm('Cancel this lab request and remove its bill?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger py-2">
                                                <i class="ti ti-trash me-2"></i>Cancel Request
                                            </button>
                                        </form>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="ti ti-info-circle ti-lg mb-2"></i>
                            <p class="mb-0">No lab requests found matching your criteria.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer border-top py-2">
        <div class="row align-items-center">
            <div class="col-sm-12 col-md-6 mb-2 mb-md-0">
                <div class="dataTables_info text-muted small" role="status" aria-live="polite">
                    Showing {{ $labRequests->firstItem() ?? 0 }} to {{ $labRequests->lastItem() ?? 0 }} of {{ $labRequests->total() }} entries
                </div>
            </div>
            <div class="col-sm-12 col-md-6 text-end">
                <div class="dataTables_paginate paging_simple_numbers">
                    {{ $labRequests->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@include('_partials._modals.global-modal')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function () {
    const modal = $('#global-modal');

    $('.new-bill-btn, .billing-show-btn').on('click', function (e) {
      e.preventDefault();
      let requestUrl = $(this).data('request-url');

      $.get(requestUrl)
        .done(response => {
          modal.find('.modal-body').html(response);
          modal.modal('show');
        })
        .fail(xhr => console.error(xhr.responseText));
    });
  });
</script>
<script>
  $(document).ready(function() {
    $('.dropdown-item').on('click', function() {
      var requestUrl = $(this).data('request-url');

      if (requestUrl) {  // Only trigger AJAX if there's a request URL
        $.ajax({
          url: requestUrl,
          type: 'GET',
          success: function(response) {
            $('#global-modal .modal-body').html(response);
            $('#global-modal').modal('show');
          },
          error: function(xhr, status, error) {
            console.error(error);
          }
        });
      }
    });
  });
</script>

<script>
// Bulk selection functionality

// Add CSS for better checkbox styling
const style = document.createElement('style');
style.textContent = `
    .lab-checkbox, #select-all {
        width: 1.25rem;
        height: 1.25rem;
        cursor: pointer;
    }
    
    .lab-checkbox:checked, #select-all:checked {
        background-color: #696cff;
        border-color: #696cff;
    }
    
    .form-check {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 1.5rem;
    }
    
    .table tbody tr:hover .lab-checkbox {
        transform: scale(1.1);
        transition: transform 0.2s ease;
    }
    
    #bulk-actions-bar {
        border-left: 4px solid #696cff;
        background: linear-gradient(135deg, #f8f9ff 0%, #e7e9ff 100%);
        border-color: #696cff;
    }
`;
document.head.appendChild(style);

function toggleSelectAll() {
    const selectAllCheckbox = document.getElementById('select-all');
    const labCheckboxes = document.querySelectorAll('.lab-checkbox');
    
    labCheckboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
    
    updateBulkActions();
}

function updateBulkActions() {
    const selectedCheckboxes = document.querySelectorAll('.lab-checkbox:checked');
    const selectAllCheckbox = document.getElementById('select-all');
    const bulkActionsBar = document.getElementById('bulk-actions-bar');
    const selectedCount = document.getElementById('selected-count');
    
    // Update selected count
    selectedCount.textContent = selectedCheckboxes.length;
    
    // Show/hide bulk actions bar
    if (selectedCheckboxes.length > 0) {
        bulkActionsBar.classList.remove('d-none');
    } else {
        bulkActionsBar.classList.add('d-none');
    }
    
    // Update select all checkbox state
    const allCheckboxes = document.querySelectorAll('.lab-checkbox');
    if (selectedCheckboxes.length === 0) {
        selectAllCheckbox.indeterminate = false;
        selectAllCheckbox.checked = false;
    } else if (selectedCheckboxes.length === allCheckboxes.length) {
        selectAllCheckbox.indeterminate = false;
        selectAllCheckbox.checked = true;
    } else {
        selectAllCheckbox.indeterminate = true;
    }
}

function clearSelection() {
    const checkboxes = document.querySelectorAll('.lab-checkbox, #select-all');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
    updateBulkActions();
}

function selectAllReady() {
    // Select all checkboxes for results that are ready (have checkboxes)
    const readyCheckboxes = document.querySelectorAll('.lab-checkbox');
    readyCheckboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
    updateBulkActions();
}

function bulkPrintResults() {
    const selectedCheckboxes = document.querySelectorAll('.lab-checkbox:checked');
    
    if (selectedCheckboxes.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'No Selection',
            text: 'Please select at least one lab result to print.',
            confirmButtonText: 'OK'
        });
        return;
    }
    
    const selectedIds = Array.from(selectedCheckboxes).map(checkbox => checkbox.value);
    
    // Show loading state
    Swal.fire({
        title: 'Preparing Print...',
        text: `Generating bulk print for ${selectedIds.length} lab result(s)`,
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Create a form to submit the selected IDs
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("app.lab.bulk-print") }}';
    form.target = '_blank'; // Open in new tab
    
    // Add CSRF token
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    
    // Add selected IDs
    selectedIds.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'lab_ids[]';
        input.value = id;
        form.appendChild(input);
    });
    
    // Submit the form
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
    
    // Close loading after a short delay
    setTimeout(() => {
        Swal.close();
        
        // Show success message
        Swal.fire({
            icon: 'success',
            title: 'Print Generated!',
            text: `Bulk print opened in new tab with ${selectedIds.length} lab result(s)`,
            timer: 3000,
            showConfirmButton: false
        });
    }, 1000);
}
</script>
