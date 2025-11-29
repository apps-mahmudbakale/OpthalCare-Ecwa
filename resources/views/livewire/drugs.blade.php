<div>
    <div class="dataTables_wrapper dt-bootstrap5 no-footer">

        <!-- Per Page + Search -->
        <div class="row">
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

        <!-- Table -->
        <table class="table table-striped dataTable">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($tests as $test)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $test->name }}</td>
                        <td>{{ $test->category->name ?? '' }}</td>
                        <td>{{ $test->price }}</td>

                        <td>
                            <div class="d-inline-block">
                                <a href="javascript:;" class="dropdown hide-arrow" data-bs-toggle="dropdown">
                                    <i class="text-primary ti ti-dots-vertical"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end m-0">
                                    <li>
                                        <a href="javascript:void(0);" wire:click="selectDrugs({{ $test->id }})"
                                            class="dropdown-item">
                                            Edit
                                        </a>
                                    </li>

                                    <div class="dropdown-divider"></div>

                                    <li>
                                        <a href="javascript:;" class="dropdown-item text-danger delete-record"
                                            data-id="{{ $test->id }}">
                                            Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- Hidden delete form -->
                            <form id="delete-form-{{ $test->id }}" action="{{ route('app.settings.drugs.destroy', $test->id) }}"
                                method="POST" style="display:none;">
                                @method('DELETE')
                                @csrf
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="row">
            <div class="col-sm-12 col-md-6">
                Showing {{ $tests->firstItem() }} to {{ $tests->lastItem() }} of {{ $tests->total() }} entries
            </div>

            <div class="col-sm-12 col-md-6">
                {{ $tests->links() }}
            </div>
        </div>

    </div>

    <!-- LISTEN FOR LIVEWIRE EVENT -->
    <script>
        window.addEventListener('DrugsEditModal', function() {
            var modal = new bootstrap.Modal(document.getElementById('editDrugModal'));
            modal.show();
        });
    </script>

    <!-- GLOBAL DELETE HANDLER -->
    <script>
        document.addEventListener('click', function(e) {
            if (e.target.matches('.delete-record')) {
                let id = e.target.getAttribute('data-id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
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
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            }
        });
    </script>

    <!-- Include Edit Drug Modal -->
  @include('_partials._modals.modal-edit-drug')
  @include('_partials._modals.modal-new-add-drugs')

</div>
