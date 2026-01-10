<div>
  <style>
    .optical-table .badge {
      font-size: 0.75rem;
      font-weight: 500;
      letter-spacing: 0.3px;
    }
    .optical-table tr {
      transition: all 0.2s ease;
    }
    .optical-table tr:hover {
      background-color: rgba(0, 0, 0, 0.02) !important;
    }
    .btn-label-secondary:hover {
        background-color: rgba(168, 170, 174, 0.16) !important;
    }
    .gap-2 { gap: 0.5rem !important; }
    .gap-1 { gap: 0.25rem !important; }
  </style>
  @if (session()->has('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if (session()->has('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif
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

  <div class="table-responsive mt-4 overflow-visible">
    <table class="table table-hover align-middle optical-table">
      <thead class="bg-light">
      <tr>
        <th class="text-muted fw-light">Request Date</th>
        <th class="text-muted fw-light">Patient</th>
        <th class="text-muted fw-light">Item</th>
        <th class="text-muted fw-light text-center">Status</th>
        <th class="text-muted fw-light text-end">Actions</th>
      </tr>
      </thead>
      <tbody>
      @foreach ($opticals as $optical)
      <tr>
        <td>{{ $optical->created_at->format('Y-m-d H:i') }}</td>
        <td>{{ $optical->patient->user->firstname ?? 'N/A' }} {{ $optical->patient->user->lastname ?? 'N/A' }}</td>
        <td>{{ $optical->service->name ?? 'N/A' }}</td>
        <td class="text-center">
            @if($optical->status == 'pending')
                <span class="badge rounded-pill bg-label-warning px-3 py-1 text-uppercase">{{ $optical->status }}</span>
            @else
                <span class="badge rounded-pill bg-label-success px-3 py-1 text-uppercase">{{ $optical->status }}</span>
            @endif
        </td>
        <td class="text-end">
          <div class="d-flex align-items-center justify-content-end gap-2">
            @if($optical->status == 'pending')
              <button wire:click.prevent="dispense({{ $optical->id }})" 
                      class="btn btn-sm btn-primary d-flex align-items-center gap-1 shadow-sm px-3">
                <i class="ti ti-check fs-5"></i>
                <span>Dispense</span>
              </button>
            @endif

            <div class="dropdown">
              <button class="btn btn-sm btn-icon btn-label-secondary dropdown-toggle hide-arrow shadow-none border-0"
                      data-bs-toggle="dropdown"
                      data-bs-boundary="viewport">
                <i class="ti ti-dots-vertical"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end m-0">
                <li>
                  <a href="javascript:;" class="dropdown-item d-flex align-items-center gap-2">
                    <i class="ti ti-edit fs-5"></i> <span>Edit</span>
                  </a>
                </li>
                <li>
                  <a href="javascript:;" 
                     id="delet{{ $optical->id }}" data-value="{{ $optical->id }}"
                     class="dropdown-item d-flex align-items-center gap-2 text-danger delete-record">
                    <i class="ti ti-trash fs-5"></i> <span>Delete</span>
                  </a>
                </li>
              </ul>
            </div>
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
