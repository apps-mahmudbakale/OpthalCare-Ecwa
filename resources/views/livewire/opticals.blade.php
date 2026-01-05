<div>
  <div class="card-header">
    <div class="filterForm d-flex justify-content-between">
      <div class="form-group flex-fill">
        <label for="patient_id">Filter By Patient</label>
        <select wire:model="patient_id" class="form-control">
          <option value="">- All -</option>
          @foreach($patients as $patient)
          <option value="{{ $patient->id }}">{{ $patient->user->firstname ?? 'N/A' }} {{ $patient->user->lastname ?? 'N/A' }}</option>
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
    <button class="btn btn-primary" data-toggle="modal"
       data-request-url="{{ route('app.opticals.create') }}"
       data-target="#global-modal-lg" id="new-request">New Request</button>
  </div>

  <div class="table-responsive mt-3">
    <table class="table">
      <thead>
      <tr>
        <th>Request Date</th>
        <th>Patient</th>
        <th>Status</th>
        <th></th>
      </tr>
      </thead>
      <tbody>
      @foreach ($opticals as $optical)
      <tr>
        <td>{{ $optical->created_at }}</td>
        <td>{{ $optical->patient->user->firstname ?? 'N/A' }} {{ $optical->patient->user->lastname ?? 'N/A' }}</td>
        <td>{{$optical->status}}</td>
        <td>
          <div class="d-inline-block"><a href="javascript:;" class="dropdown hide-arrow"
                                         data-bs-toggle="dropdown"><i class="text-primary ti ti-dots-vertical"></i></a>
            <ul class="dropdown-menu dropdown-menu-end m-0">
              <li><a href=""
                     class="dropdown-item">Edit</a></li>
              <div class="dropdown-divider"></div>
              <li><a id="delet{{ $optical->id }}" data-value="{{ $optical->id }}"
                     class="dropdown-item text-danger delete-record">Delete</a></li>
            </ul>
          </div>
          <script>
            document.querySelector('#delet{{ $optical->id }}').addEventListener('click', function(e) {
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
                  document.getElementById('delet#' + this.getAttribute('data-value')).submit();
                }
              })
            })
          </script>
          <form id="delet#{{ $optical->id }}"
                action="" method="POST"
                style="display: inline-block;">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
          </form>
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
    <div class="d-flex justify-content-around mt-2">

    </div>
  </div>
</div>
@include('_partials._modals.global-modal')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script>
  $(document).ready(function() {
    $('#new-request').on('click', function() {
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
