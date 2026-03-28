@php
use App\Models\Patient;
use App\Models\Admission;

$patientId = null;
$route = request()->route();
$isSettingsPage = false;

if ($route) {
    if ($route->parameter('patient')) {
        $param = $route->parameter('patient');
        $patientId = is_object($param) ? $param->id : $param;
    } elseif ($route->parameter('admission')) {
        $param = $route->parameter('admission');
        $admission = is_object($param) ? $param : Admission::find($param);
        $patientId = $admission?->patient_id;
    } elseif ($route->parameter('procedureRequest')) {
        $pr = $route->parameter('procedureRequest');
        $patientId = is_object($pr) ? $pr->patient_id : null;
    } else {
        // Settings page — no patient context
        $isSettingsPage = true;
    }
}

$patient = Patient::find($patientId);
$user = optional($patient)->user;

$procedures = \App\Models\Procedure::all(['id', 'name']);
$categories = \App\Models\ProcedureCategory::all(['id', 'name']);
@endphp

@if($isSettingsPage)
{{-- Settings: Add New Procedure (not a request) --}}
<div wire:ignore.self class="modal fade" id="new-procedure-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3 p-md-4">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2">Add New Procedure</h3>
        </div>
        <form action="{{ route('app.procedure.store') }}" method="POST" class="row g-3">
          @csrf
          <div class="col-12">
            <label class="form-label">Procedure Name</label>
            <input type="text" name="name" class="form-control" placeholder="e.g. Appendectomy" required>
          </div>
          <div class="col-12">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select">
              <option value="">Select Category</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-12">
            <label class="form-label">Price (₦)</label>
            <input type="number" name="price" class="form-control" placeholder="0.00" min="0" step="0.01">
          </div>
          <div class="col-12 text-center mt-2">
            <button type="submit" class="btn btn-primary me-2">Save Procedure</button>
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@else
{{-- Patient/Admission context: Procedure Request --}}
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

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const table = document.querySelector('#procedureTable tbody');
    const addRowBtn = document.getElementById('addProcedureRow');
    if (!addRowBtn) return;

    addRowBtn.addEventListener('click', function () {
      const firstRow = table.querySelector('tr');
      const clone = firstRow.cloneNode(true);
      clone.querySelectorAll('select, textarea').forEach(input => input.value = '');
      table.appendChild(clone);
      bindRemoveButtons();
    });

    function bindRemoveButtons() {
      document.querySelectorAll('#procedureTable .remove-row').forEach(btn => {
        btn.onclick = function () {
          if (document.querySelectorAll('#procedureTable tbody tr').length > 1) {
            btn.closest('tr').remove();
          }
        };
      });
    }
    bindRemoveButtons();
  });
</script>
@endif
