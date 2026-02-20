<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<div class="text-center mb-4">
    <h3 class="mb-2">Edit Consumable Category</h3>
</div>
<form action="{{ route('consumables-category.update', $category->id) }}" method="POST" class="row g-3">
    @csrf
    @method('PUT')
    <div class="col-12 col-md-12">
        <label class="form-label">Name</label>
        <input type="text" name="name" value="{{ $category->name }}" class="form-control" />
    </div>
    <div class="col-12 text-center">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
    </div>
</form>
