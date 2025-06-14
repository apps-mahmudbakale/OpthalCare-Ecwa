<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<div class="text-center mb-4">
  <h3 class="mb-2">Bill  for Admission</h3>
</div>
<form action="{{ route('app.beds.store') }}" method="POST" class="row g-3">
  @csrf
  <div class="col-12 col-md-12">
    <label class="form-label"> Name</label>
    <input type="text" name="name" class="form-control" placeholder="Bed Name" />
  </div>
  <div class="col-12 col-md-12">
    <label class="form-label"> Ward</label>
    <select name="ward_id" id="" class="form-control">
      @foreach (\App\Models\Ward::all() as $ward)
      <option value="{{ $ward->id }}">{{ $ward->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-12 col-md-12">
    <label class="form-label"> Price</label>
    <input type="number" name="price" class="form-control" placeholder="Bed Price" />
  </div>
  <div class="col-12 text-center">
    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
            aria-label="Close">Cancel</button>
  </div>
</form>
