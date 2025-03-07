<div>

    <table class="table table-striped dataTable no-footer dtr-column" id="DataTables_Table_0">
        <thead class="thead-light">
            <tr>
                <th class="control sorting_disabled dtr-hidden">S/N</th>
                <th>Date</th>
                <th>Allergen</th>
                <th>Reaction</th>
                <th>type</th>
                <th>---</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($allergies as $allergy)
                <tr class="odd">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $allergy->created_at->diffForHumans() }}</td>
                    <td>{{ $allergy->allergen }}</td>
                    <td>{{ $allergy->reaction_to_allergen }}</td>
                    <td>{{ $allergy->type_text }}</td>
                    <td>
                        <div class="d-inline-block"><a href="javascript:;" class="dropdown hide-arrow"
                                data-bs-toggle="dropdown"><i class="text-primary ti ti-dots-vertical"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end m-0">
                                <li><a href="" wire:click.prevent="selectAllergy({{ $allergy->id }})"
                                        class="dropdown-item">Edit</a></li>
                                <div class="dropdown-divider"></div>
                                <li><a id="dele{{ $allergy->id }}" data-value="{{ $allergy->id }}"
                                        class="dropdown-item text-danger delete-record">Delete</a></li>
                            </ul>
                        </div>
                        <script>
                            document.querySelector('#dele{{ $allergy->id }}').addEventListener('click', function(e) {
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
                                        document.getElementById('dele#' + this.getAttribute('data-value')).submit();
                                    }
                                })
                            })
                        </script>
                        <form id="dele#{{ $allergy->id }}"
                            action="{{ route('app.allergies.destroy', ['allergy' => $allergy->id]) }}" method="POST"
                            style="display: inline-block;">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    <script>
        window.addEventListener('ShowAllergyEditModal', function() {
            $('#edit-allergy-modal').modal('show');
        });
    </script>
    @include('_partials._modals.modal-edit-allergies')

</div>
