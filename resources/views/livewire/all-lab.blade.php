<!-- .card-header -->
<div class="card-header">
  <input type="text" placeholder="search" class="form-control">
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
      <th>Lab Test</th>
      <th>Requester</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <!-- tr -->
    @foreach ($labRequests as $labRequest)
    <tr>
      <td class="align-middle">{{ $labRequest->test->created_at->diffForHumans() }}</td>
      <td class="align-middle">
        <a href="patients/{{ $labRequest->patient->id }}" target="_blank">
          {{ $labRequest->patient->user->firstname }} {{ $labRequest->patient->user->lastname }}
        </a>
      </td>
      <td class="align-middle">{{ $labRequest->test->name }}</td>
      <td class="align-middle">{{ $labRequest->user->firstname . ' ' . $labRequest->user->lastname }}</td>
      <td class="align-middle">{{ $labRequest->status }}</td>
      <td class="align-middle text-right">
        <div class="btn-group">
          <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                  data-bs-toggle="dropdown" data-boundary="viewport" aria-expanded="false"
                  aria-haspopup="true">
            <i class="fa fa-ellipsis-v"></i>
          </button>
          <ul class="dropdown-menu" style="">
            @if ($labRequest->status == 'Specimen Collected')
            <li><button class="dropdown-item" data-request-url="{{ route('app.lab.show', $labRequest->id) }}">Add Result</button></li>
            @elseif ($labRequest->status == 'Result Ready')
            <li><a class="dropdown-item" href="{{ route('app.lab.specimen', $labRequest->id) }}">Print</a></li>
            <li><a class="dropdown-item" href="{{ route('app.lab.specimen', $labRequest->id) }}">Details</a></li>
            @else
            <li><a href="{{ route('app.lab.specimen', $labRequest->id) }}"
                   class="dropdown-item" href="javascript:void(0);">Receive Specimens</a></li>
            @endif
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-bg-danger" href="javascript:void(0);">Cancel</a></li>
          </ul>
        </div>
      </td>
    </tr>
    @endforeach
    </tbody><!-- /tbody -->
  </table><!-- /.table -->
  <hr class="my-2">
  <div class="d-flex justify-content-around">
    {{ $labRequests->links() }}
  </div>
</div><!-- /.table-responsive -->

@include('_partials._modals.global-modal')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function () {
    const modal = $('#global-modal');

    $('.new-bill-btn, .billing-show-btn').on('click', function (e) {
      e.preventDefault();
      let requestUrl = $(this).data('request-url');

      $.get(requestUrl)
        .done(response => {
          modal.find('.modal-body').html(response);
          modal.modal('show');
        })
        .fail(xhr => console.error(xhr.responseText));
    });
  });
</script>
<script>
  $(document).ready(function() {
    $('.dropdown-item').on('click', function() {
      var requestUrl = $(this).data('request-url');

      if (requestUrl) {  // Only trigger AJAX if there's a request URL
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
      }
    });
  });
</script>
