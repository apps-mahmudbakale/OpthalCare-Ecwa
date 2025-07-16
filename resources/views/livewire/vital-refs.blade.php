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
                    <th class="sorting">Measurement</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($refs as $ref)
                    <tr class="odd">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $ref->name }}</td>
                        <td>
                            {{ $ref->measurement }}
                        </td>
                        <td>
                            <div class="d-inline-block"><a href="javascript:;" class="dropdown hide-arrow"
                                    data-bs-toggle="dropdown"><i class="text-primary ti ti-dots-vertical"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end m-0">
                                    <li><a href="#" data-request-url="{{ route('app.vitalRefs.edit', $ref->id) }}"
                                           data-toggle="modal" data-target="#global-modal" class="dropdown-item">Edit</a></li>
                                    <div class="dropdown-divider"></div>
                                    <li><a href="javascript:void(0);" class="dropdown-item-delete text-danger"
                                           onclick="submitVitalRefDeleteForm({{ $ref->id }})">Delete</a></li>
                                </ul>
                            </div>
                          <form id="delete-vital-{{ $ref->id }}"
                                action="{{ route('app.vitalRefs.destroy', $ref->id) }}"
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
                    Showing {{ $refs->firstItem() }} to {{ $refs->lastItem() }} of
                    {{ $refs->total() }} entries</div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                    {{ $refs->links() }}
                </div>
            </div>
        </div>
    </div>
  <script>
    function submitVitalRefDeleteForm(id) {
      if (confirm('Are you sure you want to delete this Vital Ref?')) {
        const form = document.getElementById('delete-vital-' + id);
        if (form) {
          form.submit();
        }
      }
    }
  </script>
</div>

