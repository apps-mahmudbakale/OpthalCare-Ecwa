<div>
    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
        <div class="card-header flex-column flex-md-row">
            <div class="head-label text-center">
                <h5 class="card-title mb-0">Roles</h5>
            </div>
            <div class="dt-action-buttons text-end pt-3 pt-md-0">
                <div class="dt-buttons btn-group flex-wrap">
                    {{-- <div class="btn-group">
                        <button
                            class="btn btn-secondary buttons-collection dropdown-toggle btn-label-primary me-2"
                            tabindex="0" aria-controls="DataTables_Table_0" type="button" aria-haspopup="dialog"
                            aria-expanded="false"><span><i class="ti ti-file-export me-sm-1"></i> <span
                                    class="d-none d-sm-inline-block">Export</span></span><span
                                class="dt-down-arrow"></span></button></div> --}}
                    <a class="btn btn-secondary create-new btn-primary" href="{{ route('app.roles.create') }}"><span><i
                                class="ti ti-plus me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">Add New Record</span></span></a>
                </div>
            </div>
        </div>
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
        <table class="datatables-basic table dataTable no-footer dtr-column" id="DataTables_Table_0"
            aria-describedby="DataTables_Table_0_info" style="width: 1135px;">
            <thead>
                <tr>
                    <th class="control sorting_disabled dtr-hidden">S/N</th>
                    <th class="sorting">Name</th>
                    <th class="sorting_disabled">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr class="odd">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            <div class="d-inline-block"><a href="javascript:;"
                                    class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i
                                        class="text-primary ti ti-dots-vertical"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end m-0">
                                    <li><a href="{{ route('app.roles.edit', $role->id) }}"
                                            class="dropdown-item">Edit</a></li>
                                    <div class="dropdown-divider"></div>
                                    <li><a id="delete{{ $role->id }}"
                                            data-value="{{ $role->id }}"
                                            class="dropdown-item text-danger delete-record">Delete</a></li>
                                </ul>
                            </div>
                            <script>
                                document.querySelector('#delete{{ $role->id }}').addEventListener('click', function(e) {
                                    // alert(this.getAttribute('data-value'));
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
                                            document.getElementById('delete#' + this.getAttribute('data-value')).submit();
                                        }
                                    })
                                })
                            </script>
                            <form id="delete#{{ $role->id }}" action="{{ route('app.roles.destroy', $role->id) }}"
                                method="POST" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                    Showing {{ $roles->firstItem() }} to {{ $roles->lastItem() }}  of {{ $roles->total() }} entries</div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
