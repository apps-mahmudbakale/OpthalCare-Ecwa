<!-- Edit User Modal -->
<div wire:ignore.self class="modal fade" id="new-allergies-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

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

        <div class="text-center mb-4">
          <h3 class="mb-2">New Allergies for {{ $user->firstname ?? '' }}</h3>
        </div>

        <form action="{{ route('app.allergies.store', ['patient_id' => $patientId]) }}" method="POST" class="row g-3">
          @csrf

          <div class="col-12 col-md-12">
            <label class="form-label">Type</label>
            <select name="type" id="type" class="form-control">
              <option value="1">Drug</option>
              <option value="2">Food</option>
              <option value="3">Latex</option>
              <option value="4">Environmental Irritant</option>
              <option value="5">Mold</option>
              <option value="6">Other</option>
            </select>
          </div>

          <div class="col-12 col-md-12">
            <label class="form-label">Allergen</label>
            <input type="text" name="allergen" class="form-control" placeholder="Allergen name" />
          </div>

          <div class="col-12 col-md-12">
            <label class="form-label">Reaction To Allergen</label>
            <input type="text" name="reaction_to_allergen" class="form-control" placeholder="e.g. I get dizzy" />
          </div>

          <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
            <a href="#" class="btn btn-label-secondary" target="_blank">Draw</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--/ Edit User Modal -->
