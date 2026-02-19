<div class="modal fade" id="newHmoPlan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2">New HMO Plan</h3>
        </div>
        <form action="{{ route('app.hmo-plans.store')}}" method="POST" class="row g-3">
            @csrf
          <div class="col-12 col-md-6">
            <label class="form-label">HMO Group</label>
            <select name="hmo_id" class="form-select" required>
                <option value="">Select HMO</option>
                @foreach(App\Models\HmoGroup::all() as $hmo)
                    <option value="{{ $hmo->id }}">{{ $hmo->name }}</option>
                @endforeach
            </select>
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label">Plan Name</label>
            <input type="text" name="name" class="form-control" placeholder="Gold Plan" required />
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label">Enrollment Amount</label>
            <input type="number" name="enrollment_amount" class="form-control" placeholder="0.00" />
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label">Signup Amount</label>
            <input type="number" name="signup_amount" class="form-control" placeholder="0.00" />
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label">Max Members</label>
            <input type="number" name="max_no" class="form-control" placeholder="5" />
          </div>
          <div class="col-12 col-md-6 pt-4">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_insurance" id="is_insurance" value="1">
                <label class="form-check-label" for="is_insurance">Is Insurance?</label>
            </div>
          </div>
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
