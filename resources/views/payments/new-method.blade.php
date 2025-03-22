<!-- Edit User Modal -->
        <div class="text-center mb-4">
          <h3 class="mb-2">New Payment Method</h3>
        </div>
        <form action="{{ route('app.payments.save-method') }}" method="POST" class="row g-3">
          @csrf
          <div class="col-12 col-md-12">
            <label class="form-label"> Name</label>
            <input type="text" name="name" class="form-control" placeholder="Name" />
          </div>
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                    aria-label="Close">Cancel</button>
          </div>
        </form>
