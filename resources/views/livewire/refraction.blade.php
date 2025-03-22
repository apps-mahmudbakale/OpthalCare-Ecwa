<div>
  <div class="col-md-12">
    <table class="table">
      <thead class="thead-light">
      <tr>
        <th></th>
        <th>Date Recorded</th>
        <th>Actions</th>
      </tr>
      </thead>
      <tbody>
      @foreach ($refractions as $refraction)
      <tr>
        <td></td>
        <td>{{ $refraction->created_at->diffForHumans() }}</td>
        <td>
          <div class="btn-group">
            <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                    data-bs-toggle="dropdown" data-boundary="viewport" aria-expanded="false"
                    aria-haspopup="true">
              <i class="fa fa-ellipsis-v"></i>
            </button>
            <ul class="dropdown-menu" style="">
              <li>
                <a class="dropdown-item" data-request-url="{{ route('app.refraction.show', $refraction->id) }}"
                   data-toggle="modal" data-target="#global-modal">Details</a>
              </li>
              <li>
                <a class="dropdown-item" href="javascript:void(0);"
                   onclick="Livewire.emit('editRefraction', {{ $refraction->id }})">Edit</a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a class="dropdown-item text-bg-danger" href="javascript:void(0);"
                   onclick="if(confirm('Are you sure you want to delete this record?')) Livewire.emit('deleteRefraction', {{ $refraction->id }})">Delete</a>
              </li>
            </ul>
          </div>
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>

{{-- Include Global Modal --}}
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
