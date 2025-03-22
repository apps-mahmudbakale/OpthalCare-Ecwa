<!-- Edit User Modal -->
<div wire:ignore.self class="modal fade" id="edit-speciality-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Edit Speciality</h3>
                </div>
                <form wire:submit.prevent="updateSpeciality" class="row g-3">
                    <div class="col-12 col-md-12">
                        <label class="form-label"> Name</label>
                        <input type="text" name="name" wire:model.prevent="SpecialityName" class="form-control" />
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label"> Price</label>
                        <input type="number" name="price" wire:model.prevent="SpecialityPrice" class="form-control"
                            placeholder="Price" />
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label">Follow Up Price</label>
                        <input type="number" name="follow_up_price" wire:model.prevent="SpecialityFollowUpPrice"
                            class="form-control" placeholder="Follow Up Price" />
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
