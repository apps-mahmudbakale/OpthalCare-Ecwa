<div wire:ignore.self class="modal fade" id="edit-hmo-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit HMO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="updateHmo">
                    <div class="form-group">
                        Name
                        <input type="text" name="name" wire:model.prevent="HmoName"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        Phone
                        <input type="text" name="phone" wire:model.prevent="HmoPhone"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        Email
                        <input type="emil" name="email" wire:model.prevent="HmoEmail"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        Address
                        <input type="text" name="address" wire:model.prevent="HmoAddress"
                            class="form-control">
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="submit" class="btn bg-gradient-primary">Save</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>