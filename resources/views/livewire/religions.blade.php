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
                @foreach ($religions as $religion)
                    <tr class="odd">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $religion->name }}</td>
                        <td>
                            <div class="d-inline-block"><a href="javascript:;" class="dropdown hide-arrow"
                                    data-bs-toggle="dropdown"><i class="text-primary ti ti-dots-vertical"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end m-0">
                                    <li><a href="" wire:click.prevent="selectReligion({{ $religion->id }})"
                                            class="dropdown-item">Edit</a></li>
                                    <div class="dropdown-divider"></div>
                                    <li><a id="delete{{ $religion->id }}" data-value="{{ $religion->id }}"
                                            class="dropdown-item text-danger delete-record">Delete</a></li>
                                </ul>
                            </div>
                            <script>
                                document.querySelector('#delete{{ $religion->id }}').addEventListener('click', function(e) {
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
                            <form id="delete#{{ $religion->id }}"
                                action="{{ route('app.religions.destroy', $religion->id) }}" method="POST"
                                style="display: inline-block;">
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
                    Showing {{ $religions->firstItem() }} to {{ $religions->lastItem() }} of
                    {{ $religions->total() }} entries</div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                    {{ $religions->links() }}
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('ReligionEditModal', function() {
            $('#edit-religion-modal').modal('show');
        });
    </script>
    @include('_partials._modals.modal-new-religion')
    @include('_partials._modals.modal-edit-religion')
</div>
