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
                                <li><a href="{{ route('app.allergies.edit', $allergy->id) }}"
                                        class="dropdown-item">Edit</a></li>
                                <div class="dropdown-divider"></div>
                              <li><button class="dropdown-item text-danger"
                                     onclick="submitAllergyDeleteForm({{ $allergy->id }})">Delete</button></li>
                            </ul>
                        </div>
                      <form id="delete-allergy-{{ $allergy->id }}"
                            action="{{ route('app.allergies.destroy', $allergy->id) }}"
                            method="POST"
                            style="display: none;>
                        @csrf
                        @method('DELETE')
                      </form>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
  <script>
    function submitAllergyDeleteForm(id) {
      if (confirm('Are you sure you want to delete this Allergy?')) {
        const form = document.getElementById('delete-allergy-' + id);
        if (form) {
          form.submit();
        }
      }
    }
  </script>

</div>
