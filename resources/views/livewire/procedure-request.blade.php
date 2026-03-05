<div>
  <div class="card-header">
    <div class="filterForm d-flex justify-content-between">
      <div class="form-group flex-fill">
        <label for="patient_id">Filter By Patient</label>
        <select wire:model="patient_id" class="form-control">
          <option value="">- All -</option>
          @foreach($patients as $patient)
          <option value="{{ $patient->id }}">{{ $patient->user->firstname }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group flex-fill ml-2">
        <label for="category">Filter By Category</label>
        <select wire:model="category_id" class="form-control">
          <option value="">- All -</option>
            @foreach(\App\Models\ProcedureCategory::all() as $category)
            <option value="$category->id">{{$category->name}}</option>
            @endforeach
        </select>
      </div>

      <div class="form-group flex-fill ml-2">
        <label>Filter By Request Date</label>
        <div class="d-flex">
          <input type="date" wire:model="start" class="form-control mr-2">
          <input type="date" wire:model="stop" class="form-control">
        </div>
      </div>
    </div>
  </div>

  <div class="table-responsive mt-3">
    <table class="table">
      <thead>
      <tr>
        <th>Request Date</th>
        <th>Patient</th>
        <th>Procedure</th>
        <th>Category</th>
        <th>Status</th>
        <th></th>
      </tr>
      </thead>
      <tbody>
      @forelse($requests as $request)
      <tr>
        <td class="align-middle">
            {{ $request->created_at->format('M. d, Y, h:i A') }}
        </td>
        <td class="align-middle">{{ $request->patient->user->firstname ?? 'N/A' }}</td>
        <td class="align-middle">{{ $request->procedure->name }}</td>
        <td class="align-middle">{{ $request->procedure->category->name ?? 'N/A' }}</td>
        <td class="align-middle">{{ $request->status }}</td>
        <td class="align-middle text-right">
          <div class="btn-group">
            <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                    data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-ellipsis-v"></i>
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{ route('app.procedure-requests.show', $request->id) }}">Open Profile </a></li>
              <li><a class="dropdown-item" href="javascript:void(0);">Edit </a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item text-bg-danger" href="javascript:void(0);">Delete</a></li>
            </ul>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="text-center">No requests found.</td></tr>
      @endforelse
      </tbody>
    </table>
    <div class="d-flex justify-content-around mt-2">
      {{ $requests->links() }}
    </div>
  </div>
</div>
@include('_partials._modals.global-modal')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script>
  $(document).ready(function() {
    $('#prepare').on('click', function() {
      var requestUrl = $(this).data('request-url');

      $.ajax({
        url: requestUrl,
        type: 'GET',
        success: function(response) {
          $('#global-modal .modal-body').html(response);
          $('#global-modal').modal('show');
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    });
  });
</script>
