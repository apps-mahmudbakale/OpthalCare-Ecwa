<div wire:ignore.self class="modal fade" id="edit-plan-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2">Edit HMO Plan</h3>
        </div>
        <form wire:submit.prevent="updatePlan" class="row g-3">
          <div class="col-12 col-md-6">
            <label class="form-label">HMO Group</label>
            <select wire:model.defer="hmo_id" class="form-select">
                <option value="">Select HMO</option>
                @foreach(App\Models\HmoGroup::all() as $hmo)
                    <option value="{{ $hmo->id }}">{{ $hmo->name }}</option>
                @endforeach
            </select>
            @error('hmo_id') <span class="text-danger small">{{ $message }}</span> @enderror
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label">Plan Name</label>
            <input type="text" wire:model.defer="name" class="form-control" placeholder="Gold Plan" />
            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label">Enrollment Amount</label>
            <input type="number" wire:model.defer="enrollment_amount" class="form-control" placeholder="0.00" />
            @error('enrollment_amount') <span class="text-danger small">{{ $message }}</span> @enderror
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label">Signup Amount</label>
            <input type="number" wire:model.defer="signup_amount" class="form-control" placeholder="0.00" />
            @error('signup_amount') <span class="text-danger small">{{ $message }}</span> @enderror
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label">Max Members</label>
            <input type="number" wire:model.defer="max_no" class="form-control" placeholder="5" />
            @error('max_no') <span class="text-danger small">{{ $message }}</span> @enderror
          </div>
          <div class="col-12 col-md-6 pt-4">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" wire:model.defer="is_insurance" id="edit_is_insurance" value="1">
                <label class="form-check-label" for="edit_is_insurance">Is Insurance?</label>
            </div>
          </div>
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
