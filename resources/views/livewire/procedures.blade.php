<div>
    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">

        {{-- Per Page + Search --}}
        <div class="row mb-3">
            <div class="col-sm-12 col-md-6">
                <label>
                    <select wire:model="perPage" class="form-select form-select-sm">
                        <option value="7">7</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="75">75</option>
                        <option value="100">100</option>
                    </select>
                </label>
            </div>

            <div class="col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end">
                <label>
                    Search:
                    <input type="search" class="form-control form-control-sm" wire:model.debounce.300ms="search">
                </label>
            </div>
        </div>

        {{-- TABLE --}}
        <table class="table table-striped dataTable no-footer dtr-column">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th wire:click="sortByColumn('name')" class="cursor-pointer">Name</th>
                    <th>Category</th>
                    <th>Procedure Cost</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($tests as $test)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $test->name }}</td>
                        <td>{{ $test->category->name ?? '' }}</td>
                        <td>{{ number_format($test->price) }}</td>

                        <td class="text-center">

                            {{-- Actions Dropdown --}}
                            <div class="d-inline-block">
                                <a href="javascript:;" class="dropdown hide-arrow" data-bs-toggle="dropdown">
                                    <i class="text-primary ti ti-dots-vertical"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end m-0">
                                    <li>
                                        <a href="{{ route('app.procedures.edit', $test->id) }}" class="dropdown-item">
                                            Edit
                                        </a>
                                    </li>

                                    <div class="dropdown-divider"></div>

                                    <li>
                                        <a class="dropdown-item text-danger delete-record"
                                            data-value="{{ $test->id }}">
                                            Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            {{-- Hidden Delete Form --}}
                            <form id="deleteForm-{{ $test->id }}"
                                action="{{ route('app.procedures.destroy', $test->id) }}" method="POST"
                                style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No procedures found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="row mt-2">
            <div class="col-sm-12 col-md-6">
                <div>
                    Showing {{ $tests->firstItem() }} to {{ $tests->lastItem() }} of
                    {{ $tests->total() }} entries
                </div>
            </div>

            <div class="col-sm-12 col-md-6 d-flex justify-content-end">
                {{ $tests->links() }}
            </div>
        </div>

    </div>

    {{-- New Procedure Modal --}}
    @include('_partials._modals.modal-new-procedure')

    {{-- Edit Procedure Modal --}}
    @include('_partials._modals.modal-edit-procedure')

    {{-- Delete Confirmation Script --}}
    <script>
        document.querySelectorAll('.delete-record').forEach(item => {
            item.addEventListener('click', function() {
                let id = this.getAttribute('data-value');

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
                        document.getElementById('deleteForm-' + id).submit();
                    }
                });
            });
        });

        window.addEventListener('ProceduresTestEditModal', function() {
            var modal = new bootstrap.Modal(document.getElementById('edit-procedure-modal'));
            modal.show();
        });
    </script>

</div>
