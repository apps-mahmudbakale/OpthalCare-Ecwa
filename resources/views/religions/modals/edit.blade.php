<div wire:ignore.self class="modal fade" id="edit-religion-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Religion</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="updateReligion">
                    <div class="form-group" wire:ignore>
                        Name
                        <input type="text" name="name" wire:model.prevent="ReligionName"
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