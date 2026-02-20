<div>
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center py-2">
        <h5 class="card-title mb-0">Encounter Notes</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#new-diagnosis-modal">
          New Entry
        </button>
      </div>
      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table table-hover">
            <thead>
            <tr>
              <th>Date</th>
              <th>Recorded By</th>
              <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            @forelse ($diagnoses as $diagnosis)
              <tr>
                <td>{{ $diagnosis->created_at->format('d M Y h:i A') }}</td>
                <td> {{ $diagnosis->user->firstname }} {{ $diagnosis->user->lastname }}</td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="javascript:void(0);" 
                                   data-request-url="{{route('app.diagnosis.show', $diagnosis->id)}}" 
                                   class="btn btn-sm btn-icon btn-outline-secondary" title="View">
                                    <i class="ti ti-eye ti-xs"></i>
                                </a>
                                
                                <a href="{{route('app.print.diagnosis', $diagnosis->id)}}" target="_blank" 
                                   class="btn btn-sm btn-icon btn-outline-secondary" title="Print">
                                    <i class="ti ti-printer ti-xs"></i>
                                </a>
                                
                                <a href="javascript:void(0);" 
                                   data-request-url="{{ route('app.diagnosis.edit', $diagnosis->id) }}"
                                   class="btn btn-sm btn-icon btn-outline-secondary" title="Edit">
                                    <i class="ti ti-edit ti-xs"></i>
                                </a>
                                
                                <a href="javascript:void(0);" class="btn btn-sm btn-icon btn-outline-danger delete-diagnosis"
                                   data-id="{{ $diagnosis->id }}" title="Delete">
                                    <i class="ti ti-trash ti-xs"></i>
                                </a>
                            </div>
                        </td>

              </tr>
            @empty
              <tr>
                <td colspan="3" class="text-center py-4 text-muted">No encounter notes found for this patient.</td>
              </tr>
            @endforelse
            </tbody>
          </table>
        </div>
        
        <div class="row mt-3">
          <div class="col-sm-12 col-md-12">
            {{ $diagnoses->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include('_partials._modals.modal-new-diagnosis')

<script>
  document.addEventListener('DOMContentLoaded', function () {
    $(document).on('click', '.delete-diagnosis', function () {
      var id = $(this).data('id');
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
      }).then(function (result) {
        if (result.value) {
          window.livewire.emit('deleteDiagnosisRecord', id);
        }
      });
    });

    window.livewire.on('diagnosisDeleted', function() {
      Swal.fire({
        icon: 'success',
        title: 'Deleted!',
        text: 'Diagnosis record has been deleted.',
        customClass: {
          confirmButton: 'btn btn-success'
        }
      });
    });
  });
</script>
