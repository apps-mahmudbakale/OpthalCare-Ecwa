<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<div class="text-center mb-4">
  <h3 class="mb-2">Update Patient Tag</h3>
</div>
<form action="{{ route('app.tags.update', $tag->id) }}" method="POST" class="row g-3">
  @csrf
  @method('PUT')
  <div class="col-9 col-md-9">
    <label class="form-label"> Name</label>
    <input type="text" name="name" value="{{$tag->name}}" class="form-control" placeholder="Name" />
  </div>
  <div class="col-2 col-md-2">
    <label class="form-label">Label</label>
    <select class="form-control" name="color" id="">
      <option selected value="{{$tag->color}}">{{$tag->color}}</option>
      <option value="primary">Purple</option>
      <option value="secondary">Grey</option>
      <option value="success">Green</option>
      <option value="dark">Black</option>
      <option value="info">Cyan</option>
      <option value="warning">Orange</option>
    </select>
  </div>
  <div class="col-12 text-center">
    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
            aria-label="Close">Cancel
    </button>
  </div>
</form>
