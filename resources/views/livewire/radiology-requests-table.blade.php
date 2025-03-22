<!-- .card-header -->
<div class="card-header">
  <input type="text" class="form-control" placeholder="search">
</div><!-- /.card-header -->

<!-- .table-responsive -->
<div class="table-responsive">
  <!-- .table -->
  <table class="table table-striped">
    <!-- thead -->
    <thead>
    <tr>
      <th>Date</th>
      <th>Patient</th>
      <th>Investigation</th>
      <th>Requester</th>
      <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($radiologyRequests as $radiologyRequest)
    <?php
    $serviceHandler = new App\Services\ServiceRequestHandler();
    $service = "Radiology:" . \App\Models\Radiology::where('id', $radiologyRequest->imaging_id)->first()->name;
    $isPaid = $serviceHandler->isBilled($radiologyRequest->imaging_id, $service); // Returns 1 or 0
    ?>
    <tr>
      <td class="align-middle">
        {{ $radiologyRequest->created_at->diffForHumans() }}
      </td>
      <td class="align-middle">
        <a target="_blank" href="/app/patients/{{ $radiologyRequest->patient->id }}">
          {{ $radiologyRequest->patient->user->firstname }}
          {{ $radiologyRequest->patient->user->lastname }}
          [HRN {{ $radiologyRequest->patient->hospital_no }}]
        </a>
      </td>
      <td class="align-middle">
        {{ $radiologyRequest->request_note }}
      </td>
      <td class="align-middle">
        {{ $radiologyRequest->user->firstname }} {{ $radiologyRequest->user->lastname }}
      </td>
      <td class="align-middle text-right">
        <div class="btn-group">
          <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                  data-bs-toggle="dropdown" data-boundary="viewport" aria-expanded="false"
                  aria-haspopup="true">
            <i class="fa fa-ellipsis-v"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" style="">
            @if ($radiologyRequest->status == 'Result Ready')
            <li><a class="dropdown-item" target="_blank" href="{{ route('app.radiology.print.result', $radiologyRequest->id) }}">Print</a></li>
            @else
            <li>
              <button class="dropdown-item add-notes-btn"
                      data-request-url="{{ route('app.radiology.edit', $radiologyRequest->id) }}"
                      data-paid="{{ $isPaid }}"> <!-- Set 1 or 0 directly -->
                Add Findings/Notes
              </button>
            </li>
            @endif
            <li>
              <a class="dropdown-item cancel-request text-bg-danger"
                 wire:click="cancelRequest({{ $radiologyRequest->id }})"
                 data-toggle="question"
                 data-question="Cancel Request?">
                Cancel Request
              </a>
            </li>
          </ul>
        </div>
      </td>
    </tr>
    @endforeach
    </tbody><!-- /tbody -->
  </table><!-- /.table -->
  <hr class="my-2">
  <div class="d-flex justify-content-around">
    {{ $radiologyRequests->links('shared.custom-pagination') }}
    <input type="hidden" class="sr-only filter" name="page" value="1">
  </div>
</div><!-- /.table-responsive -->

<!-- Include the global modal partial -->
@include('_partials._modals.global-modal')

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>

<script>
  $(document).ready(function() {
    const modal = $('#global-modal');

    $('.add-notes-btn').on('click', function(e) {
      e.preventDefault();
      var requestUrl = $(this).data('request-url');
      var isPaid = $(this).data('paid'); // Will be 1 or 0

      if (isPaid != 1) { // Check for 1 explicitly (not equal to 1 means unpaid)
        Swal.fire({
          icon: 'warning',
          title: 'Service Not Paid',
          text: 'This radiology service has not been paid for yet.',
          confirmButtonText: 'OK'
        });
        return;
      }

      $.ajax({
        url: requestUrl,
        type: 'GET',
        success: function(response) {
          modal.find('.modal-body').html(response);
          modal.modal('show');
        },
        error: function(xhr, status, error) {
          console.error('Error:', error);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong while loading the form.',
          });
        }
      });
    });

    // Handle other dropdown items (like Cancel) that don't need payment check
    $('.dropdown-item:not(.add-notes-btn)').on('click', function(e) {
      var requestUrl = $(this).data('request-url');
      if (requestUrl) {
        e.preventDefault();
        $.ajax({
          url: requestUrl,
          type: 'GET',
          success: function(response) {
            modal.find('.modal-body').html(response);
            modal.modal('show');
          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
          }
        });
      }
    });
  });
</script>
