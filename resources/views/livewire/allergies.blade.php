<style>
  .dropdown-item-allergy {
    display: block;
    width: 100%;
    padding: 0.5rem 1rem;
    clear: both;
    font-weight: 400;
    color: #191927;
    text-align: inherit;
    white-space: nowrap;
    background-color: transparent;
    border: 0;
    line-height: 1.375;
    width: calc(100% - 1rem);
    margin: 0.25rem 0.5rem;
    border-radius: 0.375rem;
  }
</style>
<div>
  <table class="table table-striped dataTable no-footer dtr-column">
    <thead class="thead-light">
    <tr>
      <th class="control sorting_disabled dtr-hidden">S/N</th>
      <th>Date</th>
      <th>Allergen</th>
      <th>Reaction</th>
      <th>Type</th>
      <th>Actions</th>
    </tr>
    </thead>

    <tbody>
    @forelse ($allergies as $allergy)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $allergy->created_at->diffForHumans() }}</td>
        <td>{{ $allergy->allergen }}</td>
        <td>{{ $allergy->reaction_to_allergen }}</td>
        <td>{{ $allergy->type_text }}</td>

        <td>
          <div class="d-inline-block">
            <a href="javascript:;" class="dropdown hide-arrow" data-bs-toggle="dropdown">
              <i class="text-primary ti ti-dots-vertical"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-end m-0">
              <li>
                <a href="{{ route('app.allergies.edit', $allergy->id) }}"
                   class="dropdown-item">
                  Edit
                </a>
              </li>

              <li><hr class="dropdown-divider"></li>

              <li>
                <button class="dropdown-item-allergy" id="del{{ $allergy->id }}"
                        data-value="{{ $allergy->id }}">Delete</button>

                <script>
                  document.querySelector('#del{{ $allergy->id }}').addEventListener('click', function(e) {
                    // alert(this.getAttribute('data-value'));
                    Swal.fire({
                      title: 'Are you sure?',
                      text: "You won't be able to revert this!",
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                      if (result.isConfirmed) {
                        document.getElementById('del#'+this.getAttribute('data-value')).submit();
                        // Swal.fire(
                        //     'Deleted!',
                        //     'Your file has been deleted.',
                        //     'success'
                        // )
                      }
                    })
                  })
                </script>
                <form id="del#{{ $allergy->id }}"
                      action="{{ route('app.allergies.destroy', $allergy->id) }}" method="POST"
                      style="display: inline-block;">
                  <input type="hidden" name="_method" value="DELETE">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
              </li>
            </ul>
          </div>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="6" class="text-center text-muted">No allergies found.</td>
      </tr>
    @endforelse
    </tbody>
  </table>

  {{-- Pagination if you use paginate() --}}
  <div class="mt-3">
    {{ $allergies->links() }}
  </div>
</div>
