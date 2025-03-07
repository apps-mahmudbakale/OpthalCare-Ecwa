<!-- Edit User Modal -->
<div class="modal fade" id="modal-new-tag" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">New Patient Tag</h3>
                </div>
                <form action="{{ route('app.tags.store') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-9 col-md-9">
                        <label class="form-label"> Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Name" />
                    </div>
                    <div class="col-2 col-md-2">
                        <label class="form-label">Label</label>
                        <select class="form-control" name="color" id="">
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
                            aria-label="Close">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Edit User Modal -->
