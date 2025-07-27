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
                    <th class="sorting">Location</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($points as $point)
                    <tr class="odd">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $point->name }}</td>
                        <td>
                            {{ $point->location }}
                        </td>
                        <td>
                            <div class="d-inline-block"><a href="javascript:;" class="dropdown hide-arrow"
                                    data-bs-toggle="dropdown"><i class="text-primary ti ti-dots-vertical"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end m-0">
                                    <li><a href="javascript:void(0);"
                                           class="dropdown-item"
                                           data-bs-toggle="modal"
                                           data-bs-target="#global-modal"
                                           data-request-url="{{ route('app.cashpoints.edit', $point->id) }}">Edit</a></li>
                                    <div class="dropdown-divider"></div>
                                    <li><a href="javascript:void(0);" class="dropdown-item-delete text-danger"
                                           onclick="submitPointDeleteForm({{ $point->id }})">Delete</a></li>
                                </ul>
                            </div>
                          <form id="delete-icd-{{ $point->id }}"
                                action="{{ route('app.cashpoints.destroy', $point->id) }}"
                                method="POST"
                                style="display: none;"
                                wire:ignore>
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
                    Showing {{ $points->firstItem() }} to {{ $points->lastItem() }} of
                    {{ $points->total() }} entries</div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                    {{ $points->links() }}
                </div>
            </div>
        </div>
    </div>
  <script>
    function submitPointDeleteForm(id) {
      if (confirm('Are you sure you want to delete this Cash Point?')) {
        const form = document.getElementById('delete-icd-' + id);
        if (form) {
          form.submit();
        }
      }
    }
  </script>
</div>
