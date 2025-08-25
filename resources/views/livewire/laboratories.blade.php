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
                    <th class="sorting">Category</th>
                    <th class="sorting">Price</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tests as $test)
                    <tr class="odd">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $test->name }}</td>
                        <td>{{ $test->category->name }}</td>
                        <td>{{ $test->price }}</td>
                        <td>
                            <div class="d-inline-block"><a href="javascript:;" class="dropdown hide-arrow"
                                    data-bs-toggle="dropdown"><i class="text-primary ti ti-dots-vertical"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end m-0">
                                    <li><a  data-toggle="modal"
                                           data-request-url="{{ route('app.lab-test.edit',$test->id) }}"
                                           data-target="#global-modal-lg"
                                            class="dropdown-item">Edit</a></li>
                                    <div class="dropdown-divider"></div>
                                    <li><a href="#" wire:click.prevent="confirmDelete({{ $test->id }})" class="dropdown-item text-danger">Delete</a></li>
                                </ul>
                            </div>
                            <form id="delete-form-{{ $test->id }}" action="{{ route('app.lab-test.destroy', $test->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                    Showing {{ $tests->firstItem() }} to {{ $tests->lastItem() }} of
                    {{ $tests->total() }} entries</div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                    {{ $tests->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@include('_partials._modals.modal-new-lab-test')
@include('_partials._modals.modal-import-lab-test')
@include('_partials._modals.global-modal')

<script>
  $(document).ready(function () {
    // Handle edit modal
    $('.dropdown-item[data-request-url]').on('click', function () {
      var requestUrl = $(this).data('request-url');
      if (!requestUrl) return true; // Skip if no request-url data attribute
      
      $.ajax({
        url: requestUrl,
        type: 'GET',
        success: function (response) {
          $('#global-modal .modal-body').html(response);
          $('#global-modal').modal('show');
        },
        error: function (xhr, status, error) {
          console.error(error);
        }
      });
      return false;
    });

    // Handle delete confirmation
    window.addEventListener('confirm-delete', event => {
      Swal.fire({
        title: event.detail.title,
        text: event.detail.text,
        icon: event.detail.type,
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          @this.deleteLab(event.detail.id);
        }
      });
    });

    // Handle success/error messages
    window.addEventListener('alert', event => {
      Swal.fire({
        title: event.detail.type === 'success' ? 'Success!' : 'Error!',
        text: event.detail.message,
        icon: event.detail.type,
        confirmButtonText: 'OK'
      }).then(() => {
        if (event.detail.type === 'success') {
          // Reload the page after successful deletion
          window.location.reload();
        }
      });
    });
  });
</script>
