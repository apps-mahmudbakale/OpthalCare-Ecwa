<div>

  <div class="card-header">
    <a href="{{ route('app.store-request.create') }}" id="add-payment-method"
       class="btn btn-primary mb-2 float-end">New Request</a>
    <input type="text" wire:model.debounce.500ms="search" placeholder="Search by status..." class="form-control">
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
      <tr>
        <th>Date</th>
        <th>Drugs</th>
        <th>Store</th>
        <th>Requester</th>
        <th>Status</th>
        <th></th>
      </tr>
      </thead>
      <tbody>
      @foreach ($requests as $requestRef => $group)
      <tr>
        <td class="align-middle text-nowrap">{{ $group->first()->created_at->format('d M Y h:i A') }}</td>
        <td class="align-middle">
          @foreach ($group as $request)
          <span class="badge badge-lg bg-primary mb-1">
                                    {{ $request->drug->name }}
                                </span>
          @endforeach
        </td>
        <td class="align-middle">{{ $request->user->firstname }} {{ $request->user->lastname }}</td>
        <td class="align-middle">{{ $request->store->name }}</td>
        <td class="align-middle">{{ $request->status }}</td>
        <td class="align-middle text-right">
          <div class="d-inline-block">
            <a href="javascript:;" class="dropdown hide-arrow" data-bs-toggle="dropdown">
              <i class="text-primary ti ti-dots-vertical"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end m-0">
              <li>
                <button class="dropdown-item" id="details"
                        data-request-url="{{ $request->ref ? route('app.store-request.show', $request->ref) : '#' }}"
                        data-toggle="modal" data-target="#global-modal-lg" type="button">
                  Details
                </button>
              </li>
              @if ($request->status == 'pending')
              <li>
                <button class="dropdown-item" data-toggle="modal"
                        data-request-url="{{ route('app.store-request.edit',$request->ref) }}"
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

@include('_partials._modals.global-modal2')

<script>
  $(document).ready(function () {
    $('#details').on('click', function () {
      var requestUrl = $(this).data('request-url');
      $.ajax({
        url: requestUrl,
        type: 'GET',
        success: function (response) {
          $('#global-modal2 .modal-body2').html(response);
          $('#global-modal2').modal('show');
        },
        error: function (xhr, status, error) {
          console.error(error);
        }
      });
    });
  });

</script>
