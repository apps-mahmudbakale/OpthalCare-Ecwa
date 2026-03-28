@php
use App\Models\Patient;
use App\Models\Admission;

$patientId = null;
$route = request()->route();

if ($route) {
    if ($route->parameter('patient')) {
        $param = $route->parameter('patient');
        $patientId = is_object($param) ? $param->id : $param;
    } elseif ($route->parameter('admission')) {
        $param = $route->parameter('admission');
        $admission = is_object($param) ? $param : Admission::find($param);
        $patientId = $admission?->patient_id;
    }
}

$patient = Patient::find($patientId);
$user = optional($patient)->user;

$radiologies = \App\Models\Radiology::all(['id', 'name']);
$priorities = ['Low', 'Medium', 'High', 'Urgent'];
@endphp

<!-- New Imaging Modal -->
<div wire:ignore.self class="modal fade" id="new-imaging-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2">
            New Imaging for {{ $user->firstname ?? '' }} {{ $user->lastname ?? '' }}
          </h3>
        </div>

        <form action="{{ route('app.radiology.store') }}" method="POST" id="imagingForm">
          @csrf
          <input type="hidden" name="patient_id" value="{{ $patientId }}">
          <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

          <table class="table table-bordered" id="imagingTable">
            <thead>
            <tr>
              <th>Imaging Service</th>
              <th>Priority</th>
              <th>Request Note</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>
                <select name="imaging_id[]" class="form-control" required>
                  <option value="">Select Imaging...</option>
                  @foreach ($radiologies as $item)
                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                  @endforeach
                </select>
              </td>
              <td>
                <select name="priority[]" class="form-control" required>
                  <option value="">---</option>
                  @foreach ($priorities as $p)
                  <option value="{{ $p }}">{{ $p }}</option>
                  @endforeach
                </select>
              </td>
              <td>
                <textarea name="request_note[]" class="form-control" rows="2" required></textarea>
              </td>
              <td>
                <button type="button" class="btn btn-danger btn-sm remove-row">×</button>
              </td>
            </tr>
            </tbody>
          </table>

          <div class="mb-3">
            <button type="button" class="btn btn-outline-primary" id="addImagingRow">Add Imaging</button>
          </div>

          <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Imaging Modal Script -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const table = document.querySelector('#imagingTable tbody');
    const addRowBtn = document.getElementById('addImagingRow');

    addRowBtn.addEventListener('click', function () {
      const firstRow = table.querySelector('tr');
      const clone = firstRow.cloneNode(true);

      // Reset fields in the cloned row
      clone.querySelectorAll('select, textarea').forEach(input => input.value = '');
      table.appendChild(clone);
      bindRemoveButtons();
    });

    function bindRemoveButtons() {
      document.querySelectorAll('.remove-row').forEach(btn => {
        btn.onclick = function () {
          const row = btn.closest('tr');
          if (document.querySelectorAll('#imagingTable tbody tr').length > 1) {
            row.remove();
          }
        };
      });
    }

    bindRemoveButtons(); // Initial bind
  });
</script>
