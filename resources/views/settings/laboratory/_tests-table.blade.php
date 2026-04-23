<div>
    <!-- Search and Filter Form -->
    <form method="GET" action="{{ route('app.settings.laboratory') }}" class="mb-3">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Per Page</label>
                <select name="test_per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="7" {{ request('test_per_page', 10) == 7 ? 'selected' : '' }}>7</option>
                    <option value="10" {{ request('test_per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('test_per_page', 10) == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('test_per_page', 10) == 50 ? 'selected' : '' }}>50</option>
                    <option value="75" {{ request('test_per_page', 10) == 75 ? 'selected' : '' }}>75</option>
                    <option value="100" {{ request('test_per_page', 10) == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Search</label>
                <input type="search" name="test_search" class="form-control form-control-sm" 
                       value="{{ request('test_search') }}" placeholder="Search by test name...">
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-search"></i> Search
                    </button>
                    <a href="{{ route('app.settings.laboratory') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fa fa-times"></i> Clear
                    </a>
                </div>
            </div>
        </div>
        <!-- Hidden fields to preserve other parameters -->
        <input type="hidden" name="test_sort_by" value="{{ request('test_sort_by', 'name') }}">
        <input type="hidden" name="test_sort_direction" value="{{ request('test_sort_direction', 'asc') }}">
        
        <!-- Preserve other sections' parameters -->
        @foreach(request()->except(['test_search', 'test_per_page', 'test_sort_by', 'test_sort_direction', 'test_page']) as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>
                        <a href="{{ route('app.settings.laboratory', array_merge(request()->all(), ['test_sort_by' => 'name', 'test_sort_direction' => request('test_sort_direction') === 'asc' ? 'desc' : 'asc'])) }}" 
                           class="text-decoration-none text-dark">
                            Name 
                            @if(request('test_sort_by', 'name') === 'name')
                                <i class="fa fa-sort-{{ request('test_sort_direction', 'asc') === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </a>
                    </th>
                    <th>Category</th>
                    <th>
                        <a href="{{ route('app.settings.laboratory', array_merge(request()->all(), ['test_sort_by' => 'price', 'test_sort_direction' => request('test_sort_direction') === 'asc' ? 'desc' : 'asc'])) }}" 
                           class="text-decoration-none text-dark">
                            Price 
                            @if(request('test_sort_by') === 'price')
                                <i class="fa fa-sort-{{ request('test_sort_direction', 'asc') === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </a>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tests as $test)
                    <tr>
                        <td>{{ ($tests->currentPage() - 1) * $tests->perPage() + $loop->iteration }}</td>
                        <td>{{ $test->name }}</td>
                        <td>{{ $test->category->name ?? '—' }}</td>
                        <td>{{ number_format($test->price, 2) }}</td>
                        <td>
                            <div class="d-inline-block">
                                <a href="javascript:;" class="dropdown hide-arrow" data-bs-toggle="dropdown">
                                    <i class="text-primary ti ti-dots-vertical"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end m-0">
                                    <li>
                                        <a data-toggle="modal"
                                           data-request-url="{{ route('app.lab-test.edit', $test->id) }}"
                                           data-target="#global-modal-lg"
                                           class="dropdown-item edit-lab-btn">Edit</a>
                                    </li>
                                    <div class="dropdown-divider"></div>
                                    <li>
                                        <a href="#" onclick="submitDeleteForm({{ $test->id }})" 
                                           class="dropdown-item text-danger">Delete</a>
                                    </li>
                                </ul>
                            </div>
                            <form id="delete-form-{{ $test->id }}" 
                                  action="{{ route('app.lab-test.destroy', $test->id) }}" 
                                  method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No lab tests found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Info and Links -->
    <div class="row mt-3">
        <div class="col-sm-12 col-md-6">
            <div class="text-muted">
                Showing {{ $tests->firstItem() ?? 0 }} to {{ $tests->lastItem() ?? 0 }} of {{ $tests->total() }} entries
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="d-flex justify-content-end">
                {{ $tests->appends(request()->except('test_page'))->links() }}
            </div>
        </div>
    </div>
</div>

@include('_partials._modals.modal-new-lab-test')
@include('_partials._modals.modal-import-lab-test')
@include('_partials._modals.global-modal')

@push('scripts')
<script>
  $(document).ready(function () {
    // Handle edit modal
    $('.edit-lab-btn').on('click', function() {
      var requestUrl = $(this).data('request-url');
      
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
    });
  });
  
  // JavaScript for delete confirmation
  function submitDeleteForm(id) {
    if (confirm('Are you sure you want to delete this Lab Test?')) {
      const form = document.getElementById('delete-form-' + id);
      if (form) {
        form.submit();
      }
    }
  }
</script>
@endpush
