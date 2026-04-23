<div>
    <!-- Search and Filter Form -->
    <form method="GET" action="{{ route('app.settings.laboratory') }}" class="mb-3">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Per Page</label>
                <select name="category_per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="7" {{ request('category_per_page', 10) == 7 ? 'selected' : '' }}>7</option>
                    <option value="10" {{ request('category_per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('category_per_page', 10) == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('category_per_page', 10) == 50 ? 'selected' : '' }}>50</option>
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label">Search</label>
                <input type="search" name="category_search" class="form-control form-control-sm" 
                       value="{{ request('category_search') }}" placeholder="Search categories...">
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary btn-sm w-100">
                    <i class="fa fa-search"></i> Search
                </button>
            </div>
        </div>
        
        <!-- Preserve other sections' parameters -->
        @foreach(request()->except(['category_search', 'category_per_page', 'category_sort_by', 'category_sort_direction', 'category_page']) as $key => $value)
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
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <div class="d-inline-block">
                                <a href="javascript:;" class="dropdown hide-arrow" data-bs-toggle="dropdown">
                                    <i class="text-primary ti ti-dots-vertical"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end m-0">
                                    <li>
                                        <a data-request-url="{{ route('app.lab-category.edit', $category->id) }}"
                                           class="dropdown-item edit-category-btn">Edit</a>
                                    </li>
                                    <div class="dropdown-divider"></div>
                                    <li>
                                        <a href="#" onclick="submitDeleteCategoryForm({{ $category->id }})" 
                                           class="dropdown-item text-danger">Delete</a>
                                    </li>
                                </ul>
                            </div>
                            <form id="delete-category-form-{{ $category->id }}" 
                                  action="{{ route('app.lab-category.destroy', $category->id) }}" 
                                  method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4">
                            <p class="text-muted">No categories found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="text-muted">
            Showing {{ $categories->firstItem() ?? 0 }} to {{ $categories->lastItem() ?? 0 }} of {{ $categories->total() }} entries
        </div>
        <div>
            {{ $categories->appends(request()->except('category_page'))->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
  function submitDeleteCategoryForm(id) {
    if (confirm('Are you sure you want to delete this category?')) {
      document.getElementById('delete-category-form-' + id).submit();
    }
  }
  
  $(document).ready(function() {
    $('.edit-category-btn').on('click', function() {
      var requestUrl = $(this).data('request-url');
      $.get(requestUrl).done(response => {
        $('#global-modal .modal-body').html(response);
        $('#global-modal').modal('show');
      });
    });
  });
</script>
@endpush
