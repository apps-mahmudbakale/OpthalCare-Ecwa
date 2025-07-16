<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<div class="text-center mb-4">
  <h3 class="mb-2">Update ICD10</h3>
</div>
<form action="{{ route('app.icd.update', $iCD10->id) }}" method="POST" class="row g-3">
  @csrf
  @method('PUT')

  <div class="col-12 col-md-12">
    <label class="form-label"> Name</label>
    <input
      type="text"
      name="name"
      class="form-control"
      placeholder="ICD Name"
      value="{{ old('name', $iCD10->name ??  '')}}"
    />
  </div>

  <div class="col-12 col-md-12">
    <label class="form-label"> Number</label>
    <input
      type="text"
      name="number"
      class="form-control"
      placeholder="ICD Number"
      value="{{ old('number', $iCD10->number ?? '')}}"
    >
  </div>

  <div class="col-12 col-md-12">
    <label class="form-label"> Group</label>
    <input
      type="text"
      name="group"
      class="form-control"
      placeholder="ICD Group"
      value="{{ old('group', $iCD10->group ??  '')}}"
    />
  </div>

  <div class="col-12 text-center">
    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
            aria-label="Close">Cancel</button>
  </div>
</form>
