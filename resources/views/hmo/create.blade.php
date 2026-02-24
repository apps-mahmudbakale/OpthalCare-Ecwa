<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<div class="text-center mb-4">
  <h3 class="mb-2">New HMO Group</h3>
</div>
<form action="{{ route('app.hmos.store') }}" method="POST" class="row g-3">
  @csrf
  <div class="col-12 col-md-12">
    <label class="form-label" for="name">Name</label>
    <input type="text" id="name" name="name" class="form-control" placeholder="AXA MANSARD" required />
  </div>
  <div class="col-12 col-md-12">
    <label class="form-label" for="email">Email</label>
    <input type="email" id="email" name="email" class="form-control" placeholder="**@**.com" required />
  </div>
  <div class="col-12 col-md-12">
    <label class="form-label" for="phone">Phone</label>
    <input type="text" id="phone" name="phone" class="form-control" placeholder="+234*****" required />
  </div>
  <div class="col-12 col-md-12">
    <label class="form-label" for="address">Address</label>
    <textarea name="address" id="address" cols="30" rows="5" class="form-control"></textarea>
  </div>
  <div class="col-12 text-center mt-4">
    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
  </div>
</form>
