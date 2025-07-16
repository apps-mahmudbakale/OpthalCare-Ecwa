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
@endphp

<!-- Edit User Modal -->
<div wire:ignore.self class="modal fade" id="new-radiology-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2">New Radiology for {{ $user->firstname ?? '' }} {{ $user->lastname ?? '' }}</h3>
        </div>
        <form wire:submit.prevent="updateAntenatal" class="row g-3">
          <!-- Add other form fields here as needed -->

          <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
            <a href="{{ route('app.patient.draw', $patientId) }}" class="btn btn-label-secondary" target="_blank">Draw</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--/ Edit User Modal -->
