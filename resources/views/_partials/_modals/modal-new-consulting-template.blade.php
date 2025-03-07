<!-- Edit User Modal -->
<div wire:ignore.self class="modal fade" id="new-consulting-template-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">New Consultation Template
                    </h3>
                </div>
                <form action="{{ route('app.consulting-templates.store') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-12 col-md-12">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>
                    <div class="col-12 col-md-12" style="margin-bottom:97px;">
                        <label class="form-label"> Content</label>
                        <textarea name="body" id="body" style="display: none;" class="form-control"></textarea>
                        <div id="editor">

                        </div>
                    </div>
                    <div class="col-12 text-center ">
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
