<div>
  <div class="col-md-12">
    <div class="card card-fluid">
      <div class="card-header d-flex py-2">
        <div class="ml-auto d-flex">
          <div class="ml-2">
            <a href="{{ route('app.refraction.create', $patientId) }}"
               class="btn btn-primary link mb-2 float-end">New Entry</a>
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
          @foreach($refractions as $refraction)
            <tr>
              <td></td>
              <td>{{ $refraction->created_at->format('d M Y h:i A') }}</td>
              <td>{{ $refraction->user->firstname ." ". $refraction->user->lastname }}</td>
              <td>
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                          data-bs-toggle="dropdown" data-boundary="viewport" aria-expanded="false"
                          aria-haspopup="true">
                    <i class="fa fa-ellipsis-v"></i>
                  </button>
                  <ul class="dropdown-menu" style="">
                    <li><a data-request-url="{{route('app.refraction.show', $refraction->id)}}" data-toggle="modal"
                      data-target="#global-modal" class="dropdown-item"
                      >View </a></li>
                    <li><a href="{{route('app.refraction.print', $refraction->id)}}" target="_blank" class="dropdown-item"
                      >Print </a></li>
                    <li><a href="{{route('app.refraction.edit', $refraction->id)}}" class="dropdown-item"
                      >Edit </a></li>
                    <li>
                    <li>
                      <hr class="dropdown-divider">
                    </li>
                    <l>
                      <button class="dropdown-item3 text-bg-danger" id="delete"
                              data-delete-url="{{route('app.refraction.destroy', $refraction->id)}}">Delete
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
  @include('_partials._modals.global-modal')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    $(document).ready(function() {
      $(document).on('click', '.dropdown-item[data-request-url]', function() {
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
