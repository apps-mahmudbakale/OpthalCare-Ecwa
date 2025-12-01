<div>
  <div class="col-md-12">
    <div class="card card-fluid">
      <div class="card-header d-flex py-2">
        <div class="ml-auto d-flex">
          <div class="ml-2">
            <button type="button" class="btn btn-primary mb-2 float-end" data-bs-toggle="modal"
                    data-bs-target="#new-diagnosis-modal">
              New Entry
            </button>
          </div>
        </div>
      </div>
      <div class="body">
        <table class="table">
          <thead class="thead-light">
          <tr>
            <th></th>
            <th>Date</th>
            <th>Recorded By</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          @foreach ($diagnoses as $diagnosis)
            <tr>
              <td></td>
              <td>{{ $diagnosis->created_at->format('d M Y h:i A') }}</td>
              <td> {{ $diagnosis->user->firstname }} {{ $diagnosis->user->lastname }}</td>
              <td>
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                          data-bs-toggle="dropdown" data-boundary="viewport" aria-expanded="false"
                          aria-haspopup="true">
                    <i class="fa fa-ellipsis-v"></i>
                  </button>
                  <ul class="dropdown-menu" style="">
                    <li><a data-request-url="" data-toggle="modal"
                           data-target="#global-modal" class="dropdown-item"
                      >View </a></li>
                    <li><a href="" target="_blank" class="dropdown-item"
                      >Print </a></li>
                    <li><a class="dropdown-item"
                           data-request-url="{{ route('app.diagnosis.edit', $diagnosis->id) }}"
                           data-bs-toggle="modal" data-bs-target="#global-modal">Edit</a>
                    <li>
                    <li>
                      <hr class="dropdown-divider">
                    </li>
                    <l>
                      <button class="dropdown-item3 text-bg-danger" id="delete"
                              data-delete-url="{{ route('app.diagnosis.destroy', $diagnosis->id) }}">Delete
                      </button>
                    </l>
                  </ul>
                </div>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@include('_partials._modals.modal-new-diagnosis')
@include('_partials._modals.global-modal')

<script>
  $(document).ready(function() {
    $('.dropdown-item').on('click', function() {
      var requestUrl = $(this).data('request-url');
      if (requestUrl) {
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
