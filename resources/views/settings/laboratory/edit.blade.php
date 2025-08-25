<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<div class="text-center mb-4">
  <h3 class="mb-2">Update Lab Test</h3>
</div>
<form action="{{ route('app.lab-test.update', $lab->id) }}" method="POST" class="row g-3">
  @csrf
  @method('PUT')
  <div class="col-12 col-md-12">
    <label class="form-label"> Name</label>
    <input type="text" name="name" value="{{old('name', isset($lab) ? $lab->name : '')}}" class="form-control" placeholder="Name" />
  </div>
  <div class="col-12 col-md-12">
    <label class="form-label">Lab Category</label>
    <select name="category_id" id="" class="form-control">
      <option selected value="{{ $lab->category->id }}">{{ $lab->category->name }}</option>
      @foreach (\App\Models\LabCategory::all() as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-12 col-md-12">
    <label class="form-label"> Price</label>
    <input type="number" name="price" value="{{old('price', isset($lab) ? $lab->price : '')}}" class="form-control" placeholder="Price" />
  </div>
  <div class="col-12 col-md-12">
    <label class="form-label">Template</label>
    <select name="template_id" id="" class="form-control">
      <option value="">----</option>
      @foreach (\App\Models\LabTemplate::all() as $template)
        <option value="{{ $template->id }}">{{ $template->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-12 text-center">
    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
            aria-label="Close">Cancel</button>
  </div>
</form>
