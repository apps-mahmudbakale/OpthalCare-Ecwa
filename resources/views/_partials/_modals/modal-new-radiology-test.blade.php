<!-- Edit User Modal -->
<div class="modal fade" id="new-radiology-test-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">New Radiology Test</h3>
                </div>
                <form action="{{ route('app.radiology-test.store') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-12 col-md-12">
                        <label class="form-label"> Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Name" />
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label">Radiology Category</label>
                        <select name="category_id" id="" class="form-control">
                            <option value="">----</option>
                            @foreach (\App\Models\RadiologyCategory::all() as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label"> Price</label>
                        <input type="number" name="price" class="form-control" placeholder="Price" />
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label">Template</label>
                        <select name="template_id" id="" class="form-control">
                            <option value="">----</option>
                            @foreach (\App\Models\RadiologyTemplate::all() as $template)
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
            </div>
        </div>
    </div>
</div>
<!--/ Edit User Modal -->
