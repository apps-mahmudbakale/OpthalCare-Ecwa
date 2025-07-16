<!-- Edit User Modal -->
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

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div wire:ignore.self class="modal fade" id="new-diagnosis-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        <div class="text-center mb-4">
          <h3 class="mb-2">New Diagnosis for {{ $user->firstname ?? '' }} {{ $user->lastname ?? '' }}</h3>
        </div>

        <!-- Tabs -->
        <!-- ... keep tab structure as-is ... -->

        <!-- Form Start -->
        <form id="diagnosis-form" action="{{ route('app.diagnosis.store') }}" method="POST">
          @csrf

          <!-- Step 1 to 5 as-is -->

          <!-- Step 3 (update patient display and hidden field) -->
          <div class="tab-pane fade" id="step3">
            <div class="col-12 col-md-12">
              <label class="form-label">Patient</label>
              <input type="text" class="form-control"
                     value="{{ $user->firstname ?? '' }} {{ $patient->middlename ?? '' }} {{ $user->lastname ?? '' }}"
                     readonly disabled>
              <input type="hidden" name="patient_id" value="{{ $patientId }}">
            </div>

            <div class="col-12">
              <label class="form-label">Type of Disability</label>
              <select name="disability" class="form-control">
                <option>Visual</option>
                <option>Hearing</option>
                <option>Physical</option>
                <option>Intellectual</option>
                <option>Mental</option>
                <option>Multiple</option>
                <option>None</option>
              </select>
            </div>
          </div>

          <!-- Step 6 Sketch/Upload -->
          <div class="tab-pane fade" id="step6">
            <input type="hidden" id="sketch" name="sketch">
            <div class="col-12 col-md-12">
              <h4>Sketch or Upload</h4>
              <div class="mb-3">
                <label class="form-label">Draw a sketch:</label>
                <iframe id="drawing" class="col-md-12" style="height: 500px;"
                        src="{{ route('app.patient.draw', $patientId) }}">Your browser isn't compatible</iframe>
              </div>
              <div class="mb-3">
                <label class="form-label">Or upload an image:</label>
                <input type="file" id="sketch-upload" class="form-control" accept="image/*">
                <small class="text-muted">Accepted formats: PNG, JPG, JPEG (Max 5MB)</small>
              </div>
              <div id="sketch-preview" class="mt-2" style="display: none;">
                <img id="preview-img" src="" alt="Uploaded sketch"
                     style="max-width: 100%; max-height: 300px;">
              </div>
            </div>
          </div>

          <!-- Submit -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
        <!-- End Form -->
      </div>
    </div>
  </div>
</div>

<!-- JS for select2, drawing, sketch upload, etc. remains unchanged -->
