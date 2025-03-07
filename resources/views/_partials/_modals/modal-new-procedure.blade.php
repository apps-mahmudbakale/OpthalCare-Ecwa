<!-- Edit User Modal -->
<div class="modal fade" id="new-procedure-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">New Procedure </h3>
                </div>
                <form action="{{ route('app.procedure.store') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-6 col-md-6">
                        <label class="form-label"> Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Name" />
                    </div>
                    <div class="col-6 col-md-6">
                        <label class="form-label">Category</label>
                        <select name="category_id" id="" class="form-control">
                            <option value="">----</option>
                            @foreach (\App\Models\ProcedureCategory::all() as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-6">
                        <label class="form-label"> Procedure Cost</label>
                        <input type="text" name="procedure_cost" class="form-control" placeholder="Procedure Cost" />
                    </div>
                    <div class="col-6 col-md-6">
                        <label class="form-label"> Theatre Cost</label>
                        <input type="text" name="theatre_cost" class="form-control" placeholder="Theatre Cost" />
                    </div>
                    <div class="col-6 col-md-6">
                        <label class="form-label">Anaesthesia Name</label>
                        <input type="text" name="anaesthesia_cost" class="form-control"
                            placeholder="Anaesthesia Name" />
                    </div>
                    <div class="col-6 col-md-6">
                        <label class="form-label"> Surgeon Cost</label>
                        <input type="text" name="surgeon_fee" class="form-control" placeholder="Surgeon Cost" />
                    </div>
                    <div class="col-12 col-md-12">

                        <input class="form-check-input input-filter" type="checkbox" id="select-active"
                            data-value="active" checked>
                        <label class="form-check-label" for="select-active">Enable Theatre</label>
                        <div>
                            <small>Procedure is done in the Theatre.</small>
                        </div>
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
