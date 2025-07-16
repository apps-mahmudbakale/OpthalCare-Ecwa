<div>
  <style>
    .dropdown-item-delete {
      line-height: 1.375;
      width: calc(100% - 1rem);
      margin: 0.25rem 0.5rem;
      border-radius: 0.375rem;
    }
    .dropdown-item-delete {
      display: block;
      width: 100%;
      padding: var(--bs-dropdown-item-padding-y) var(--bs-dropdown-item-padding-x);
      clear: both;
      font-weight: 400;
      color: var(--bs-dropdown-link-color);
      text-align: inherit;
      white-space: nowrap;
      background-color: transparent;
      border: 0;
    }
  </style>
  <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
    <div class="row mb-3">
      <div class="col-sm-12 col-md-6">
        <div class="dataTables_length">
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
      </div>
      <div class="col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end">
        <div class="dataTables_filter">
          <label>
            Search:
            <input type="search" wire:model.debounce.300ms="search" class="form-control form-control-sm">
          </label>
        </div>
      </div>
    </div>

    <table class="table table-striped dataTable no-footer dtr-column">
      <thead>
      <tr>
        <th>S/N</th>
        <th>Name</th>
        <th class="text-end">Actions</th>
      </tr>
      </thead>
      <tbody>
      @foreach ($departments as $department)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $department->name }}</td>
        <td class="text-end">
          <div class="dropdown d-inline-block">
            <a href="javascript:;" class="dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
              <i class="text-primary ti ti-dots-vertical"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a href="javascript:void(0);"
                   class="dropdown-item"
                   data-bs-toggle="modal"
                   data-bs-target="#global-modal"
                   data-request-url="{{ route('app.departments.edit', $department->id) }}">
                  Edit
                </a>
              </li>
              <div class="dropdown-divider"></div>
              <li>
                <a href="javascript:;"
                   class="dropdown-item-delete text-danger"
                   onclick="submitDeleteForm({{ $department->id }})">
                  Delete
                </a>
              </li>
            </ul>
          </div>

          <form id="delete-dept-{{ $department->id }}"
                action="{{ route('app.departments.destroy', $department->id) }}"
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

    <div class="row align-items-center">
      <div class="col-sm-12 col-md-6">
        <div class="dataTables_info">
          Showing {{ $departments->firstItem() }} to {{ $departments->lastItem() }} of {{ $departments->total() }} entries
        </div>
      </div>
      <div class="col-sm-12 col-md-6">
        <div class="dataTables_paginate paging_simple_numbers d-flex justify-content-md-end">
          {{ $departments->links() }}
        </div>
      </div>
    </div>
  </div>

  {{-- JavaScript for delete confirmation --}}
  <script>
    function submitDeleteForm(id) {
      if (confirm('Are you sure you want to delete this department?')) {
        const form = document.getElementById('delete-dept-' + id);
        if (form) {
          form.submit();
        }
      }
    }
  </script>
</div>
