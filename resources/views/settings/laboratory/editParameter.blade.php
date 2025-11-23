<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<div class="text-center mb-4">
    <h3 class="mb-2">Update Lab Parameter</h3>
</div>
<form action="{{ route('app.lab-parameter.update', $parameter->id) }}" method="POST" class="row g-3">
    @csrf
    @method('PUT')
    <div class="col-12 col-md-12">
        <label class="form-label"> Name</label>
        <input type="text" name="name" value="{{ old('name', isset($parameter) ? $parameter->name : '') }}"
            class="form-control" placeholder="Laboratory Test Parameter" />
    </div>
    <div class="col-12 text-center">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
            aria-label="Close">Cancel</button>
    </div>
</form>
