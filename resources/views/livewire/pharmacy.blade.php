<div>
  <div class="card-header">
    <input type="text" wire:model.debounce.500ms="search" placeholder="Search by status..." class="form-control">
  </div>

  <div class="table-responsive">
    <table class="table">
      <thead>
      <tr>
        <th>Date</th>
        <th>Patient</th>
        <th>Drug/Generic</th>
        <th>Requester</th>
        <th></th>
      </tr>
      </thead>
      <tbody>
      @foreach ($requests as $requestRef => $group)
      <tr>
        <td class="align-middle text-nowrap">{{ $group->first()->created_at->format('d M Y h:i A') }}</td>
        <td class="align-middle">{{ $group->first()->patient->user->firstname }}</td>
        <td class="align-middle">
          @foreach ($group as $request)
                                <span class="badge badge-lg bg-primary mb-1">
                                    {{ $request->drug->name }}
                                </span>
          @endforeach
        </td>
        <td class="align-middle">{{ $request->user->firstname }}</td>
        <td class="align-middle text-right">
          <div class="d-inline-block">
            <a href="javascript:;" class="dropdown hide-arrow" data-bs-toggle="dropdown">
              <i class="text-primary ti ti-dots-vertical"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end m-0">
              <li>
                <button class="dropdown-item"
                        data-request-url="{{ route('app.pharmacy.show', $request->request_ref) }}"
                        data-toggle="modal" data-target="#global-modal" type="button">
                  Details
                </button>
              </li>

              @php
              $serviceHandler = new \App\Services\ServiceRequestHandler();
              $service = "Pharmacy:" . $request->drug->name;
              $isPaid = $serviceHandler->isBilled($request->drug->id, $service, $request->request_ref);
              @endphp

              @if ($isPaid && $request->status != 'Filled')
              <li>
                <button class="dropdown-item" data-toggle="modal"
                        data-request-url="{{ route('app.pharmacy.edit',$request->request_ref) }}"
                        data-target="#global-modal-lg" type="button">
                  Fill
                </button>
              </li>
              @endif

              <div class="dropdown-divider"></div>
              <li>
                <button class="dropdown-item" data-toggle="question"
                        data-question="Cancel All Prescription Lines in this Request?"
                        data-remote="/pharmacy/request/{{ $request->id }}/cancel"
                        type="button">
                  Cancel
                </button>
              </li>
            </ul>
          </div>

          <form id="dele#{{ $request->id }}" action="" method="POST" style="display: inline-block;">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
          </form>
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>

    <div class="mt-3">
      {{ $requests->links() }}
    </div>
  </div>
</div>

@include('_partials._modals.global-modal')

<script>
  $(document).ready(function () {
    $('.dropdown-item').on('click', function () {
      var requestUrl = $(this).data('request-url');
      $.ajax({
        url: requestUrl,
        type: 'GET',
        success: function (response) {
          $('#global-modal .modal-body').html(response);
          $('#global-modal').modal('show');
        },
        error: function (xhr, status, error) {
          console.error(error);
        }
      });
    });
  });
</script>
