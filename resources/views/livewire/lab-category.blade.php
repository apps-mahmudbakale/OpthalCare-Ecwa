<div>
    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_length" id="DataTables_Table_0_length"><label> <select wire:model="perPage"
                            class="form-select form-select-sm">
                            <option value="7">7</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="75">75</option>
                            <option value="100">100</option>
                        </select> </label></div>
            </div>
            <div class="col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end">
                <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:<input type="search"
                            class="form-control form-control-sm" wire:model.debounce.300ms='search'></label></div>
            </div>
        </div>
        <table class="table table-striped dataTable no-footer dtr-column" id="DataTables_Table_0">
            <thead>
                <tr>
                    <th class="control sorting_disabled dtr-hidden">S/N</th>
                    <th class="sorting">Name</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr class="odd">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <div class="d-inline-block"><a href="javascript:;" class="dropdown hide-arrow"
                                    data-bs-toggle="dropdown"><i class="text-primary ti ti-dots-vertical"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end m-0">
                                    <li><a href="" data-toggle="modal"
                                           data-request-url="{{ route('app.lab-category.edit',$category->id) }}"
                                           data-target="#global-modal-lg"
                                            class="dropdown-item">Edit</a></li>
                                    <div class="dropdown-divider"></div>
                                    <li><a href="#" onclick="return submitDeleteForm({{ $category->id }});"
                                            class="dropdown-item text-danger">Delete</a></li>
                                </ul>
                            </div>
                          <form id="delete-form-{{ $category->id }}" action="{{ route('app.lab-category.destroy', $category->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                          </form>
                        </td>
                    </tr>
                @endforeach
                
                @push('scripts')
                <script>
                    function submitDeleteForm(id) {
                        if (confirm('Are you sure you want to delete this item?')) {
                            document.getElementById('delete-form-' + id).submit();
                        }
                        return false;
                    }
                </script>
                @endpush
            </tbody>
        </table>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                    Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of
                    {{ $categories->total() }} entries</div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>

</div>

<script>
  $(document).ready(function () {
    // Handle edit modal
    $('.dropdown-item[data-request-url]').on('click', function() {
      var requestUrl = $(this).data('request-url');
      if (!requestUrl) return true; // Skip if no request-url data attribute

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
      return false;
    });

  });
</script>
{{-- JavaScript for delete confirmation --}}
<script>
  function submitDeleteFormz(id) {
    if (confirm('Are you sure you want to delete this Category?')) {
      const form = document.getElementById('delete-formz-' + id);
      if (form) {
        form.submit();
      }
    }
  }
</script>
