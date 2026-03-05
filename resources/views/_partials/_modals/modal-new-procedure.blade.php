@php
use App\Models\Patient;
use App\Models\Admission;

$patientId = optional(request()->route('patient'))->id;

if (!$patientId && request()->route('admission')) {
$admission = Admission::find(request()->route('admission')->id);
$patientId = optional($admission)->patient_id;
}

$patient = Patient::find($patientId);
$user = optional($patient)->user;

$procedures = \App\Models\Procedure::all(['id', 'name']);
$priorities = ['Low', 'Medium', 'High', 'Urgent'];
@endphp

<!-- New Procedure Modal -->
<div wire:ignore.self class="modal fade" id="new-procedure-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2">
            New Procedure Request for {{ $user->firstname ?? '' }} {{ $user->lastname ?? '' }}
          </h3>
        </div>

        <form action="{{ route('app.procedure-requests.store') }}" method="POST" id="procedureForm">
          @csrf
          <input type="hidden" name="patient_id" value="{{ $patientId }}">
          <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

          <table class="table table-bordered" id="procedureTable">
            <thead>
            <tr>
              <th>Procedure Service</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>
                <select name="procedure_id[]" class="form-control" required>
                  <option value="">Select Procedure...</option>
                  @foreach ($procedures as $item)
                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                  @endforeach
                </select>
              </td>
              <td>
                <button type="button" class="btn btn-danger btn-sm remove-row">×</button>
              </td>
            </tr>
            </tbody>
          </table>

          <div class="mb-3">
            <button type="button" class="btn btn-outline-primary" id="addProcedureRow">Add Procedure</button>
          </div>

          <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit Request</button>
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Procedure Modal Script -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const table = document.querySelector('#procedureTable tbody');
    const addRowBtn = document.getElementById('addProcedureRow');

    addRowBtn.addEventListener('click', function () {
      const firstRow = table.querySelector('tr');
      const clone = firstRow.cloneNode(true);

      // Reset fields in the cloned row
      clone.querySelectorAll('select, textarea').forEach(input => input.value = '');
      table.appendChild(clone);
      bindRemoveButtons();
    });

    function bindRemoveButtons() {
      document.querySelectorAll('#procedureTable .remove-row').forEach(btn => {
        btn.onclick = function () {
          const row = btn.closest('tr');
          if (document.querySelectorAll('#procedureTable tbody tr').length > 1) {
            row.remove();
          }
        };
      });
    }

    bindRemoveButtons(); // Initial bind
  });
</script>
